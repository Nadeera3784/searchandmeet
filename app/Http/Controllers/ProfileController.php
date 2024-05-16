<?php

namespace App\Http\Controllers;

use App\Enums\Designations\DesignationType;
use App\Enums\ProspectType;
use App\Http\Requests\Web\Person\UpdatePasswordRequest;
use App\Http\Requests\Web\Person\UpdateProfileRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\TimeZone;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Services\Events\EventTrackingService;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(EventTrackingService $userEventsService)
    {
        $timezones = TimeZone::pluck('name','id');
        $countries = Country::pluck('phonecode', 'id')->unique();
        $person = auth('person')->user();
        $languages = Language::pluck('name', 'id');

        $userEventsService->identify([
            "email" => $person->email,
            "name" => $person->name,
            "phone" => $person->formattedPhoneNumber(),
            "lookingToMeet" => $person->ProspectTypeDescription(),
            "preferedLanguage" => $person->preferredLanguages->pluck('name'),
            "Designation" => DesignationType::getDescription($person->designation),
            "timeZone" => $person->timezone->name,
        ]);

        return view('profile.show', get_defined_vars());
    }

    public function update(UpdateProfileRequest $request, PersonRepositoryInterface $personRepository)
    {
        $person = auth('person')->user();
        $personRepository->update($request->validated(), $person->id);
        return redirect()->route('person.profile.show', ['tab' => 'profile'])->with('success', 'Profile updated successfully!');
    }

    public function update_password(UpdatePasswordRequest $request, PersonRepositoryInterface $personRepository)
    {
        $person = auth('person')->user();
        if(Hash::make($request->validated()['old_password']) === $person->password)
        {
            $personRepository->update(['password' => Hash::make($request->validated()['password'])], $person->id);
            return redirect()->route('person.profile.show', ['tab' => 'password'])->with('success', 'Password updated successfully!');
        }
        else
        {
            return redirect()->route('person.profile.show',['tab' => 'password'])->with('error', 'Incorrect password used');
        }
    }

    public function delete(PersonRepositoryInterface $personRepository)
    {
        $personRepository->delete(auth('person')->user()->id);
        return redirect()->route('person.logout');
    }
}
