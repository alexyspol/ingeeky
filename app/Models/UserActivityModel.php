<?php

namespace App\Models;

use CodeIgniter\Model;

class UserActivityModel extends Model
{
    protected $table      = 'user_activity_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'action', 'ip_address', 'user_agent', 'created_at'
    ];

    protected $useTimestamps = false;

    public function getRecent($limit = 10)
    {
        return $this->select("$this->table.*, users.username")
            ->join('users', "users.id = $this->table.user_id", 'left')
            ->orderBy("$this->table.created_at", 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
