<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Person\VerifyPhoneRequest;
use App\Services\Auth\SMSVerificationService;

class VerificationController extends Controller
{
    public function send_code(SMSVerificationService $SMSVerificationService)
    {
        try
        {
            $SMSVerificationService->sendCode();
            return redirect()->route('person.phone.verification')->with('success', 'Verification code sent!');
        }
        catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function resend_code(SMSVerificationService $SMSVerificationService)
    {
        try
        {
            $SMSVerificationService->reSendCode();
            return redirect()->route('person.phone.verification')->with('success', 'Verification code sent!');
        }
        catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function initiate_phone_verification()
    {
        if(auth('person')->check())
        {
            if(auth('person')->user()->phone_verified_at)
            {
                return redirect()->back()->with('success', 'Phone number already verified');
            }

            return view('auth.phone_verify');
        }
    }

    public function verify_phone(VerifyPhoneRequest $request, SMSVerificationService $SMSVerificationService)
    {
        try
        {
            $SMSVerificationService->verifyCode($request->validated()['code']);
            return redirect()->route('person.dashboard')->with('success', 'Your phone number has been verified!');
        }
        catch (\Exception $exception)
        {
            return back()->with('error', $exception->getMessage());
        }
    }
}
