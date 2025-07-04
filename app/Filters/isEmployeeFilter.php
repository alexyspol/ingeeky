<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IsEmployeeFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! auth()->loggedIn()) {
            return redirect()->to(url_to('login'))->with('error', 'You must be logged in to access the dashboard.');
        }

        // If the user is in the 'user' group, deny access
        if (auth()->user()->inGroup('user')) {
            return redirect()->to(base_url('/'))->with('error', 'You do not have permission to access the dashboard.');
        }

        return null; // Allow the request to proceed
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing on the way out
    }
}
