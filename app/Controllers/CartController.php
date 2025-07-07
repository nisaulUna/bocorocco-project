<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $cartModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel    = new CartModel();
        $this->productModel = new ProductModel();
    }

    // Display the cart page with products and their details
    public function index()
    {
        $userId = session('user_id') ?? 1;
        $cartItems = $this->cartModel->getUserCart($userId);
        $products = [];

        foreach ($cartItems as $item) {
            $product = $this->productModel->getProductById($item['product_id']);
            if ($product) {
                // Append cart-specific info to product
                $product['size'] = $item['size'];
                $product['color'] = $item['color'];
                $product['quantity'] = $item['quantity'];
                $products[] = $product;
            }
        }

        return view('Pages/cartPage', ['products' => $products]);
    }

    // Handle adding a product to the cart
    public function addToCart()
    {
        $userId    = session('user_id') ?? 1;
        $productId = $this->request->getPost('product_id');
        $color     = $this->request->getPost('color');
        $size      = $this->request->getPost('size');

        $existing = $this->cartModel->getItem($userId, $productId, $size, $color);

        if ($existing) {
            // Increase quantity if item already exists
            $this->cartModel->increaseQuantity($existing['id'], $existing['quantity']);
        } else {
            // Insert new cart item
            $this->cartModel->save([
                'user_id'    => $userId,
                'product_id' => $productId,
                'color'      => $color,
                'size'       => $size,
                'quantity'   => 1
            ]);
        }

        return redirect()->to('/cart')->with('message', 'Item has been added to your cart.');
    }

    // Handle quantity update (plus or minus) for a specific cart item
    public function updateQuantity($productId, $color, $size, $action)
    {
        $userId = session('user_id') ?? 1;
        $item = $this->cartModel->getItem($userId, $productId, $size, $color);

        if ($item) {
            if ($action === 'plus') {
                // Increase quantity
                $this->cartModel->increaseQuantity($item['id'], $item['quantity']);
                session()->setFlashdata('message', 'Quantity updated.');
            } elseif ($action === 'minus') {
                if ($item['quantity'] <= 1) {
                    // Prompt user to confirm deletion if quantity is 1
                    session()->setFlashdata('delete_warning', 'Do you want to remove this product?');
                    session()->setFlashdata('delete_item', [
                        'product_id' => $item['product_id'],
                        'color'      => $item['color'],
                        'size'       => $item['size']
                    ]);
                    return redirect()->to('/cart');
                }

                // Decrease quantity
                $this->cartModel->decreaseQuantity($item['id'], $item['quantity']);
                session()->setFlashdata('message', 'Quantity updated.');
            }
        }

        return redirect()->to('/cart');
    }

    // Remove item from cart
    public function delete($productId, $color, $size)
    {
        $userId = session('user_id') ?? 1;
        $this->cartModel->removeItem($userId, $productId, $size, $color);
        return redirect()->to('/cart')->with('message', 'Item has been removed from your cart.');
    }
}