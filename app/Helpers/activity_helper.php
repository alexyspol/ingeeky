<?php

use App\Models\UserActivityModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

function log_activity(string $action, ?int $userId = null): bool
{
    try {
        if ($userId === null && function_exists('auth') && auth()->loggedIn()) {
            $userId = auth()->id();
        }

        $activityModel = new UserActivityModel();

        return $activityModel->insert([
            'user_id'    => $userId,
            'action'     => $action,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent()->getAgentString(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    } catch (DatabaseException $e) {
        log_message('error', 'Activity log failed: ' . $e->getMessage());
        return false;
    }
}
