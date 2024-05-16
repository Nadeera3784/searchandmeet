<?php

namespace App\Http\Resources;

use App\Enums\Payment\PaymentTerms;
use App\Enums\Payment\TradeTerms;
use App\Enums\ProspectLocation;
use App\Enums\ProspectType;
use App\Services\Cart\CostCalculatorService;
use App\Services\Domain\DomainDataService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PurchaseRequirementResource extends JsonResource
{
    private $calculatorService;
    private $restricted;
    private $domainService;

    public function __construct($resource, $restricted = false)
    {
        parent::__construct($resource);
        $this->restricted = $restricted;
        $this->calculatorService = app()->make(CostCalculatorService::class);
        $this->domainService = app()->make(DomainDataService::class);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getRouteKey(),
            'person' => $this->person->email,
            'person_id' => $this->person->getRouteKey(),
            'link' => $this->domainService->checkIdentifier(config('domain.identifiers.china')) ? route('china.purchase_requirements.show.slug', $this->slug) : route('purchase_requirements.show.slug', $this->slug),
            'name' => $this->product . " " . $this->suffix,
            'description' => $this->description,
            'price' => $this->calculatorService->calculate($this->person->business->country->id, \App\Enums\Order\OrderItemType::BookAndMeet),
            'pre_meeting_sample' => $this->pre_meeting_sample,
            'hs_code' => $this->hs_code,
            'payment_term' => PaymentTerms::getKey(intval($this->payment_term)),
            'trade_term' => TradeTerms::getKey(intval($this->trade_term)),
            'url' => $this->url,
            'looking_from' => ProspectLocation::getKey(intval($this->looking_from)),
            'looking_to_meet' => ProspectType::getKey(intval($this->looking_to_meet)),
            'purchase_volume' => $this->purchaseVolume,
            'business' => $this->when(!$this->restricted, $this->person->business),
            'category' => $this->category,
            'country' => $this->person->business->country,
            'quantity' => $this->quantity,
            'metric' => $this->metric,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('D m y H:i'),
        ];
    }
}
