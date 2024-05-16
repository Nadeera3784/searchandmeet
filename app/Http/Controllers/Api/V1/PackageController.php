<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PackageResource;
use App\Models\TimeZone;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class PackageController extends ApiController
{
    public function getByPerson(Request $request, PackageRepositoryInterface $packageRepository, PersonRepositoryInterface $personRepository)
    {
        $id = Hashids::connection(\App\Models\Person::class)->decode($request->person_id)[0] ?? null;
        $person = $personRepository->getById($id);
        $packages = $packageRepository->getByPerson($person, true);

        return response()->json(PackageResource::collection($packages), 200);
    }

}
