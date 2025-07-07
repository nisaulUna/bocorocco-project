<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'release_date', 'category'];

    // Stores products data loaded from JSON
    protected $productsJson = [];

    public function __construct()
    {
        parent::__construct();

        // Load product data from products.json at startup
        $jsonPath = FCPATH . 'data/products.json';
        if (file_exists($jsonPath)) {
            $this->productsJson = json_decode(file_get_contents($jsonPath), true);
        }
    }

    // Get full product data from JSON by ID
    public function getProductById($id)
    {
        foreach ($this->productsJson as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }
        return null;
    }

    // Get product IDs released in the last 10 days
    public function getNewestProductIds()
    {
        $dateLimit = date('Y-m-d', strtotime("-10 days"));
        $result = $this->where('release_date >=', $dateLimit)
                    ->orderBy('release_date', 'DESC')
                    ->findColumn('id');

        if (empty($result)) {
            // Return top 3 latest product IDs if no recent products found
            return $this->orderBy('release_date', 'DESC')
                        ->limit(3)
                        ->findColumn('id');
        }

        return $result;
    }

    // Get IDs of products categorized as "Men's Shoes"
    public function getMenProductIds()
    {
        return $this->where('category', "Men's Shoes")
                    ->orderBy('release_date', 'DESC')
                    ->findColumn('id');
    }

    // Get IDs of products categorized as "Women's Shoes"
    public function getWomenProductIds()
    {
        return $this->where('category', "Women's Shoes")
                    ->orderBy('release_date', 'DESC')
                    ->findColumn('id');
    }
}