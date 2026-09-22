<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Show login page
     */
    public function login()
{
    $session = session();

    // ---------------------------------------
    // Check existing session
    // ---------------------------------------
    if ($session->get('isLoggedIn') === true) {

         $role = $session->get('role');
      
        if ($role === 'admin') {
       
            return redirect()->to('/admin/dashboard');
        }

        if ($role === 'student') {
            return redirect()->to('/student/dashboard');
        }

        // Invalid/old session
        $session->destroy();
    }

    // ---------------------------------------
    // Detect login page
    // ---------------------------------------
    $uri = service('uri');
    $segments = $uri->getSegments();

    if (!empty($segments)) {

        if ($segments[0] === 'admin') {
            $session->set('login_role', 'admin');
        }

        if ($segments[0] === 'student') {
            $session->set('login_role', 'student');
        }
    }

    return view('auth/login');
}


    /**
     * Process login
     */
    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel
            ->where('email', $email)
            ->first();


        // User not found
        if (!$user) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }


        // Verify password
        if (!password_verify($password, $user['password'])) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }


        // Check account status
        if ($user['status'] !== 'active') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Your account is inactive. Please contact administrator.'
                );
        }


        // ----------------------------------------
        // Check login role
        // ----------------------------------------

        $loginRole = session()->get('login_role');

        if ($loginRole !== null && $loginRole !== $user['role']) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'You are not authorized to login from this page.'
                );
        }


        // ----------------------------------------
        // Create session
        // ----------------------------------------

        session()->regenerate(true);

        session()->set([
            'user_id'    => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'isLoggedIn' => true
        ]);


        // Remove temporary login role
        session()->remove('login_role');


        // ----------------------------------------
        // Redirect based on role
        // ----------------------------------------

        if ($user['role'] === 'admin') {

            return redirect()
                ->to('/admin/dashboard')
                ->with('success', 'Login successful!');
        }


        if ($user['role'] === 'student') {

            return redirect()
                ->to('/student/dashboard')
                ->with('success', 'Login successful!');
        }


        // Unknown role
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('error', 'Invalid user role.');
    }


    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();

        return redirect()
            ->to('/login')
            ->with('success', 'You have been logged out successfully');
    }
}
