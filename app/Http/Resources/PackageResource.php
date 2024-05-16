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

class PackageResource extends JsonResource
{
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
            'title' => $this->title,
            'person_id' => $this->person->id,
            'allowed_meeting_count' => $this->allowed_meeting_count,
            'discount_rate' => $this->discount_rate,
            'quota_used' => $this->quota_used,
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('D m y H:i'),
        ];
    }
}
