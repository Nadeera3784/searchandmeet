<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Person\GetPasswordResetRequest;
use App\Http\Requests\Web\Person\SetupAccountRequest;
use App\Notifications\PasswordIsReset;
use App\Notifications\PasswordResetRequested;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\Business\BusinessRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    private $repository;
    private $businessRepository;
    
    public function __construct(PersonRepositoryInterface $repository, BusinessRepositoryInterface $businessRepository)
    {
        $this->repository = $repository;
        $this->businessRepository = $businessRepository;
    }

    public function submit_email(Request $request)
    {
        return view('auth.password.forgot_password');
    }

    public function show_reset_password(Request $request)
    {
        if($token = $request->has('token'))
        {
            if($setupToken = DB::table('password_reset_tokens')->where(  'token' , $request->token)->first())
            {
                $expired = false;
                if($setupToken->expires_on <= Carbon::now())
                {
                    DB::table('password_reset_tokens')->delete($setupToken->id);
                    $expired = true;
                }
                return view('auth.password.reset_password', ['expired' => $expired]);
            }
            else
            {
                abort(404, 'Link not found');
            }
        }
        else
        {
            abort(404, 'Link not found');
        }
    }

    public function get_reset_link(GetPasswordResetRequest $request)
    {
       if($person = $this->repository->getByEmail($request->validated()['email']))
       {
           $setupToken = DB::table('password_reset_tokens')->where('person_id' , $person->id)->first();
           if($setupToken)
           {
               if($setupToken->expires_on <= Carbon::now())
               {
                   DB::table('password_reset_tokens')->where('person_id' , $person->id)->delete();
                   $setupToken = null;
               }
           }

           if(!$setupToken)
           {
               $token = Str::random(32);
               DB::table('password_reset_tokens')->insert([
                   'person_id' => $person->id,
                   'token' => $token,
                   'expires_on' => Carbon::now()->addHour(2)
               ]);

               $setupToken = DB::table('password_reset_tokens')->where('person_id' , $person->id)->first();
           }

           $person->notify(new PasswordResetRequested($setupToken));
           return redirect()->route('home')->with('success', 'Password reset link sent, please check your email');
       }
    }

    public function reset_password(SetupAccountRequest $request)
    {
        $setupToken = DB::table('password_reset_tokens')->where(  'token' , $request->validated()['token'])->first();
        if($setupToken) {
            $this->repository->update([
                'password' => Hash::make($request->validated()['password']),
                'email_verified_at' => Carbon::now()
            ], $setupToken->person_id);

            $person = $this->repository->getById($setupToken->person_id);
            $person->notify(new PasswordIsReset());

            DB::table('password_reset_tokens')->where('person_id' , $setupToken->person_id)->delete();

            return redirect()->route('person.login.show')->with('success', 'Password reset successfully, please log in');
        }
        else
        {
            return redirect()->back()->with('error', 'Invalid token provided, please check link');
        }
    }
}
