<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table      = 'cart';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'color', 'size', 'quantity'];

    // Clear after checkout
    public function clearUserCart($userId)
    {
        return $this->where('user_id', $userId)->delete();
    }

    // Get all cart items for a specific user
    public function getUserCart($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    // Get a specific cart item by user, product, size, and color
    public function getItem($userId, $productId, $size, $color)
    {
        return $this->where([
            'user_id'    => $userId,
            'product_id' => $productId,
            'size'       => $size,
            'color'      => $color
        ])->first();
    }

    // Increase quantity of a cart item by 1
    public function increaseQuantity($cartItemId, $currentQty)
    {
        return $this->update($cartItemId, ['quantity' => $currentQty + 1]);
    }

    // Decrease quantity of a cart item by 1 (minimum value is 1)
    public function decreaseQuantity($cartItemId, $currentQty)
    {
        return $this->update($cartItemId, ['quantity' => max(1, $currentQty - 1)]);
    }

    // Remove a specific item from the cart
    public function removeItem($userId, $productId, $size, $color)
    {
        $item = $this->getItem($userId, $productId, $size, $color);
        if ($item) {
            return $this->delete($item['id']);
        }
        return false;
    }
}