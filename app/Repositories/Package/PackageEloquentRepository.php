<?php


namespace App\Repositories\Package;

use App\Enums\Package\PackageStatus;
use App\Models\Package;

class PackageEloquentRepository implements PackageRepositoryInterface
{

    public function getByAgent($agent)
    {
        return Package::with('person')->whereHas('person', function($q) use ($agent) {
            $q->where('agent_id', $agent->id);
        })->paginate(15);
    }

    public function getByPerson($person, $activeOnly = false) {
        if($activeOnly)
        {
            return $person->packages->where('status', PackageStatus::Active);
        }

        return $person->packages;
    }

    public function getById($id)
    {
        return Package::find($id);
    }

    public function create($data)
    {
        return Package::create($data);
    }

    public function update($data, $id)
    {
        $package = $this->getById($id);
        $package->update($data);
        return $package->refresh();
    }

    public function delete($id)
    {
        $package = $this->getById($id);
        return $package->delete();
    }
}