<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Employee Dashboard',
            // You can pass data to your view here, e.g.,
            // 'totalTickets' => $this->ticketModel->countAllResults(),
            // 'recentTickets' => $this->ticketModel->orderBy('created_at', 'desc')->findAll(5),
        ];

        return view('dashboard/index', $data);
    }
}
