<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\OrderDetailModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $cartModel;
    protected $products;
    protected $orderDetailModel;

    // Mapping color names to their corresponding HEX codes for display
    private $colorMap = [
        'nero'     => '#000000',
        'bianco'   => '#ffffff',
        'marrone'  => '#4B3621',
        'testa'    => '#5A3825',
        'platinum' => '#C0C0C0',
        'tan'      => '#D2B48C',
        'cognac'   => '#9C6644',
        'rosso'    => '#B22222',
        'navy'     => '#000080',
        'nevy'     => '#000080',
        'arancione'=> '#FFA500',
        'moro'     => '#362C2A',
        'taupe'    => '#B38B6D',
    ];

    public function __construct()
    {
        $this->productModel     = new ProductModel();
        $this->cartModel        = new CartModel();
        $this->orderDetailModel = new OrderDetailModel();

        // Load products data from JSON file
        $json = file_get_contents(FCPATH . 'data/products.json');
        $this->products = json_decode($json, true);
    }

    // Filter product data by given array of product IDs
    private function filterProductsByIds($ids)
    {
        return array_values(array_filter($this->products, fn($p) => in_array($p['id'], $ids)));
    }

    // Show product detail page
    public function detail($id, $color = null)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        // Determine which color to show (default to first if invalid)
        $selectedColor = $color && in_array($color, $product['colors']) ? $color : $product['colors'][0];

        // Get other best-selling product IDs (excluding current product)
        $bestSellingIds = $this->orderDetailModel->getBestSellingProductIds();

        $data = [
            'product'        => $product,
            'selectedColor'  => $selectedColor,
            'recommended'    => $this->filterProductsByIds(array_filter($bestSellingIds, fn($pid) => $pid != $id)),
            'colorMap'       => $this->colorMap
        ];

        return view('Pages/productDetailPage', $data);
    }
}
