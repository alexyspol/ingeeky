<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TicketModel;
use App\Models\UserActivityModel;

class DashboardController extends BaseController
{
    protected $userModel;
    protected $ticketModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->ticketModel = new TicketModel();
        date_default_timezone_set("America/Sao_Paulo");

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        if (!auth()->user()?->inGroup('admin')) {
            return redirect()->to('/')->with('error', 'Unauthorized access');
        }

        // Get all users
        $users = $this->userModel->findAll();

        // Get active sessions from session storage
        $activeSessions = $this->getActiveSessions();

        // Add online status for each user
        foreach ($users as $user) {
            $user->is_admin = auth()->getProvider()->findById($user->id)?->inGroup('admin') ?? false;
            $user->is_online = isset($activeSessions[$user->id]);
            $user->last_activity = $activeSessions[$user->id] ?? null;
        }

        // Get ticket statistics
        $ticketStats = [
            'total' => $this->ticketModel->countAll(),
            'open' => $this->ticketModel->where('status', 'open')->countAllResults(),
            'closed' => $this->ticketModel->where('status', 'closed')->countAllResults(),
            'awaiting' => $this->ticketModel->where('status', 'awaiting')->countAllResults(),
        ];

        // Count online users
        $onlineUsers = array_filter($users, fn($user) => $user->is_online);

        $data = [
            'title' => 'Admin Dashboard',
            'users' => $users,
            'ticketStats' => $ticketStats,
            'onlineUsers' => count($onlineUsers),
            'activeTickets' => $ticketStats['open'],
            'pendingTickets' => $ticketStats['awaiting'],
            'recentActivity' => $this->getRecentActivity()
        ];

        $activityModel = new UserActivityModel();
        $data['recentActivity'] = $activityModel->getRecent(15);

        foreach ($data['recentActivity'] as &$activity) {
            $user = $this->userModel->find($activity['user_id']);
            if ($user) {
                $activity['display_name'] = $user->fullname ?: $user->username;
            } else {
                $activity['display_name'] = 'Unknown User';
            }
        }
        unset($activity);

        return view('dashboard/index', $data);
    }

    private function getActiveSessions()
    {
        // Clean old sessions first
        $this->cleanOldSessions();

        // Return active sessions
        return session()->get('active_users') ?? [];
    }

    private function cleanOldSessions()
    {
        $activeSessions = session()->get('active_users') ?? [];
        $now = time();

        // Remove sessions older than 15 minutes
        foreach ($activeSessions as $userId => $lastActivity) {
            if ($now - strtotime($lastActivity) > 900) { // 15 minutes
                unset($activeSessions[$userId]);
            }
        }

        session()->set('active_users', $activeSessions);
    }

    private function getRecentActivity()
    {
        $recentActivity = session()->get('recent_activity') ?? [];
        return array_slice($recentActivity, 0, 10);
    }

    public function getStats()
    {
        if ($this->request->isAJAX()) {
            $activeSessions = $this->getActiveSessions();
            $users = $this->userModel->findAll();

            foreach ($users as $user) {
                $user->is_admin = auth()->getProvider()->findById($user->id)?->inGroup('admin') ?? false;
                $user->is_online = isset($activeSessions[$user->id]);
                $user->last_activity = $activeSessions[$user->id] ?? null;
            }

            $ticketStats = [
                'total' => $this->ticketModel->countAll(),
                'open' => $this->ticketModel->where('status', 'open')->countAllResults(),
                'closed' => $this->ticketModel->where('status', 'closed')->countAllResults(),
                'awaiting' => $this->ticketModel->where('status', 'awaiting')->countAllResults(),
            ];

            return $this->response->setJSON([
                'success' => true,
                'stats' => [
                    'ticketStats' => $ticketStats,
                    'onlineUsers' => count(array_filter($users, fn($user) => $user->is_online)),
                    'userStatuses' => $users
                ]
            ]);
        }

        return $this->response->setStatusCode(403);
    }

    public function updateUserActivity()
    {
        if ($this->request->isAJAX()) {
            $userId = auth()->id();
            if ($userId) {
                $activeSessions = session()->get('active_users') ?? [];
                $activeSessions[$userId] = date('Y-m-d H:i:s');
                session()->set('active_users', $activeSessions);

                // Add to recent activity
                $recentActivity = session()->get('recent_activity') ?? [];
                array_unshift($recentActivity, [
                    'icon' => 'circle',
                    'description' => auth()->user()->username . ' is active',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                $recentActivity = array_slice($recentActivity, 0, 10);
                session()->set('recent_activity', $recentActivity);

                return $this->response->setJSON(['success' => true]);
            }
        }
        return $this->response->setStatusCode(403);
    }
}