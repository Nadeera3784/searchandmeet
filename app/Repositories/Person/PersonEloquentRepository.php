<?php


namespace App\Repositories\Person;

use App\Enums\Person\AccountStatus;
use App\Enums\PurchaseRequirementStatus;
use App\Models\Person;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Services\Schedule\ScheduleServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PersonEloquentRepository implements PersonRepositoryInterface
{
    private $scheduleRepository;
    private $scheduleService;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository, ScheduleServiceInterface $scheduleService)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleService = $scheduleService;
    }

    public function getAll($params)
    {
        if(isset($params['hasPaginate']) && $params['hasPaginate'] === true)
            return Person::orderBy('id', 'desc')->paginate(10);

        if(isset($params['email']))
            return Person::where('email', $params['email'])->get();

        return Person::orderBy('id', 'desc')->get();
    }

    public function getById($id)
    {
        return Person::find($id);
    }

    public function getByEmail($email)
    {
        return Person::where('email', $email)->first();
    }

    public function getDirectLoginLink($id, $redirect = null){
        $person = $this->getById($id);

        $link = URL::temporarySignedRoute('person.auth.direct_login',  now()->addMinutes(60), [
            'user' => $person->getRouteKey(),
            'redirect_to' => $redirect
        ]);
        return $link;
    }

    public function create($data, $agent_id = null, $activate = true)
    {
        if($agent_id)
        {
            $data['agent_id'] = $agent_id;
        }

        if(isset($data['phone_number']) && isset($data['phone_code_id']))
        {
            $data['country_id'] = $data['phone_code_id'];
        }

        if(!isset($data['status']))
        {
            $data['status'] = AccountStatus::OnBoarding;
        }

        if(isset($data['opt_in_marketing']))
        {
            $data['marketing_opt_in'] = 1;
        }

        if(isset($data['category_id']))
        {
            $data['looking_for_category'] = $data['category_id'];
        }

        $person = Person::create($data);

        if(isset($data['languages']))
        {
            $person->preferredLanguages()->sync($data['languages']);
        }

        if(isset($data['preferred_times']))
        {
            $person->preferredTimes()->sync($data['preferred_times']);
        }

        $setupToken = Str::random(32);
        DB::table('password_reset_tokens')->insert([
            'person_id' => $person->id,
            'token' => $setupToken,
            'expires_on' => Carbon::now()->addDays(30)
        ]);

        $this->scheduleService->addDefaultSchedule($person);

        if($person) {
            if($activate)
            {
                \App\Events\PersonCreated::dispatch($person, $setupToken);
            }
            return $person;
        }

        if(!$person->password) {
            //TODO: send reset password link email
        }

        return false;
    }

    public function update($data, $id)
    {
        $data['country_id'] = null;
        if(isset($data['phone_code_id']))
        {
            $data['country_id'] = $data['phone_code_id'];
        }

        $person = $this->getById($id);

        $person->fill($data);
        if($person->isDirty('phone_code_id') || $person->isDirty('phone_number'))
        {
            $data['phone_verified_at'] = null;
        }

        if(isset($data['category_id']))
        {
            $data['looking_for_category'] = $data['category_id'];
        }

        $person->update($data);

        if(isset($data['languages']))
        {
            $person->preferredLanguages()->sync($data['languages']);
        }

        if(isset($data['preferred_times']))
        {
            $person->preferredTimes()->sync($data['preferred_times']);
        }

        return $person;
    }

    public function delete($id)
    {
        $person = $this->getById($id);
        $person->purchase_requirements()->update(['status' => PurchaseRequirementStatus::Unpublished]);

        return $person->delete();
    }

    public function restore($id)
    {
        $person = $this->getById($id);
        $person->purchase_requirements()->update(['status' => PurchaseRequirementStatus::Published]);

        return $person->restore();
    }
}