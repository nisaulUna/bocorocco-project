<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Path ke file JSON di public/data/products.json
        $filePath = FCPATH . 'data/products.json';

        // Baca file JSON
        $json = file_get_contents($filePath);
        $products = json_decode($json, true);

        foreach ($products as $product) {
            // Cek apakah produk sudah ada berdasarkan ID
            $exists = $this->db->table('products')->where('id', $product['id'])->get()->getRow();

            if (!$exists) {
                // Insert ke tabel products
                $this->db->table('products')->insert([
                    'id'            => $product['id'],
                    'name'          => $product['name'],
                    'price'         => $product['price'],
                    'category'         => $product['category'],
                    'release_date'  => $product['release_date'], 
                ]);

                // Insert ke tabel product_variants
                foreach ($product['colors'] as $color) {
                    foreach ($product['sizes'] as $size) {
                        // Cek apakah kombinasi variant sudah ada
                        $variantExists = $this->db->table('product_variants')
                            ->where([
                                'product_id' => $product['id'],
                                'size'       => $size,
                                'color'      => strtolower($color),
                            ])
                            ->get()
                            ->getRow();

                        if (!$variantExists) {
                            $this->db->table('product_variants')->insert([
                                'product_id' => $product['id'],
                                'size'       => $size,
                                'color'      => strtolower($color),
                                'stock'      => 10,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
