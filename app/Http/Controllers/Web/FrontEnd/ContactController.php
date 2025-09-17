<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Frontend\Contact\ContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        try {
            $data = $request->safe()->except('g-recaptcha-response');

            Contact::create([
                ...$data,
                'ip' => $request->ip(),
            ]);

            // Kirim email notifikasi (optional)
            // Mail::to(config('mail.from.address'))->send(new ContactMessage($data));

            return redirect()
                ->to(url()->previous() . '#contact')
                ->with('success', 'Your message has been sent successfully!');

        } catch (TooManyRequestsHttpException $e) {
            // Log error untuk debugging
            Log::warning('Contact form throttled: '.$e->getMessage());

            return redirect()
                ->to(url()->previous() . '#contact')
                ->withInput()
                ->withErrors([
                    'throttle' => 'You have submitted too many times. Please try again later.',
                ]);
        } catch (\Exception $e) {
            // Log unexpected error agar mudah debug
            Log::error('Contact form error: '.$e->getMessage());

            return redirect()
                ->to(url()->previous() . '#contact')
                ->withInput()
                ->withErrors([
                    'general' => 'Something went wrong. Please try again later.',
                ]);
        }
    }
}
