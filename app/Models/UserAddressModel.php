<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAddressModel extends Model
{
    protected $table = 'user_addresses';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'province', 'city', 'district', 'full_address'
    ];

    // Get the full address data of a specific user
    public function getUserAddress($userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}
