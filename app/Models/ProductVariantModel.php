<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table      = 'product_variants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'size', 'color', 'stock'];

    // Get all unique colors available across product variants
    public function getAllColors()
    {
        return $this->distinct()->select('color')->findAll();
    }

    // Get all unique sizes available across product variants
    public function getAllSizes()
    {
        return $this->distinct()->select('size')->findAll();
    }
}