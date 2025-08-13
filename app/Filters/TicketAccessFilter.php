<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\TicketModel;

class TicketAccessFilter implements FilterInterface
{
    /**
     * Do whatever is necessary to determine if the request is authorized.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in.
        if (!auth()->loggedIn()) {
            // Redirect to login if not authenticated.
            return redirect()->to(route_to('login'));
        }

        // Get the ticket ID from the URI segment.
        $ticketId = $request->getUri()->getSegment(2); // Assuming your route is /tickets/{id}

        // Load the TicketModel and find the ticket.
        $ticketModel = new TicketModel();
        $ticket = $ticketModel->find($ticketId);

        // If the ticket doesn't exist, we can't grant access.
        if (!$ticket) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Get the authenticated user.
        $user = auth()->user();
        $hasPermission = false;

        // --- Permission Logic ---
        // 1. Admins can view any ticket.
        if ($user->can('admin.access')) {
            $hasPermission = true;
        }
        // 2. Customers can only view their own tickets.
        elseif ($user->inGroup('user')) {
            if ($ticket['customer_id'] === $user->id) {
                $hasPermission = true;
            }
        }
        // 3. Staff can only view tickets for their department(s).
        else {
            $userGroups = $user->getGroups();
            if (in_array($ticket['department'], $userGroups)) {
                $hasPermission = true;
            }
        }

        // If the user does not have permission, prevent access.
        if (!$hasPermission) {
            throw new PageNotFoundException("You don't have permission to view this ticket.");
        }
    }

    /**
     * Allows after filters to inspect and modify the response object.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed here.
    }
}
