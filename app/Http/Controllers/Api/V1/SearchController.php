<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\Business\BusinessType;
use App\Enums\Designations\DesignationType;
use App\Enums\ProspectType;
use App\Enums\PurchaseRequirementStatus;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PurchaseRequirementResource;
use App\Models\Category;
use App\Models\Country;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use App\Services\Events\EventTrackingService;
use App\Services\Schedule\ScheduleService;
use App\Services\Schedule\ScheduleServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SearchController extends ApiController
{
    public function getFilters()
    {
        $categories = Category::pluck('name', 'id')->toArray();
        $countries = Country::pluck('name', 'id')->toArray();
        $phoneCodes = Country::pluck('phonecode', 'id')->unique()->toArray();
        $company_types = BusinessType::asSelectArray();
        $contact_titles = DesignationType::asSelectArray();
        $prospect_types = ProspectType::asSelectArray();

        return response()->json(['phone_codes' => $phoneCodes, 'countries' => $countries, 'categories' => $categories, 'company_types' => $company_types, 'designations' => $contact_titles, 'prospect_types' => $prospect_types] ,200);
    }

    public function search(Request $request, EventTrackingService $userEventsService, ScheduleServiceInterface $scheduleService)
    {
        return response()->json(['status' => 'failed', 'message' => 'user has no business'], 400);
        if(auth('person')->check())
        {
            if(!isset(auth('person')->user()->business))
            {
                return response()->json(['status' => 'failed', 'message' => 'user has no business'], 400);
            }
        }

        $purchase_requirements = $this->getSearchResultsQuery($request->all());
        $paginatedData = $purchase_requirements->paginate(15);
        if($paginatedData->total() === 0)
        {
            $purchase_requirements = $this->getSearchResultsQuery($request->all(), 'loose');
            $paginatedData = $purchase_requirements->paginate(15);
        }

        $userEventsService->track('Nav Menu Search', array_merge($request->all(), array('sessionId' => Session::getId())));

        $related_products = collect([]);
        if($paginatedData->total() === 0)
        {
            $search_parameters = array_chunk( $request->all(), 1, true);
            $index = 0;
            while($related_products->count() === 0 && isset($search_parameters[$index]))
            {
                $related_products_query = $this->getSearchResultsQuery($search_parameters[$index]);
                $related_products = $related_products_query->limit(4)->get();
                $index++;
            }
        }

        $response = PurchaseRequirementResource::collection($paginatedData)->response()->getData(true);
        $data = collect($response['data']);
        $data = $data->map(function($item) use ($scheduleService) {

            $personId = \Hashids::connection(Person::class)->decode($item['person_id'])[0] ?? null;
            $person = Person::find($personId);
            $availability = $scheduleService->checkAvailabilityByRange($person, Carbon::now(), 'month');
            $check = in_array(true, $availability, true);

            $item['available'] = $check;
            return $item;
        })->toArray();

        $response['data'] = $data;

        return response()->json([
            'authenticated' => auth('person')->check(),
            'products' => $response,
            'related_products' => PurchaseRequirementResource::collection($related_products)->response()->getData(true)
        ],200);
    }

    private function getSearchResultsQuery($parameters, $depthLevel = 'strict')
    {
        $purchase_requirements = PurchaseRequirement::with(['person', 'Category', 'metric']);
        $keywords = $parameters['keywords'] ?? null;
        $minPrice = $parameters['minPrice'] ?? null;
        $maxPrice = $parameters['maxPrice'] ?? null;
        $category_id = $parameters['category_id'] ?? null;
        $country_id = $parameters['country_id'] ?? null;
        $availability = $parameters['availability'] ?? null;
        $companyType = $parameters['companyType'] ?? null;
        $designation = $parameters['designation'] ?? null;
        $prospect_type = $parameters['prospect_type'] ?? null;

        if ($country_id) {
            $purchase_requirements = $purchase_requirements->whereHas('person.business.country', function ($q) use ($country_id) {
                $q->where('id', '=',$country_id);
            });
        }

        if ($category_id) {
            $purchase_requirements = $purchase_requirements->where('category_id', '=', $category_id);
        }

        if ($companyType) {
            $purchase_requirements->whereHas('person.business', function ($q) use ($companyType) {
                $q->whereIn('type_id', [$companyType]);
            });
        }

        if ($prospect_type) {
            $purchase_requirements->where('looking_to_meet', $prospect_type);
        }

        if ($minPrice && $maxPrice) {
            $purchase_requirements = $purchase_requirements->whereBetween('price', [$minPrice, $maxPrice]);
        } else if ($maxPrice) {
            $purchase_requirements = $purchase_requirements->where('price', '<=', $maxPrice);
        } else if ($minPrice){
            $purchase_requirements = $purchase_requirements->where('price', '>=', $minPrice);
        }

        if($availability)
        {
            $collection = collect($availability);
            $purchase_requirements = $purchase_requirements->where(function ($query) use ($collection){
                $query->whereHas('person.availability_index', function ($q) use ($collection) {
                    $secondary = false;
                    if($collection->contains('nextMonth'))
                    {
                        $q->where('next_month', true);
                        $secondary = true;
                    }

                    if($collection->contains('thisMonth'))
                    {
                        if($secondary)
                        {
                            $q->orWhere('this_month', true);
                        }
                        else
                        {
                            $q->where('this_month', true);
                            $secondary = true;
                        }
                    }

                    if($collection->contains('week'))
                    {
                        if($secondary)
                        {
                            $q->orWhere('this_week', true);
                        }
                        else
                        {
                            $q->where('this_week', true);
                            $secondary = true;
                        }
                    }

                    if($collection->contains('today'))
                    {
                        if($secondary)
                        {
                            $q->orWhere('today', true);
                        }
                        else
                        {
                            $q->where('today', true);
                            $secondary = true;
                        }
                    }

                    if($collection->contains('tomorrow'))
                    {
                        if($secondary)
                        {
                            $q->orWhere('tomorrow', true);
                        }
                        else
                        {
                            $q->where('tomorrow', true);
                        }
                    }
                });
            });
        }

        if ($keywords) {
            $purchase_requirements = $purchase_requirements->where(function ($query) use ($keywords, $depthLevel){

                $words = explode(' ', urldecode($keywords));


                if($depthLevel === 'strict')
                {
                    $query->where('product', 'like', '%' .  urldecode($keywords) . '%');
                }

                if($depthLevel === 'loose')
                {
                    foreach ($words as $index => $word)
                    {
                        if($index === 0)
                        {
                            $query->where('product', 'like', '%' . $word . '%');
                        }
                        else
                        {
                            $query->orWhere('product', 'like', '%' . $word . '%');
                        }
                    }
                }

                $query->orWhere('description', 'like', '%' . urldecode($keywords) . '%');
                $query->orWhereHas('person.business', function ($q) use ($keywords) {
                    $q->where('name', 'like', '%' . urldecode($keywords) . '%');
                });
            });
        }

        if ($designation) {
            $purchase_requirements->whereHas('person', function ($q) use ($designation) {
                $q->where('designation', $designation);
            });
        }

        $purchase_requirements = $purchase_requirements->where('status', PurchaseRequirementStatus::Published);
        return $purchase_requirements;
    }
}
