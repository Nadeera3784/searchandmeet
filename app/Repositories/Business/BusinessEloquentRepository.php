<?php


namespace App\Repositories\Business;

use App\Models\Business;

class BusinessEloquentRepository implements BusinessRepositoryInterface
{
    public function getAll($params)
    {
        if(isset($params['hasPaginate']) && $params['hasPaginate'] === true)
            return Business::orderBy('id', 'desc')->paginate(10);

        return Business::orderBy('id', 'desc')->get();
    }

    public function getById($id)
    {
        return Business::find($id);
    }

    public function create($data, $person)
    {
        $data['name'] = $data['business_name'];
        return $person->business()->create($data);
    }

    public function update($data, $id)
    {
        $business = $this->getById($id);

        if(isset($data['business_name']))
        {
            $data['name'] = $data['business_name'];
        }

        return $business->update($data);
    }

    public function delete($id)
    {
        $business = $this->getById($id);
        return $business->delete();
    }
}