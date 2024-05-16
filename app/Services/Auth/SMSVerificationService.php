<?php


namespace App\Services\Auth;

use App\Models\VerificationCode;
use App\Notifications\SmsVerificationRequested;
use Carbon\Carbon;;
use Twilio\Exceptions\TwilioException;

class SMSVerificationService
{
    public function sendCode()
    {
        if(auth('person')->check())
        {
            $person = auth('person')->user();
            $existing_code = VerificationCode::where('person_id', $person->id)->first();
            if($existing_code)
            {
                $this->sendNotification($person, $existing_code);
                return $existing_code;
            }
            else if($person->formattedPhoneNumber())
            {
                $genCode = rand(10000, 99999);
                $code = VerificationCode::create([
                    'person_id' => auth('person')->user()->id,
                    'code' => $genCode
                ]);

                $this->sendNotification($person, $code);
                return $code;
            }
            else
            {
                throw new \Exception('Phone number unavailable, please update your profile');
            }
        }
    }

    public function reSendCode()
    {
        if(auth('person')->check()) {
            $person = auth('person')->user();
            $code = VerificationCode::where('person_id', $person->id)->first();

            if(!$person->phone_verified_at)
            {
                $this->sendCode();
            }
            else
            {
                throw new \Exception('Phone number already verified');
            }
        }
    }

    private function sendNotification($person, $code)
    {
        try
        {
            $person->notify(new SmsVerificationRequested($code));
        }
        catch (TwilioException $exception)
        {
            throw new \Exception('Invalid phone number, please update your profile');
        }
    }

    public function verifyCode($submittedCode)
    {
        if(auth('person')->check()) {
            $person = auth('person')->user();
            $code = VerificationCode::where('person_id', $person->id)->first();

            if($code)
            {
                if($submittedCode === $code->code)
                {
                    $person->update([
                        'phone_verified_at' => Carbon::now()
                    ]);

                    $code->delete();
                    return true;
                }
            }

            throw new \Exception('Invalid verification code, please try again');
        }
    }
}