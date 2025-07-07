<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SearchLogModel;

class SearchController extends BaseController
{
    protected $productModel;
    protected $searchLogModel;
    protected $products;

    public function __construct()
    {
        $this->productModel     = new ProductModel();
        $this->searchLogModel   = new SearchLogModel();

        // Load product data from JSON file
        $json = file_get_contents(FCPATH . 'data/products.json');
        $this->products = json_decode($json, true);
    }

    // Handle product search and display search results
    public function index()
    {
        $query  = $this->request->getGet('q');
        $userId = session('user_id') ?? 1;

        // Filter products whose name or description matches the query
        $filtered = array_filter($this->products, function ($p) use ($query) {
            return stripos($p['name'], $query) !== false ||
                   stripos($p['description'], $query) !== false;
        });

        // Log the search keyword to the database
        $this->searchLogModel->insert([
            'user_id'    => $userId,
            'keyword'    => $query,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $data = [
            'query'       => $query,
            'results'     => array_values($filtered), // Reset array keys
            'recentTags'  => $this->searchLogModel->getRecentTags($userId), // Recent searches by user
            'popularTags' => $this->searchLogModel->getPopularTags()        // Popular searches across users
        ];

        return view('Pages/searchResultsPage', $data);
    }
}