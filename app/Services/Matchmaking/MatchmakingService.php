<?php


namespace App\Services\Matchmaking;

use App\Enums\Person\AccountStatus;
use App\Enums\PurchaseRequirementStatus;
use App\Models\Category;
use App\Models\Person;
use App\Models\PurchaseRequirement;

class MatchmakingService implements MatchmakingServiceInterface
{
    public function __construct()
    {

    }

    public function getMatchesForSupplier(Person $person){
        $type = $person->generalizedType();
        $lookingForCategory = $person->lookingForCategory;
        $matches = [];

        if(!$lookingForCategory)
        {
            throw new \Exception('data missing');
        }

        if($type !== 'supplier')
        {
            throw new \Exception('invalid person type');
        }

        $categories = Category::childCategories($lookingForCategory->id);
        array_push($categories, $lookingForCategory->id);

        $purchase_requirements = PurchaseRequirement::whereIn('category_id', $categories)->where('status', PurchaseRequirementStatus::Published)->get();
        if($purchase_requirements->count() > 0)
        {
            foreach ($purchase_requirements as $purchase_requirement)
            {
                if($purchase_requirement->person->availability_index->this_week === true)
                {
                    if(count($matches) < 3) {
                        array_push($matches, $purchase_requirement);
                    }
                }
            }

            if(count($matches) < 3)
            {
                foreach ($purchase_requirements as $purchase_requirement)
                {
                    if($purchase_requirement->person->availability_index->this_month === true)
                    {
                        if(count($matches) < 3) {
                            array_push($matches, $purchase_requirement);
                        }
                    }
                }
            }
        }

        return $matches;
    }

    public function getMatchesForBuyer(Person $person)
    {
        $type = $person->generalizedType();
        $matches = [];

        if($type !== 'buyer')
        {
            throw new \Exception('invalid person type');
        }

        $lookingForCategories = $person->purchase_requirements->map(function($item) {
            return $item->category_id;
        });

        $people = Person::withoutTrashed()->where('status', AccountStatus::Verified)->whereIn('looking_for_category', $lookingForCategories)->get();
        foreach ($people as $person)
        {
            if($person->generalizedType() === 'supplier')
            {
                array_push($matches, $person);
                if(count($matches) >= 3) {
                    break;
                }
            }
        }

        return $matches;
    }
}
