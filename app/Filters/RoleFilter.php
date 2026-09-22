<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // ---------------------------------------
        // Check if user is logged in
        // ---------------------------------------
        if ($session->get('isLoggedIn') !== true) {
            return redirect()->to('/login');
        }

        // ---------------------------------------
        // Get logged-in user's role
        // ---------------------------------------
        $userRole = $session->get('role');

        // ---------------------------------------
        // Check if role is valid
        // ---------------------------------------
        if (empty($userRole)) {

            $session->destroy();

            return redirect()
                ->to('/login')
                ->with('error', 'Session expired. Please login again.');
        }

        // ---------------------------------------
        // Check required role
        // ---------------------------------------
        if ($arguments && !in_array($userRole, $arguments, true)) {

            // User is logged in but has wrong role.
            // Send them to their own dashboard.

            if ($userRole === 'admin') {
                return redirect()->to('/admin/dashboard');
            }

            if ($userRole === 'student') {
                return redirect()->to('/student/dashboard');
            }

            // Unknown role
            $session->destroy();

            return redirect()
                ->to('/login')
                ->with('error', 'Invalid user role. Please login again.');
        }

        // ---------------------------------------
        // Access allowed
        // ---------------------------------------
        return;
    }


    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Nothing required here
    }
}