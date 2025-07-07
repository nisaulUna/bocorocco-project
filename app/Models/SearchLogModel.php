<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchLogModel extends Model
{
    protected $table = 'search_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'keyword', 'created_at'];

    // Get the 5 most recent unique search keywords used by a specific user
    public function getRecentTags($userId = null)
    {
        return $this->select('keyword')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->groupBy('keyword') 
            ->limit(5)
            ->findAll();
    }

    // Get the 5 most popular keywords used across all users
    public function getPopularTags()
    {
        return $this->select('keyword, COUNT(*) as total')
            ->groupBy('keyword')
            ->orderBy('total', 'DESC') 
            ->limit(5)
            ->findAll();
    }
}
