<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id', 'user_id', 'method', 'total', 'admin_fee', 'shipping_fee', 'virtual_code', 'status'
    ];
}