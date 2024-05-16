<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\User\CreateUserRequest;
use App\Http\Requests\Agent\User\TransferAccountRequest;
use App\Http\Requests\Agent\User\UpdatePasswordRequest;
use App\Http\Requests\Agent\User\UpdateProfileRequest;
use App\Http\Requests\Agent\User\UpdateUserRequest;
use App\Models\Country;
use App\Models\Meeting;
use App\Models\Person;
use App\Notifications\Agent\AccountTransferred;
use App\Notifications\Agent\RegistrationSuccessful;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use MagicLink\Actions\LoginAction;
use MagicLink\MagicLink;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereNotIn('id', [auth()->guard('agent')->user()->id]);

        if($request->has('type'))
        {
            switch($request->type)
            {
                case "agents":
                    $users->where('role', AgentRoles::agent);
                    break;
                case "translators":
                    $users->where('role', AgentRoles::translator);
                    break;
                case "support":
                    $users->where('role', AgentRoles::support);
                    break;
            }
        }

        if($request->has('email'))
        {
            $users = $users->where('email', $request->get('email'));
        }

        if($request->has('name'))
        {
            $users = $users->where('name', 'like', '%'.$request->get('name').'%');
        }

        $users = $users->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('agent.users.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles = AgentRoles::asSelectArray();
        $role = null;
        if($request->has('type'))
        {
            switch($request->type)
            {
                case "agents":
                   $role = AgentRoles::agent;
                    break;
                case "translators":
                    $role = AgentRoles::translator;
                    break;
                case "support":
                    $role = AgentRoles::support;
                    break;
            }
        }

        $timezones = \DB::table('timezones')->pluck('name', 'id');
        $countries = Country::pluck('name', 'id');
        return view('agent.users.create', get_defined_vars());
    }

    public function store(CreateUserRequest $request, UserRepositoryInterface $userRepository)
    {
       $user = $userRepository->create(array_merge($request->validated(),[
          'password' => Hash::make('password')
       ]));

        if ($user) {

            $urlToDashBoard = MagicLink::create(
                new LoginAction($user, redirect()->route('agent.profile')->with('success', 'Please make sure to update your password!'), 'agent'),
                10080,
                3
            )->url;

            $user->notify(new RegistrationSuccessful($urlToDashBoard));

            $type = 'agents';
            if($request->role == AgentRoles::translator)
            {
                $type = 'translators';
            }

            return redirect()->route('agent.users.index', ['type' => $type])->with('success', 'Agent added successfully!');
        }

        return back()->withInput()->with('error', 'Something went wrong!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        return view('agent.users.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $countries = Country::pluck('name', 'id');
        $timezones = \DB::table('timezones')->pluck('name', 'id');
        return view('agent.users.edit', get_defined_vars());
    }

    public function update($user, UpdateUserRequest $request, UserRepositoryInterface $userRepository)
    {
        $data = $request->validated();
        if($data['status'] === 'yes')
        {
            $data['status'] = 1;
        }
        else
        {
            $data['status'] = 0;
        }

        $userRepository->update($data, $user->id);

        $type = 'agents';
        if($request->role == AgentRoles::translator)
        {
            $type = 'translators';
        }

        return redirect()->route('agent.users.index', ['type' => $type])->with('success', 'Agent updated successfully!');
    }


    public function destroy($user, UserRepositoryInterface $userRepository)
    {
        if ($userRepository->delete($user->id)) {
            return redirect()->route('agent.users.index')->with('success', 'User deleted successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }

    public function profile()
    {
        $user = \Auth::guard('agent')->user();
        $countries = Country::pluck('name', 'id');
        $timezones = \DB::table('timezones')->pluck('name', 'id');
        return view('agent.profile.show', get_defined_vars());
    }

    public function update_profile(UpdateProfileRequest $request, UserRepositoryInterface $userRepository)
    {
        $user = auth()->guard('agent')->user();
        $data = $request->validated();

        if($userRepository->update($data, $user->id))
        {
            return redirect()->route('agent.profile')->with('status', 'User updated successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }

    public function update_password(UpdatePasswordRequest $request)
    {
        $user = auth()->guard('agent')->user();
        $data = $request->validated();

        if (!Hash::check($data['old_password'], $user->password)) {
            return back()->withInput()->with('error', 'Old password does not match!');
        }

        $user->password = Hash::make($data['password']);
        if ($user->save()) {
            return redirect()->route('agent.profile')->with('success', 'Password updated successfully!');
        }
    }

    public function transfer_account(TransferAccountRequest $request, UserRepositoryInterface $userRepository, $user)
    {
        $data = $request->validated();

        $data['password'] = Hash::make('password');
        if(isset($data['agent_id']) && $data['agent_id'])
        {
            DB::beginTransaction();
            try
            {
                Person::where('agent_id', $user->id)->update([
                    'agent_id' => $data['agent_id']
                ]);

                Meeting::where('agent_id', $user->id)->update([
                    'agent_id' => $data['agent_id']
                ]);

                if(isset($data['delete_account']))
                {
                    $user->delete();
                }

                DB::commit();

                //TODO: send email notifications to all users
                return redirect()->route('agent.users.index')->with('success', 'Account transferred successfully!');
            }
            catch(\Exception $exception)
            {
                DB::rollBack();
                return back()->with('error', $exception->getMessage());
            }
        }
        else
        {
            if($userRepository->update($data, $user->id))
            {
                $user = $userRepository->getById($user->id);
                $urlToDashBoard = MagicLink::create(
                    new LoginAction($user, redirect()->route('agent.profile')->with('success', 'Please make sure to update your password!'), 'agent'),
                    10080,
                    3
                )->url;

                $user->notify(new AccountTransferred($urlToDashBoard));
                return redirect()->route('agent.users.edit', $user)->with('success', 'Account transferred successfully!');
            }
        }

        return back()->with('error', 'Something went wrong!');
    }

    public function show_transfer_account($user)
    {
        $countries = Country::pluck('name', 'id');
        $timezones = \DB::table('timezones')->pluck('name', 'id');
        $agents = User::where('role', AgentRoles::agent)->where('id', '!=', $user->id)->pluck('name', 'id');
        return view('agent.users.transfer', get_defined_vars());
    }
}
