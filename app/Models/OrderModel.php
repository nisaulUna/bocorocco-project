<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'address_id',
        'status',
        'total',
        'note',
        'promo_code',
        'ordered_at',
        'completed_at',
    ];
}
