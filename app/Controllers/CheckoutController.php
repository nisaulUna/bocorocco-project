<?php

namespace App\Controllers;

use App\Models\{CartModel, ProductModel, PaymentModel, UserAddressModel, PromoModel};

class CheckoutController extends BaseController
{
    protected $cartModel, $productModel, $paymentModel, $addressModel, $promoModel;

    public function __construct()
    {
        $this->cartModel     = new CartModel();
        $this->productModel  = new ProductModel();
        $this->paymentModel  = new PaymentModel();
        $this->addressModel  = new UserAddressModel();
        $this->promoModel    = new PromoModel();
    }

    public function index()
    {
        $userId = session('user_id') ?? 1;
        $cartItems = $this->cartModel->getUserCart($userId);

        $products = [];
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            if ($product) {
                $product['size']     = $item['size'];
                $product['color']    = $item['color'];
                $product['quantity'] = $item['quantity'];
                $product['subtotal'] = $product['price'] * $item['quantity'];
                $subtotal += $product['subtotal'];
                $products[] = $product;
            }
        }

        $address = $this->addressModel->getUserAddress($userId);
        $shippingData = $this->getShippingCost($address['region'] ?? '');
        $shippingCost = $shippingData['cost'];
        $inJabodetabek = $shippingData['is_jabodetabek'];
        $serviceFee = 2500;
        $promos = $this->promoModel->getAvailablePromos($userId);

        return view('Pages/checkoutPage', [
            'products'       => $products,
            'subtotal'       => $subtotal,
            'shipping'       => $shippingCost,
            'serviceFee'     => $serviceFee,
            'total'          => $subtotal + $shippingCost + $serviceFee,
            'address'        => $address,
            'promos'         => $promos,
            'inJabodetabek'  => $inJabodetabek
        ]);
    }

    public function applyPromo()
    {
        $userId = session('user_id') ?? 1;
        $promoCode = $this->request->getPost('promo_code');

        $promo = $this->promoModel->validatePromo($promoCode, $userId);
        if ($promo) {
            $this->promoModel->markAsUsed($userId, $promo['id']);
            session()->set('used_promo_id', $promo['id']);
            return redirect()->back()->with('success', 'Promo applied successfully!');
        }

        return redirect()->back()->with('error', 'Invalid or already used promo code.');
    }

    public function pay()
    {
        $userId = session('user_id') ?? 1;
        $cartItems = $this->cartModel->getUserCart($userId);
        if (empty($cartItems)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Cart is empty']);
        }

        $address = $this->addressModel->getUserAddress($userId);
        if (!$address) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Shipping address not found']);
        }

        $shipping = $this->getShippingCost($address['region'] ?? '');
        $shippingCost = $shipping['cost'];
        $serviceFee = 2500;

        $subtotal = 0;
        $orderDetails = [];

        foreach ($cartItems as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            if (!$product) continue;

            $subtotal += $product['price'] * $item['quantity'];
            $orderDetails[] = [
                'product_id'  => $item['product_id'],
                'color'       => $item['color'],
                'size'        => $item['size'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $product['price']
            ];
        }

        $promoId = session('used_promo_id') ?? null;
        $promo = $promoId ? $this->promoModel->find($promoId) : null;
        $discount = $promo['discount_value'] ?? 0;

        $total = $subtotal + $shippingCost + $serviceFee - $discount;

        // Insert main order
        $orderId = $this->paymentModel->insertOrder([
            'user_id'     => $userId,
            'address_id'  => $address['id'],
            'total'       => $total,
            'promo_code'  => $promo['code'] ?? null,
            'note'        => null,
            'ordered_at'  => date('Y-m-d H:i:s')
        ]);

        // Add order_id to each order detail
        foreach ($orderDetails as &$detail) {
            $detail['order_id'] = $orderId;
        }

        // Insert order items
        $this->paymentModel->insertOrderDetails($orderDetails);

        // Insert payment record
        $bank = $this->request->getPost('payment_method');
        $vaNumber = 'VA' . str_pad($orderId, 8, '0', STR_PAD_LEFT);

        $this->paymentModel->insertPayment([
            'order_id'     => $orderId,
            'user_id'      => $userId,
            'method'       => $bank,
            'total'        => $total,
            'admin_fee'    => $serviceFee,
            'shipping_fee' => $shippingCost,
            'virtual_code' => $vaNumber,
            'status'       => 'pending'
        ]);

        // Clear cart
        $this->cartModel->clearUserCart($userId);

        // Return virtual account number
        return $this->response->setJSON(['va' => $vaNumber]);
    }

    private function getShippingCost($region)
    {
        $region = strtolower($region);
        $inJabodetabek = in_array($region, ['jakarta', 'bogor', 'depok', 'tangerang', 'bekasi']);
        $shippingCost = $inJabodetabek ? 10000 : 20000;

        return [
            'cost' => $shippingCost,
            'is_jabodetabek' => $inJabodetabek
        ];
    }
}