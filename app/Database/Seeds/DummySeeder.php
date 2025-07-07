<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummySeeder extends Seeder
{
    public function run()
    {
        // users
        $this->db->table('users')->insert([
            'id' => 1,
            'name' => 'Nisaul Husna',
            'email' => 'nisaulhusnaaa@gmail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'phone' => '081315225350',
            'gender' => 'Female',

        ]);
         $this->db->table('users')->insert([
            'id' => 2,
            'name' => 'Fatin Syahira',
            'email' => 'fatin@gmail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'phone' => '081315225359',
            'gender' => 'Female',

        ]);
         $this->db->table('users')->insert([
            'id' => 3,
            'name' => 'Bima Satria',
            'email' => 'bima@gmail.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'phone' => '081315225357',
            'gender' => 'Male',
        ]);

        // user_addresses 
        $this->db->table('user_addresses')->insert([
            'user_id' => 1,
            'province' => 'Banten',
            'city' => 'Tangerang Selatan',
            'district' => 'Ciputat',
            'full_address' => 'Jl. Ciater No. 18'
        ]);
         $this->db->table('user_addresses')->insert([
            'user_id' => 2,
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'full_address' => 'Jl. Baru No. 20'
        ]);
        $this->db->table('user_addresses')->insert([
            'user_id' => 3,
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Lama',
            'full_address' => 'Jl. Lama No. 30'
        ]);

        // favorites 
        $this->db->table('favorites')->insert([
            'user_id' => 1,
            'product_id' => 19
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 1,
            'product_id' => 6
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 1,
            'product_id' => 28
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 2,
            'product_id' => 14
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 2,
            'product_id' => 4
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 2,
            'product_id' => 25
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 3,
            'product_id' => 22
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 3,
            'product_id' => 30
        ]);
        $this->db->table('favorites')->insert([
            'user_id' => 3,
            'product_id' => 7
        ]);

        // Order user id-1
        $this->db->table('orders')->insert([
            'id' => 1,
            'user_id' => 1,
            'address_id' => 1,
            'status' => 'completed',
            'total' => 10670000,
            'ordered_at' => '2025-07-02 14:00:00',
            'completed_at' => '2025-07-04 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 1,
            'product_id' => 11,
            'size' => '40',
            'color' => 'bianco',
            'quantity' => 2,
            'unit_price' => 3690000
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 1,
            'product_id' => 7,
            'size' => '41',
            'color' => 'platinum',
            'quantity' => 1,
            'unit_price' => 3290000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 1,
            'user_id' => 1,
            'method' => 'BCA',
            'total' => 10682500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA1',
            'status' => 'paid',
            'expires_at' => '2025-07-03 14:30:00',
            'paid_at' => '2025-07-02 14:30:00'
        ]);

        $this->db->table('orders')->insert([
            'id' => 2,
            'user_id' => 1,
            'address_id' => 1,
            'status' => 'completed',
            'total' => 1745000,
            'ordered_at' => '2025-06-10 14:00:00',
            'completed_at' => '2025-06-12 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 2,
            'product_id' => 12,
            'size' => '39',
            'color' => 'bianco',
            'quantity' => 1,
            'unit_price' => 1745000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 2,
            'user_id' => 1,
            'method' => 'BCA',
            'total' => 1757500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA2',
            'status' => 'paid',
            'expires_at' => '2025-06-11 14:30:00',
            'paid_at' => '2025-06-10 14:30:00'
        ]);

        $this->db->table('orders')->insert([
            'id' => 3,
            'user_id' => 1,
            'address_id' => 1,
            'status' => 'completed',
            'total' => 10380000,
            'ordered_at' => '2025-06-11 14:00:00',
            'completed_at' => '2025-06-14 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 3,
            'product_id' => 25,
            'size' => '44',
            'color' => 'nero',
            'quantity' => 2,
            'unit_price' => 5190000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 3,
            'user_id' => 1,
            'method' => 'BCA',
            'total' => 10392500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA3',
            'status' => 'paid',
            'expires_at' => '2025-06-12 14:30:00',
            'paid_at' => '2025-06-11 14:30:00'
        ]);

        // Order user id-2
        $this->db->table('orders')->insert([
            'id' => 4,
            'user_id' => 2,
            'address_id' => 2,
            'status' => 'completed',
            'total' => 4890000,
            'ordered_at' => '2025-07-03 14:00:00',
            'completed_at' => '2025-07-05 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 4,
            'product_id' => 18,
            'size' => '43',
            'color' => 'testa',
            'quantity' => 1,
            'unit_price' => 4890000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 4,
            'user_id' => 2,
            'method' => 'BRI',
            'total' => 4902500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA4',
            'status' => 'paid',
            'expires_at' => '2025-07-04 14:30:00',
            'paid_at' => '2025-07-03 14:30:00'
        ]);

        $this->db->table('orders')->insert([
            'id' => 5,
            'user_id' => 2,
            'address_id' => 2,
            'status' => 'completed',
            'total' => 7580000,
            'ordered_at' => '2025-07-03 14:00:00',
            'completed_at' => '2025-07-06 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 5,
            'product_id' => 27,
            'size' => '40',
            'color' => 'tan',
            'quantity' => 1,
            'unit_price' => 4190000
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 5,
            'product_id' => 1,
            'size' => '38',
            'color' => 'nero',
            'quantity' => 1,
            'unit_price' => 3390000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 5,
            'user_id' => 2,
            'method' => 'BRI',
            'total' => 7592500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA5',
            'status' => 'paid',
            'expires_at' => '2025-07-04 14:30:00',
            'paid_at' => '2025-07-03 14:30:00'
        ]);

       $this->db->table('orders')->insert([
            'id' => 6,
            'user_id' => 2,
            'address_id' => 2,
            'status' => 'completed',
            'total' => 1745000,
            'ordered_at' => '2025-06-26 14:00:00',
            'completed_at' => '2025-06-29 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 6,
            'product_id' => 12,
            'size' => '39',
            'color' => 'bianco',
            'quantity' => 1,
            'unit_price' => 1745000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 6,
            'user_id' => 2,
            'method' => 'BRI',
            'total' => 1757500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA6',
            'status' => 'paid',
            'expires_at' => '2025-06-27 14:30:00',
            'paid_at' => '2025-06-26 14:30:00'
        ]);
       
       // User order id-3
        $this->db->table('orders')->insert([
            'id' => 7,
            'user_id' => 3,
            'address_id' => 3,
            'status' => 'completed',
            'total' => 14960000,
            'ordered_at' => '2025-07-03 14:00:00',
            'completed_at' => '2025-07-06 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 7,
            'product_id' => 24,
            'size' => '45',
            'color' => 'nero',
            'quantity' => 2,
            'unit_price' => 3290000
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 7,
            'product_id' => 16,
            'size' => '43',
            'color' => 'nero',
            'quantity' => 2,
            'unit_price' => 4190000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 7,
            'user_id' => 3,
            'method' => 'Mandiri',
            'total' => 14972500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA7',
            'status' => 'paid',
            'expires_at' => '2025-07-04 14:30:00',
            'paid_at' => '2025-07-03 14:30:00'
        ]);

        $this->db->table('orders')->insert([
            'id' => 8,
            'user_id' => 3,
            'address_id' => 3,
            'status' => 'completed',
            'total' => 4190000,
            'ordered_at' => '2025-07-02 14:00:00',
            'completed_at' => '2025-07-04 14:30:00'
        ]);
        $this->db->table('order_details')->insert([
            'order_id' => 8,
            'product_id' => 16,
            'size' => '43',
            'color' => 'nero',
            'quantity' => 1,
            'unit_price' => 4190000
        ]);
        $this->db->table('payments')->insert([
            'order_id' => 8,
            'user_id' => 3,
            'method' => 'Mandiri',
            'total' => 4202500,
            'admin_fee' => 2500,
            'shipping_fee' => 10000,
            'virtual_code' => 'VA8',
            'status' => 'paid',
            'expires_at' => '2025-07-03 14:30:00',
            'paid_at' => '2025-07-02 14:30:00'
        ]);

       // search_logs
        $this->db->table('search_logs')->insert([
            'user_id' => 1,
            'keyword' => 'women shoes'
        ]);
        $this->db->table('search_logs')->insert([
            'user_id' => 1,
            'keyword' => 'sandal'
        ]);
        $this->db->table('search_logs')->insert([
            'user_id' => 2,
            'keyword' => 'sepatu boot'
        ]);
        $this->db->table('search_logs')->insert([
            'user_id' => 2,
            'keyword' => 'sandal'        ]);
        $this->db->table('search_logs')->insert([
            'user_id' => 3,
            'keyword' => 'flatshoes'
        ]);
        $this->db->table('search_logs')->insert([
            'user_id' => 3,
            'keyword' => 'sepatu boot'
        ]); 

        // promos
        $this->db->table('promos')->insert([
            'id' => 1,
            'code' => 'DISKONMANDIRI',
            'description' => 'Diskon 20% untuk pembayaran Mandiri',
            'method_required' => 'Mandiri',
            'min_transaction' => 5000000,
            'discount_percent' => 20,
            'max_discount' => 100000,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+7 days')),
            'is_active' => true
        ]);
        $this->db->table('promos')->insert([
            'id' => 2,
            'code' => 'HEMATBRI',
            'description' => 'Diskon Rp50.000 untuk pembayaran BRI',
            'method_required' => 'BRI',
            'min_transaction' => 300000,
            'discount_value' => 50000,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d', strtotime('+5 days')),
            'is_active' => true
        ]);

        // notifications
        $this->db->table('notifications')->insert([
            'user_id'    => null, // umum
            'title'      => 'Promo Baru: DISKONMANDIRI',
            'description'=> 'Diskon 20% untuk pembayaran Mandiri',
            'category'   => 'announcement',
            'date'       => date('Y-m-d')
        ]);
        $this->db->table('notifications')->insert([
            'user_id'    => null,
            'title'      => 'Promo Baru: HEMATBRI',
            'description'=> 'Diskon Rp50.000 untuk pembayaran BRI',
            'category'   => 'announcement',
            'date'       => date('Y-m-d')
        ]);
    }
}
