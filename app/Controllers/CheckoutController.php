<?php

namespace App\Controllers;

use App\Models\{
    CartModel,
    ProductModel,
    PaymentModel,
    UserAddressModel,
    PromoModel,
    OrderModel,
    OrderDetailModel
};

class CheckoutController extends BaseController
{
    // Declare models used in this controller
    protected $cartModel, $productModel, $paymentModel, $addressModel,
              $promoModel, $orderModel, $orderDetailModel;

    public function __construct()
    {
        // Initialize all models
        $this->cartModel         = new CartModel();
        $this->productModel      = new ProductModel();
        $this->paymentModel      = new PaymentModel();
        $this->addressModel      = new UserAddressModel();
        $this->promoModel        = new PromoModel();
        $this->orderModel        = new OrderModel();
        $this->orderDetailModel  = new OrderDetailModel(); 
    }

    // Main checkout page
    public function index()
    {
        $userId = session('user_id') ?? 1; // default to user ID 1
        $cartItems = $this->cartModel->getUserCart($userId); // get cart data

        $products = [];
        $subtotal = 0;

        // Loop through cart and calculate subtotal
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

        $address = $this->addressModel->getUserAddress($userId); // Get user's shipping address

        // Determine shipping cost based on city
        $shippingData = $this->getShippingCost($address['city']);
        $shippingCost = $shippingData['cost'];
        $inJabodetabek = $shippingData['is_jabodetabek'];
        $serviceFee = 2500; // fixed admin fee
        $promos = $this->promoModel->getAvailablePromos($userId); // load available promos

        // Load checkout view
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

    // Apply promo code
    public function applyPromo()
    {
        $userId = session('user_id') ?? 1;
        $promoCode = $this->request->getPost('promo_code');

        // Validate promo
        $promo = $this->promoModel->validatePromo($promoCode, $userId);
        if ($promo) {
            $this->promoModel->markAsUsed($userId, $promo['id']);
            session()->set('used_promo_id', $promo['id']);
            return redirect()->back()->with('success', 'Promo applied successfully!');
        }

        return redirect()->back()->with('error', 'Invalid promo code.');
    }

    // Handle checkout/payment logic
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

        // Get shipping cost again for accuracy
        $shipping = $this->getShippingCost($address['city'] ?? '');
        $shippingCost = $shipping['cost'];
        $adminFee = 2500;

        $subtotal = 0;
        $orderDetails = [];

        // Prepare order detail items
        foreach ($cartItems as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            if (!$product) continue;

            $subtotal += $product['price'] * $item['quantity'];
            $orderDetails[] = [
                'product_id' => $item['product_id'],
                'color'      => $item['color'],
                'size'       => $item['size'],
                'quantity'   => $item['quantity'],
                'unit_price' => $product['price']
            ];
        }

        // Apply promo discount if any
        $promoId = session('used_promo_id') ?? null;
        $promo = $promoId ? $this->promoModel->find($promoId) : null;
        $discount = $promo['discount_value'] ?? 0;

        $total = $subtotal + $shippingCost + $adminFee - $discount;

        // Insert new order
        $orderId = $this->orderModel->insert([
            'user_id'    => $userId,
            'address_id' => $address['id'],
            'total'      => $total,
            'promo_code' => $promo['code'] ?? null,
            'note'       => null,
            'ordered_at' => date('Y-m-d H:i:s'),
        ]);

        // Save order details
        foreach ($orderDetails as &$detail) {
            $detail['order_id'] = $orderId;
        }
        $this->orderDetailModel->insertBatch($orderDetails); 

        // Generate virtual account number
        $bank = $this->request->getPost('payment_method');
        $vaNumber = 'VA' . str_pad($orderId, 8, '0', STR_PAD_LEFT);

        // Save payment data
        $this->paymentModel->insert([
            'order_id'     => $orderId,
            'user_id'      => $userId,
            'method'       => $bank,
            'total'        => $total,
            'admin_fee'    => $adminFee,
            'shipping_fee' => $shippingCost,
            'virtual_code' => $vaNumber,
            'status'       => 'pending',
            'expires_at'   => date('Y-m-d H:i:s', strtotime('+24 hours')),
        ]);

        // Clear cart after successful order
        $this->cartModel->clearUserCart($userId);

        return $this->response->setJSON(['va' => $vaNumber]);
    }

    // Determine shipping cost based on city keyword
    private function getShippingCost($city)
    {
        $city = strtolower($city);
        $jabodetabekKeywords = ['jakarta', 'bogor', 'depok', 'tangerang', 'bekasi'];
        $inJabodetabek = false;

        foreach ($jabodetabekKeywords as $keyword) {
            if (stripos($city, $keyword) !== false) {
                $inJabodetabek = true;
                break;
            }
        }

        $shippingCost = $inJabodetabek ? 10000 : 20000;

        return [
            'cost' => $shippingCost,
            'is_jabodetabek' => $inJabodetabek
        ];
    }
}
