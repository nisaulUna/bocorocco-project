<?php

namespace App\Models;

use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'description', 'discount'];

    // Get all available promos that the user hasn't used yet
    public function getAvailablePromos($userId)
    {
        return $this->whereNotIn('id', function ($builder) use ($userId) {
            return $builder->select('promo_id')
                           ->from('promo_users')
                           ->where('user_id', $userId);
        })->findAll();
    }

    // Validate a promo code for a user
    // Returns the promo if valid and not used, null otherwise
    public function validatePromo($code, $userId)
    {
        $promo = $this->where('code', $code)->first();
        if (!$promo) return null;

        // Check if the user has already used this promo
        $used = db_connect()->table('promo_users')
                            ->where('user_id', $userId)
                            ->where('promo_id', $promo['id'])
                            ->countAllResults();

        return $used ? null : $promo;
    }

    // Mark a promo as used by a user
    public function markAsUsed($userId, $promoId)
    {
        db_connect()->table('promo_users')->insert([
            'user_id'  => $userId,
            'promo_id' => $promoId,
            'used_at'  => date('Y-m-d H:i:s')
        ]);
    }
}