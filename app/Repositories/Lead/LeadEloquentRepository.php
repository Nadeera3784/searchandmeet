<?php


namespace App\Repositories\Lead;

use App\Models\Lead;

class LeadEloquentRepository implements LeadRepositoryInterface
{
    public function getById($id)
    {
        return Lead::find($id);
    }

    public function create($data)
    {
        if(isset($data['phone_code']))
        {
            $data['country_id'] = $data['phone_code'];
        }

        return Lead::create($data);
    }

    public function update($data, $id)
    {
        $lead = $this->getById($id);
        return $lead->update($data);
    }

    public function delete($id)
    {
        $lead = $this->getById($id);
        return $lead->delete();
    }
}