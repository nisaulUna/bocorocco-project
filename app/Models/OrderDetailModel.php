<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailModel extends Model
{
    protected $table      = 'order_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
    'order_id', 'product_id', 'size', 'color', 'quantity', 'unit_price'
];


    // Get top 6 best-selling product IDs based on total quantity ordered
    public function getBestSellingProductIds()
    {
        return $this->select('product_id')
                    ->selectCount('product_id', 'total') 
                    ->groupBy('product_id')              
                    ->orderBy('total', 'DESC')           
                    ->limit(6)                           
                    ->findColumn('product_id');   
    }
}
