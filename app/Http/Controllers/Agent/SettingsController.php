<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Settings\UpdateCountryPricingRequest;
use App\Http\Requests\Agent\Settings\UpdateProductPricingRequest;
use App\Repositories\Country\CountryPriceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function show(Request $request, CountryPriceRepositoryInterface $countryPriceRepository)
    {
        $percentages = $countryPriceRepository->getAll();
        $prices = DB::table('product_pricing')->get();

        return view('agent.settings.show', get_defined_vars());
    }

    public function update_country_pricing(UpdateCountryPricingRequest $request, CountryPriceRepositoryInterface $countryPriceRepository)
    {

        $countryPriceRepository->updateData($request->validated()['country_id'], $request->validated()['percentage'], $request->validated()['type']);
        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
    }

    public function update_product_pricing(UpdateProductPricingRequest $request)
    {
        DB::table('product_pricing')->where('product_type', $request->validated()['product_type'])->update([
            'price' => $request->validated()['price']
        ]);
        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully');
    }
}
