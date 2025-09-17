<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('pages.auth.login', [
            'title' => 'Login'
        ]);
    }

    public function login(LoginRequest $request)
    {
        try {
            $identityFields = [
                'email'    => filter_var($request->identity, FILTER_VALIDATE_EMAIL),
                'username' => !filter_var($request->identity, FILTER_VALIDATE_EMAIL),
            ];

            foreach ($identityFields as $field => $isValid) {
                if ($isValid && Auth::attempt([$field => $request->identity, 'password' => $request->password], $request->remember)) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('be.dashboard.index'));
                }
            }

            return back()->withErrors(['identity' => 'Invalid login credentials. Please double-check your username, email, and password.'])->withInput($request->only('identity'));
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);

            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            Log::error('Login error: ' . $e->getMessage());

            return back()->withErrors(['login' => 'Something went wrong. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('fe.home.index')->with('success', 'You have been logged out.');
    }
}
