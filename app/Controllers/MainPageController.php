<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\OrderDetailModel;

class MainPageController extends BaseController
{
    protected $productModel;
    protected $orderDetailModel;
    protected $products;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderDetailModel = new OrderDetailModel();

        // Load product data from JSON file
        $json = file_get_contents(FCPATH . 'data/products.json');
        $this->products = json_decode($json, true);
    }

    // Filter product data from JSON based on given array of product IDs
    private function filterProductsByIds($ids)
    {
        return array_values(array_filter($this->products, fn($p) => in_array($p['id'], $ids)));
    }

    // Main page showing featured sections: What's New, Best-Selling, Men, and Women
    public function index()
    {
        $newestIds      = $this->productModel->getNewestProductIds();
        $bestSellingIds = $this->orderDetailModel->getBestSellingProductIds();
        $menIds         = array_slice($this->productModel->getMenProductIds(), 0, 7);
        $womenIds       = array_slice($this->productModel->getWomenProductIds(), 0, 7);

        $data = [
            'whatsNew'    => $this->filterProductsByIds($newestIds),
            'bestSelling' => $this->filterProductsByIds($bestSellingIds),
            'moreMen'     => $this->filterProductsByIds($menIds),
            'moreWomen'   => $this->filterProductsByIds($womenIds)
        ];

        return view('Pages/mainPage', $data);
    }

    // Show all Men's Shoes page
    public function men()
    {
        $ids = $this->productModel->getMenProductIds();
        $data['products'] = $this->filterProductsByIds($ids);
        return view('Pages/productMansPage', $data);
    }

    // Show all Women's Shoes page
    public function women()
    {
        $ids = $this->productModel->getWomenProductIds();
        $data['products'] = $this->filterProductsByIds($ids);
        return view('Pages/productWomensPage', $data);
    }
}