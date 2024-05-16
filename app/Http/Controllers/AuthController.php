<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Person\DirectLoginRequest;
use App\Http\Requests\Web\Person\RegistrationRequest;
use App\Http\Requests\Web\Person\SetupAccountRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\PurchaseRequirement;
use App\Models\TimeZone;
use App\Services\Cart\CartService;
use App\Services\Events\EventTrackingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\Business\BusinessRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Stripe\Exception\InvalidRequestException;

class AuthController extends Controller
{

    private $repository;
    private $businessRepository;
    
    public function __construct(PersonRepositoryInterface $repository, BusinessRepositoryInterface $businessRepository)
    {
        $this->repository = $repository;
        $this->businessRepository = $businessRepository;
    }

    public function login(Request $request)
    {
        if($request->redirect_to)
        {
            $request->session()->put('redirect_after_login', $request->redirect_to);
        }
        return view('auth.login');
    }

    public function directLogin(Request $request)
    {
        if(auth('person')->check())
        {
            auth('person')->logout();
        }

        if (! $request->hasValidSignature()) {
            abort(403, 'Link has expired.');
        }

        $person_id = $request->user;
        $person_id =\Hashids::connection(Person::class)->decode($person_id)[0] ?? null;

        $person = $this->repository->getById($person_id);

        if($person)
        {
            auth('person')->login($person, true);
            if($request->has('redirect_to'))
            {
                $redirect_to = urldecode($request->get('redirect_to'));
                return redirect()->to($redirect_to);
            }

            return redirect()->route('person.dashboard');
        }

//        return redirect()->route('home')->with('error', 'Unauthorized');
    }

    public function handleLogin(Request $request, CartService $cartService, EventTrackingService $userEventsService)
    {
        $request->validate([
            'email' => ['required', 'exists:people,email'],
            'password' => ['required']
        ]);

        $email = $request->get('email');
        $person  = Person::where('email', $email)->first();
        if ($person && Auth::guard('person')->attempt($request->only('email', 'password'))) {
            Session::put('user_id', $person->id);
           try
           {
               //check stripe id on login
               $person->asStripeCustomer();
           }
           catch (InvalidRequestException $e)
           {
               $person->stripe_id = null;
               $person->createAsStripeCustomer();
           }

            if($redirect_to = $request->session()->get('redirect_after_login'))
            {
                return redirect()->to($redirect_to)->with('success', 'Welcome back.');
            }
            else if ($cartData = DB::table('persisted_carts')->where('person_id', $person->id)->first())
            {
                $cartService->clearCart();
                $cartService->addToCart($cartData->purchase_requirement_id, $cartData->type, $cartData->time_slot_id);
                DB::table('persisted_carts')->delete($cartData->id);

                return redirect()->route('person.cart.show')->with('success', 'Welcome back.');
            }

            $userEventsService->identify([
                "email" => $person->email,
                "name" => $person->name,
            ]);

            return redirect()->route('person.dashboard')->with('success', 'Welcome back.');
        }

        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::guard('person')->logout();
        Session::flush();
        return redirect('/');
    }

    public function register()
    {
        $timezones = TimeZone::pluck('name', 'id');
        $phoneCodes = Country::pluck('phonecode', 'id')->unique();
        $languages = Language::pluck('name', 'id');
        return view('auth.register', get_defined_vars());
    }

    public function handleRegistration(RegistrationRequest $request)
    {
        try
        {
            $person = $this->repository->create(
                array_merge($request->validated(), [
                    'source' => 'web'
                ])
            );
            if($cart_data = $request->session()->get('persist_cart'))
            {
                DB::table('persisted_carts')->insert([
                    'person_id' => $person->id,
                    'purchase_requirement_id' =>  $cart_data['purchase_requirement_id'],
                    'time_slot_id' =>  $cart_data['time_slot_id'],
                    'type' =>  $cart_data['type']
                ]);

                $request->session()->remove('persist_cart');
            }

            return redirect()->route('person.register.success');
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function setup_account(Request $request, PersonRepositoryInterface $personRepository)
    {
        if($token = $request->has('token'))
        {
            return view('auth.setup_account');
        }
        else
        {
            abort(404);
        }
    }

    public function setup_account_success(Request $request)
    {
        return view('account.success');
    }

    public function complete_account_setup(SetupAccountRequest $request, PersonRepositoryInterface $personRepository, CartService $cartService)
    {
        try
        {
            $setupToken = DB::table('password_reset_tokens')->where(  'token' , $request->validated()['token'])->first();
            if(!$setupToken) {
                throw new \Exception('Invalid token provided, please check link');
            }

            $person = $this->repository->getById($setupToken->person_id);
            if(!$person)
            {
                throw new \Exception('Person unavailable, please try registering');
            }

            $this->repository->update([
                'password' => Hash::make($request->validated()['password']),
                'email_verified_at' => Carbon::now()
            ], $setupToken->person_id);


            DB::table('password_reset_tokens')->delete($setupToken->id);
            auth('person')->login($person);

            if($redirect_to = $request->session()->get('redirect_after_login'))
            {
                return redirect()->to($redirect_to)->with('success', 'Welcome back.');
            }
            else if ($cartData = DB::table('persisted_carts')->where('person_id', $person->id)->first())
            {
                $cartService->clearCart();
                $cartService->addToCart($cartData->purchase_requirement_id, $cartData->type, $cartData->time_slot_id);
                DB::table('persisted_carts')->delete($cartData->id);

                return redirect()->route('person.cart.show')->with('success', 'Welcome back.');
            }

            return redirect()->route('person.dashboard')->with('success', 'Welcome back.');
        }
        catch (\Exception $exception)
        {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


}
