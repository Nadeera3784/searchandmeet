<?php


namespace App\Services\Cart;

use App\Enums\Order\OrderItemType;
use Illuminate\Support\Facades\DB;

class CostCalculatorService
{
    private $countryPriceRepository;
    private $domainDataService;

    public function __construct($countryPriceRepository, $domainDataService)
    {
        $this->domainDataService = $domainDataService;
        $this->countryPriceRepository =  $countryPriceRepository;
    }

    public function calculate($country_id, $type)
    {
        $base_cost = DB::table('product_pricing')->where('product_type',  $type)->first();
        $price = $base_cost->price;

        $countryPrice = $this->countryPriceRepository->getByCountry($country_id);
        $cost = $price * ($countryPrice->percentage / 100);

        if($this->domainDataService->checkIdentifier(config('domain.identifiers.china')))
        {
            $cost = $cost * 3;
        }

        if(auth('person')->check())
        {
            $person = auth('person')->user();
            $country_id = isset($person->business) ? $person->business->country_id : null;

            if($country_id)
            {
                $countryPrice = $this->countryPriceRepository->getByCountry($country_id);
                $cost = $cost * ($countryPrice->viewer_percentage / 100);
            }
        }

        return $cost;
    }

    public function calculatePackageCost($package)
    {
        $base_cost = DB::table('product_pricing')->where('product_type',  OrderItemType::MeetingWithHost)->first();
        $price = $base_cost->price;

        $countryPrice = $this->countryPriceRepository->getByCountry($package->country_id);
        $cost = $price * ($countryPrice->percentage / 100);

        $total = $cost * $package->allowed_meeting_count;
        if(isset($package->discount_rate) && $package->discount_rate > 0)
        {
            $discount = ($total / 100) * $package->discount_rate;
            $total = $total - $discount;
        }

        return $total;
    }
}