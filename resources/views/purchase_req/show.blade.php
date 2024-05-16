@extends('layouts.app')

@section('content')

    <style>
        .thumb::-webkit-scrollbar-track {
            /* -webkit-box-shadow: inset 0 0 6px rgba(48, 30, 85, 0.8); */
            border-radius: 10px;
            background-color: #a72e2e00;
            width: 1px;
            height: 8px;
        }

        .thumb::-webkit-scrollbar {
            width: 1px;
            height: 8px;
            background-color: #f7050500;
        }

        .thumb::-webkit-scrollbar-thumb {
            width: 1px;
            height: 8px;
            background-color: #949494;
        }
    </style>
    <script>
        window.addEventListener('load', () => {
            $(() => {
                var html = $('.md_section').html();
                if ($(window).width() >= 750) {
                    $('.sm_section').html('');
                    $('.md_section').html(html);
                } else {
                    $('.md_section').html('');
                    $('.sm_section').html(html);
                }
                $(window).resize(() => {
                    var win = $(this);
                    if (win.width() >= 750) {
                        $('.sm_section').html('');
                        $('.md_section').html(html);
                    } else {
                        $('.md_section').html('');
                        $('.sm_section').html(html);
                    }
                })
            });
        });
    </script>

    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    @inject('costCalculator', 'App\Services\Cart\CostCalculatorService')
    {{$userPurchased = auth('person')->check() && auth('person')->user()->accessible_purchase_requirements()->contains('id',$purchase_requirement->id)}}
    {{$userReserved = auth('person')->check() && auth('person')->user()->reserved_purchase_requirements()->contains('id',$purchase_requirement->id)}}
    <div class="bg px-4 md:px-8 pb-10 pt-20 overflow-hidden relative"
         x-data="{show: false, isDialogOpen: false,selected:null,imgModal : false, imgModalSrc : '', imgModalDesc : ''">
        <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
        <div class="container mx-auto z-10 relative">
            <template
                    @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;"
                    x-if="imgModal">
                <div x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90" x-on:click.away="imgModalSrc = ''"
                     class="bg-black-600 p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
                    <div @click.away="imgModal = ''" class="flex flex-col max-w-3xl max-h-full overflow-auto">
                        <div class="z-50">
                            <button @click="imgModal = ''"
                                    class="float-right pt-2 pr-2 outline-none focus:outline-none">
                                <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="18"
                                     height="18" viewBox="0 0 18 18">
                                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <div class="p-2">
                            <img :alt="imgModalSrc" class="object-contain h-1/2-screen" :src="imgModalSrc">
                            <p x-text="imgModalDesc" class="text-center text-white"></p>
                        </div>
                    </div>
                </div>
            </template>

            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 space-x-0 pt-5 max-w-full  mx-auto ">
                <div class="flex flex-col justify-start w-full md:w-2/3 h-max px-4 lg:px-8">
                    <div class="font-secondary mb-10 relative">
                        <div class="text-gray-700 md:p-8 p-5 bg-gray-100 shadow-md rounded-md flex flex-row justify-between">
                            <div class="w-full overflow-hidden">
                                <div class="text-md text-primary font-bold text-black mt-4 md:mt-0">
                                    {{ __('Requirement Details') }}
                                </div>
                                <p class="text-left text-2xl md:text-3xl font-semibold font-primary  tracking-wider">{{$purchase_requirement->category->name}}</p>
                                @if($purchase_requirement->looking_to_meet && $purchase_requirement->looking_from)
                                    <span className="text-xs normal-case text-gray-600">Looking to meet {{App\Enums\ProspectType::getKey(intval($purchase_requirement->looking_to_meet))}} from {{str_replace('_', ' ', \App\Enums\ProspectLocation::getKey(intval($purchase_requirement->looking_from)))}}</span>
                                @endif
                                @if($purchase_requirement->looking_to_meet && !$purchase_requirement->looking_from)
                                    <span className="text-xs normal-case text-gray-600">Looking to meet {{App\Enums\ProspectType::getKey(intval($purchase_requirement->looking_to_meet))}} from anywhere</span>
                                @endif
                                @if(!$purchase_requirement->looking_to_meet && $purchase_requirement->looking_from)
                                    <span className="text-xs normal-case text-gray-600">Looking to meet prospects from {{str_replace('_', ' ', \App\Enums\ProspectLocation::getKey(intval($purchase_requirement->looking_from)))}}</span>
                                @endif
                                <p class="text-left text-lg md:text-xl font-semibold">{{$purchase_requirement->product . " " . $purchase_requirement->suffix}}</p>
                                <div class="flex text-gray-600 mt-1 w-full overflow-hidden">
                                    <p class="text-left text-sm w-full line-clamp-3">{{$purchase_requirement->description}}</p>
                                </div>
                            </div>
                        </div>
                        @if(auth('person')->check())
                            @if(auth('person')->user()->id != $purchase_requirement->person->id)
                                <form action="{{$purchase_requirement->isInWatchlist() ? route('person.watchlist.remove') : route('person.watchlist.add')}}"
                                      method="POST">
                                    @if($purchase_requirement->isInWatchlist())
                                        @method('DELETE')
                                    @endif
                                    @csrf
                                    <input type="hidden" name="purchase_requirement_id"
                                           value="{{$purchase_requirement->id}}"/>
                                    <button type="submit"
                                            class="max-w-xs rounded-full flex items-center text-sm focus:outline-none absolute top-4 right-4">
                                        <span class="text-black-300 mr-1">{{$purchase_requirement->isInWatchlist() ? 'Remove from watchlist' : 'Add to watchlist'}}</span>
                                        @if($purchase_requirement->isInWatchlist())
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{route('person.login')}}"
                               class="max-w-xs rounded-full flex items-center text-sm focus:outline-none absolute top-4 right-4">
                                <span class="text-black-300 mr-1">Add to watchlist</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                    <div class="sm_section mb-6 md:mb-0">
                    </div>
                    <div class="">
                        <div class="flex flex-col rounded-md overflow-hidden shadow-md mb-10">
                            <table class="w-full table-fixed md:table-auto bg-white requirement">
                                <tr class="flex md:table-row bg-gray-100">
                                    <td colspan="2"
                                        class="md:table-cell block px-4 py-3 bg-gray-100 uppercase font-semibold">
                                        Purchasing Requirement
                                    </td>
                                </tr>
                                <tr class="flex md:table-row flex-col border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Product/Service
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                        {{$purchase_requirement->product}}
                                    </td>
                                </tr>
                                <tr class="flex md:table-row flex-col border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Category
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                        {{$purchase_requirement->category->treeName}}
                                    </td>
                                </tr>
                                <tr class="flex md:table-row flex-col border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Description
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                        {{$purchase_requirement->description}}
                                    </td>
                                </tr>
                                @if($purchase_requirement->images->count() > 0)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Images
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="flex flex-row flex-wrap">
                                                @foreach($purchase_requirement->images as $image)
                                                    <div class="px-4 py-3 uppercase font-semibold">
                                                        <a href="{{$image->public_path}}"
                                                           class="cursor-pointer glightbox">
                                                            <img class="w-24 h-24 rounded-md shadow-md"
                                                                 src="{{$image->public_path}}"/>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="flex md:table-row flex-col  border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Quantity
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                        {{$purchase_requirement->quantity." ".$purchase_requirement->metric->name}}
                                    </td>
                                </tr>
                                @if($purchase_requirement->person->source !== 'api' && $purchase_requirement->price)
                                    <tr class="flex md:table-row flex-col  border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Target price (Unit/Service)
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            $ {{number_format($purchase_requirement->price,2)}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->source === 'api' && $purchase_requirement->price)
                                    <tr class="flex md:table-row flex-col  border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Total order value
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            $ {{number_format($purchase_requirement->price,2)}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->source !== 'api' && $purchase_requirement->purchase_volume != 0)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Total order value
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                $ {{number_format($purchase_requirement->purchase_volume,2)}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->target_purchase_date)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Target purchasing date
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->target_purchase_date == '' ? '' : $timezoneService->localTime(auth('person')->user(), $purchase_requirement->target_purchase_date, 'D M Y')}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->pre_meeting_sample)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Pre meeting sample
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->pre_meeting_sample}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->certification_requirement)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Certification
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{ucfirst($purchase_requirement->certification_requirement)}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->url)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Url
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-blue-500 md:text-sm">
                                            <a href=" {{$purchase_requirement->url}}"
                                               target="_blank">{{$purchase_requirement->url}}</a>

                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->trade_term)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Trade term
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{str_replace('_', ' ', \App\Enums\Payment\TradeTerms::getKey(intval($purchase_requirement->trade_term)))}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->payment_term)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Payment term
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{str_replace('_', ' ', \App\Enums\Payment\PaymentTerms::getKey(intval($purchase_requirement->payment_term)))}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if(!empty($purchase_requirement->hs_codes) && count($purchase_requirement->hs_codes) > 0)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            HS code
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            @foreach($purchase_requirement->hs_codes as $hs)
                                                {!! $hs->code->name  . "</br>" !!}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->purchase_frequency)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Purchase frequency
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{\App\Enums\PurchaseFrequency::getDescription(intval($purchase_requirement->purchase_frequency))}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->purchase_policy)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Purchase policy
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{\App\Enums\PurchasePolicy::getDescription(intval($purchase_requirement->purchase_policy))}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->warranties_requirement)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Warranties requirement
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{ucfirst($purchase_requirement->warranties_requirement)}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->safety_standard)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Safety standard
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            <div class="line-clamp-3">
                                                {{$purchase_requirement->safety_standard}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->requirementSpecificationDocument)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-5 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Requirement specification
                                        </td>
                                        <td class="md:table-cell block px-3 py-5 text-left text-gray-500 md:text-sm">
                                            <a target="_blank"
                                               href="{{asset($purchase_requirement->requirementSpecificationDocument->public_path)}}"
                                               class="cursor-pointer flex gap-2 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-10 w-10 transition duration-200 ease-in-out transform hover:scale-110"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Purchase requirement specification document
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex flex-col rounded-md overflow-hidden shadow-md mb-10">
                            <table class="w-full table-fixed md:table-auto bg-white">
                                <tr class="flex md:table-row bg-gray-100">
                                    <td colspan="2"
                                        class="md:table-cell block px-4 py-3 bg-gray-100 uppercase font-semibold">
                                        BUSINESS DETAILS
                                    </td>
                                </tr>
                                <tr class="flex md:table-row flex-col border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Name
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm filter  {{($userReserved || $userPurchased) ? '' : 'blur-sm'}}">
                                        {{($userReserved || $userPurchased) ? $purchase_requirement->person->business->name : $faker->words(3, true)}}
                                    </td>
                                </tr>
                                <tr class="flex md:table-row flex-col border-b border-gray-100">
                                    <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                        Business type
                                    </td>
                                    <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm filter">
                                        {{\App\Enums\Business\BusinessType::getKey($purchase_requirement->person->business->type_id)}}
                                    </td>
                                </tr>
                                @if($purchase_requirement->person->business->current_importer && $purchase_requirement->person->business->current_importer == 'yes')
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Current importer
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{ucfirst($purchase_requirement->person->business->current_importer)}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->business->HQ)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Head quarters
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->person->business->HQ}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->business->employee_count)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Employee count
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->person->business->employee_count ? \App\Enums\Business\EmployeeCountBracket::getDescription(intval($purchase_requirement->person->business->employee_count)) : '-'}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->business->annual_revenue)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            Annual revenue
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->person->business->annual_revenue ? \App\Enums\Business\AnnualRevenueBracket::getDescription(intval($purchase_requirement->person->business->annual_revenue)) :  '-'}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->business->sic_code)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            SIC code
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->person->business->saic_code->name}}
                                        </td>
                                    </tr>
                                @endif
                                @if($purchase_requirement->person->business->naics_code)
                                    <tr class="flex md:table-row flex-col border-b border-gray-100">
                                        <td class="md:table-cell block px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
                                            NAICS code
                                        </td>
                                        <td class="md:table-cell block px-3 py-3 text-left text-gray-500 md:text-sm">
                                            {{$purchase_requirement->person->business->naic_code->name}}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @if($purchase_requirement->person->purchase_requirements->count() > 1)
                        <div>
                            <p class="font-bold text-xl mb-3">More from this buyer</p>
                            <div class="w-full overflow-x-auto">
                                <div class="flex items-center gap-4 pb-4">
                                    @foreach ($purchase_requirement->person->purchase_requirements()->limit(3)->get() as $related_purchase_req)
                                        <a href="{{route('purchase_requirements.show', $related_purchase_req)}}"
                                           class="cursor-pointer w-1/3">
                                            <div class="py-4 px-5 bg-white shadow-md rounded-md w-full flex flex-col items-start gap-1 transform hover:scale-105 transition ease-in-out duration-300">
                                                <p class="font-semibold truncate whitespace-nowrap text-primary">{{$related_purchase_req->product}}</p>
                                                <p class="text-xs text-gray-600">
                                                    @if($related_purchase_req->looking_to_meet && $related_purchase_req->looking_from)
                                                        <span className="text-xs normal-case text-gray-600">Looking to meet {{App\Enums\ProspectType::getKey(intval($related_purchase_req->looking_to_meet))}} from {{str_replace('_', ' ', \App\Enums\ProspectLocation::getKey(intval($related_purchase_req->looking_from)))}}</span>
                                                    @endif
                                                    @if($related_purchase_req->looking_to_meet && !$related_purchase_req->looking_from)
                                                        <span className="text-xs normal-case text-gray-600">Looking to meet {{App\Enums\ProspectType::getKey(intval($related_purchase_req->looking_to_meet))}} from anywhere</span>
                                                    @endif
                                                    @if(!$related_purchase_req->looking_to_meet && $related_purchase_req->looking_from)
                                                        <span className="text-xs normal-case text-gray-600">Looking to meet prospects from {{str_replace('_', ' ', \App\Enums\ProspectLocation::getKey(intval($related_purchase_req->looking_from)))}}</span>
                                                    @endif
                                                </p>
                                                @if(auth('person')->check())
                                                <p class="text-sm">
                                                    {{$costCalculator->calculate($related_purchase_req->person->business->country->id, \App\Enums\Order\OrderItemType::BookAndMeet)}}
                                                    USD ( Pay after meeting )
                                                </p>
                                                @else
                                                    <p class="text-xs bg-primary rounded-xl p-2 uppercase font-medium text-white mt-2">
                                                        Login to see pricing
                                                    </p>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="">
                    <div class="md_section_removed">
                        @if(auth('person')->check() && $purchase_requirement->person->id == auth('person')->user()->id)
                            <div class="mb-2 w-full flex justify-end">
                                <div class="mb-2 w-full flex flex-row justify-end">
                                    <a href="{{route('person.purchase_requirements.edit', $purchase_requirement->getRouteKey())}}"
                                       class="cursor-pointer
                                       items-center px-2 py-1 ml-1 text-md text-yellow-800 font-medium
                                       hover:text-yellow-100 transition-colors duration-150 bg-yellow-200 rounded
                                       focus:shadow-outline hover:bg-yellow-500">Edit</a>
                                    <form action="{{route('person.purchase_requirements.delete', $purchase_requirement->getRouteKey())}}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="items-center px-2 py-1 ml-1 text-md text-red-800 font-medium hover:text-red-100 transition-colors duration-150 bg-red-200 rounded focus:shadow-outline hover:bg-red-500">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if((auth('person')->check() && $purchase_requirement->person->id != auth('person')->user()->id) || !auth('person')->check())
                            <div class="w-full bg-gray-50 rounded-xl break-words flex flex-col shadow-md overflow-hidden"
                                 x-data="orderHandler()" x-init="init()">

                                <div class="w-full">
                                    <div class="flex flex-col space-y-3">
                                        <form method="POST" action="{{route('person.cart.add')}}">
                                            @csrf
                                            <div class="p-6 bg-gray-700 rounded-md">
                                                <input type="hidden" name="purchase_requirement"
                                                       value="{{$purchase_requirement->id}}">
                                                <input type="hidden" name="type" :value="type[select]">

                                                <input type="hidden" name="timeslot" :value="selected_timeslot">

                                                <h1 class="text-center px-3 text-2xl rounded-lg font-primary text-primary  tracking-wider break-all uppercase font-medium my-3">
                                                    Meet and Close<br>the deal
                                                    <p class=" font-medium my-3 px-4 text-sm line-clamp-2 normal-case font-secondary tracking-normal text-white break-words">
                                                        Select one of the available time slots or request a new time</p>
                                                </h1>

                                                <h1 class="text-center text-xl rounded-lg font-primary text-primary uppercase font-medium my-1"
                                                    x-text="m_type[select]">
                                                </h1>
                                                <div class="flex flex-col gap-5 text-sm my-1 justify-center items-center">
                                                    <h1 class="{{auth('person')->check() ? 'text-3xl' : 'text-xs bg-primary rounded-xl p-2'}} uppercase font-medium text-white"
                                                        x-text="{{auth('person')->check() ? 'true' : 'false'}} ? price[select] : 'Login to see pricing'">
                                                    </h1>
                                                    <select class="rounded mb-1 w-60 text-base md:text-xs"
                                                            x-model="select">
                                                        <option class="text-sm" value="0"><p class="text-sm py-1">
                                                                Meeting Only</p></option>
                                                        <option class="text-sm" value="1"><p class="text-sm py-1">
                                                                Dedicated Host & Meeting</p></option>
                                                        <option class="text-sm" value="2"><p class="text-sm py-1">
                                                                Contact Details</p></option>
                                                    </select>
                                                </div>

                                                <div x-show="select!=2"
                                                     class="flex flex-col items-center justify-center  text-sm my-1 py-4">
                                                    <div>

                                                        <div x-show="view === 'calendar'" id="myCalendar"
                                                             class="vanilla-calendar">
                                                        </div>

                                                        <div x-show="view === 'loading'" class="w-72 h-36 bg-white rounded p-4 flex justify-center items-center">
                                                            <svg class="animate-spin h-5 w-5 text-black-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                        </div>

                                                        <div x-show="view === 'timeslot'" class="bg-white rounded p-4">
                                                            <template x-if="time_slots.length > 0">
                                                                <div class='flex flex-col gap-2 items-center p-3 px-2 py-1 w-full'>
                                                                    <span class="text-center w-full block"
                                                                          x-text="'Selected date: ' + moment(selected_date).format('Do of MMMM YYYY')"></span>
                                                                    <button type="button" @click="change()"
                                                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                                        Change
                                                                    </button>
                                                                </div>
                                                                <div class="grid grid-cols-4 gap-3 w-full my-3 px-2 overflow-y-auto max-h-56">
                                                                    <template
                                                                            x-for="time_slot in time_slots"
                                                                            :key="time_slot">
                                                                        <div class="px-2 py-1 h-12 w-full bg-red-500 rounded flex justify-center items-center cursor-pointer transform transition duration-200 hover:scale-105 hover:bg-red-600">
                                                                        <span @click="selectTimeslot(time_slot)"
                                                                              x-text="getLocalTime(time_slot, timeslotTimezone, 'hh:mm A')"
                                                                              class='text-white font-semibold text-sm'/>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                            <template x-if="time_slots.length === 0">
                                                                <div class='flex flex-col gap-2 items-center p-3 px-2 py-1 w-full'>
                                                                    <span x-text="'No timeslots available on this date'"
                                                                          class='font-semibold text-sm'></span>
                                                                    <button type="button" @click="change()"
                                                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                                        Change
                                                                    </button>
                                                                </div>
                                                            </template>

                                                        </div>
                                                        <div x-show="view === 'change'" class="bg-white rounded p-4">

                                                            <div class='flex flex-col gap-2 items-center'>
                                                                <div class='flex flex-col items-center'>
                                                                        <span class='text-sm'
                                                                              x-text="'Selected date: ' + getLocalTime(selected_timeslot, timeslotTimezone , 'Do of MMMM YYYY')"></span>
                                                                    <span class='text-sm'
                                                                          x-text="'Selected time: ' + getLocalTime(selected_timeslot, timeslotTimezone , 'hh mm A')"></span>
                                                                </div>
                                                                <div class='flex gap-2 items-center p-3'>
                                                                    <button type="button" @click="change()"
                                                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                                        Change
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <button
                                                        x-text="select == 2 ? 'Buy now' : 'Reserve now & pay later'"
                                                        :disabled="select != 2 && selected_timeslot === null"
                                                        type="submit"
                                                        :class="(select != 2 && selected_timeslot === null) ? 'bg-gray-500 hover:bg-gray-600' : 'bg-primary hover:bg-primary_hover'"
                                                        class="w-full cursor-pointer ml-auto rounded mt-2  text-sm outline-none focus:outline-none  focus:ring-0 text-white font-bold py-3 px-4"
                                                >
                                                    Reserve Now
                                                </button>
                                            </div>

                                            <div x-show="select==0" class="flex flex-col p-6 my-2 space-y-3">
                                                <div class="flex space-x-3 items-center">
                                                    <span class="w-5/6">Confirm the meeting and be your own host</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Requirement Details</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Meeting Management Dashboard</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Company Details</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Video meeting platform access</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Email & Chat support</span>
                                                </div>
                                            </div>
                                            <div x-show="select==1" class="flex flex-col p-6 my-2 space-y-3">
                                                <div class="flex space-x-3 items-center">
                                                    <span class="w-5/6 break-words">Get a professional consultant to call, organize and host the meeting.</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Coordinate & organize the meeting</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Conduct & facilitate the meeting</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Follow up support if required</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Meeting Management Dashboard</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="w-5/6">Access to contact information</p>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="w-5/6">Video meeting platform access</p>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="w-5/6">Email & Chat support</p>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <p class="w-5/6">Live Phone Support</p>
                                                </div>
                                            </div>
                                            <div x-show="select==2" class="flex flex-col p-6 my-2 space-y-3">
                                                <div class="flex space-x-3 items-center">
                                                    <span class="w-5/6">Get requirement details, coordinate with the prospect to finalize the meeting</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Contact Details</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Requirement Details</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Company Details</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Dashboard access</span>
                                                </div>
                                                <div class="flex space-x-3 items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="w-5/6">Chat Support</span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 w-full bg-gray-50 rounded-xl break-all flex flex-col shadow-md relative border-primary border-4">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             class="h-sceen absolute bottom-0 left-1/2 transform translate-y-full -translate-x-1/2"
                             viewBox="0 0 105 629">
                            <image id="_Group_" data-name="&lt;Group&gt;" width="105" height="629"
                                   xlink:href="data:image/png;base64,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"/>
                        </svg>
                        <div class="py-8 w-full px-8">
                            <div class="flex justify-center items-center flex-col">
                                <div>
                                    <h1 class="text-center mt-2 text-2xl font-bold uppercase filter {{$userPurchased ? '' : 'blur-sm'}}">
                                        {{$userPurchased ? $purchase_requirement->person->name : $faker->name}}
                                    </h1>
                                    <p class="text-center text-md uppercase mt-0 ">{{$purchase_requirement->person->business->country->name}}</p>
                                </div>
                                <div class="z-20 mt-2 text-xs flex items-center text-white bg-green-500 p-1 pr-2 rounded-full hover:bg-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 " fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-xs ml-1">Verified</span>
                                </div>

                            </div>
                            <hr class="mt-5">

                            <div class="flex flex-col space-y-2 mt-2">
                                <h1 class="text-left uppercase font-medium my-3">{{ __('Contact') }}</h1>
                                @if($purchase_requirement->person->formattedPhoneNumber())
                                    <div class="flex items-center space-x-2 relative">
                                        <div class="border-r-2 border-gray-300 text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div class="absolute top-1/2 transform -translate-y-1/2 right-0 z-20 flex justify-center text-green-500">

                                        </div>
                                        <span class="text-left text-sm filter {{$userPurchased ? '' : 'blur-sm'}} select-none">
                                    {{$userPurchased ? $purchase_requirement->person->formattedPhoneNumber() : $faker->phoneNumber}}
                                </span>
                                    </div>
                                @endif
                                <div class="flex items-center space-x-2 relative">
                                    <div class="border-r-2 border-gray-300 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="absolute top-1/2 transform -translate-y-1/2 right-0 z-20 flex justify-center text-green-500">
                                    </div>
                                    <span class="text-left text-sm text-blue-500 filter {{$userPurchased ? '' : 'blur-sm'}} select-none">
                                    {{$userPurchased ? $purchase_requirement->person->email : $faker->safeEmail}}
                                </span>
                                </div>
                                <div class="flex items-center space-x-2 relative">
                                    <div class="border-r-2 border-gray-300 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div class="absolute top-1/2 transform -translate-y-1/2 right-0 z-20 flex justify-center text-green-500">

                                    </div>
                                    <span class="text-left text-sm filter {{$userPurchased ? '' : 'blur-sm'}} select-none">
                                       {{$userPurchased ? $purchase_requirement->person->business->complete_address() : $faker->address}}
                                </span>
                                </div>
                                @if($userPurchased)
                                    <div class=" text-gray-900 pt-5 pl-2 flex flex-row gap-4">
                                        @if($purchase_requirement->person->business->website)
                                            <a href="{{$purchase_requirement->person->business->website}}"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6 fill-current text-gray-600" viewBox="0 0 52 52">
                                                    <path id="Subtraction_2" data-name="Subtraction 2"
                                                          d="M26,52A26.007,26.007,0,0,1,15.88,2.043,26.007,26.007,0,0,1,36.121,49.957,25.837,25.837,0,0,1,26,52ZM20.057,33.188a23.5,23.5,0,0,0,2.444,7.7c1.118,1.955,2.424,2.989,3.778,2.989s2.661-1.034,3.778-2.989a23.5,23.5,0,0,0,2.444-7.7Zm14.716,0c-.654,4.234-1.87,7.677-3.515,9.956a17.383,17.383,0,0,0,11.11-9.956Zm-24.574,0a17.375,17.375,0,0,0,11.11,9.956c-1.645-2.278-2.861-5.721-3.516-9.956Zm24.848-11.25h0c.154,1.542.232,3.056.232,4.5s-.078,2.958-.232,4.5H43.1a17.377,17.377,0,0,0,.6-4.5,17.69,17.69,0,0,0-.6-4.5H35.047Zm-15.286,0a43.72,43.72,0,0,0,0,9H32.79a44.377,44.377,0,0,0,.232-4.5,44.37,44.37,0,0,0-.232-4.5H19.761Zm-10.315,0h0a17.043,17.043,0,0,0,0,9H17.5c-.15-1.574-.225-3.088-.225-4.5,0-1.444.078-2.958.232-4.5H9.446ZM31.25,9.731c1.645,2.278,2.861,5.721,3.516,9.957h7.593A17.379,17.379,0,0,0,31.25,9.731ZM26.279,9c-1.354,0-2.661,1.034-3.778,2.989a23.5,23.5,0,0,0-2.444,7.7H32.5a23.5,23.5,0,0,0-2.444-7.7C28.94,10.034,27.633,9,26.279,9ZM21.3,9.731a17.355,17.355,0,0,0-11.1,9.957h7.593A23.379,23.379,0,0,1,21.3,9.731Z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if($purchase_requirement->person->business->facebook)
                                            <a href="{{$purchase_requirement->person->business->facebook}}"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6 fill-current text-blue-700"
                                                     viewBox="0 0 34.875 34.664">
                                                    <path id="Icon_awesome-facebook" data-name="Icon awesome-facebook"
                                                          d="M35.438,18A17.438,17.438,0,1,0,15.275,35.227V23.041h-4.43V18h4.43V14.158c0-4.37,2.6-6.784,6.586-6.784a26.836,26.836,0,0,1,3.9.34V12h-2.2a2.52,2.52,0,0,0-2.841,2.723V18h4.836l-.773,5.041H20.725V35.227A17.444,17.444,0,0,0,35.438,18Z"
                                                          transform="translate(-0.563 -0.563)"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if($purchase_requirement->person->business->linkedin)
                                            <a href="{{$purchase_requirement->person->business->linkedin}}"
                                               target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6 fill-current text-blue-500" viewBox="0 0 56 56">
                                                    <path id="Exclusion_1" data-name="Exclusion 1"
                                                          d="M28,56A28.007,28.007,0,0,1,17.1,2.2,28.007,28.007,0,0,1,38.9,53.8,27.824,27.824,0,0,1,28,56Zm6.831-29.057c3.4,0,3.4,3.219,3.4,5.569V42.75H44.75V31.2c0-5.2-.948-10.006-7.825-10.006a6.9,6.9,0,0,0-6.179,3.4h-.092V21.719H24.392V42.75h6.523V32.336C30.915,29.669,31.38,26.943,34.831,26.943ZM13.77,21.719V42.75H20.3V21.719ZM17.033,11.25a3.8,3.8,0,1,0,3.782,3.783A3.787,3.787,0,0,0,17.033,11.25Z"
                                                          transform="translate(0 0)"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if(!$userPurchased)
                                    <div class=" text-gray-900 pt-5 pl-2 flex flex-col gap-4">
                                        @if($purchase_requirement->person->business->website)
                                            <div class="flex space-x-3 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="w-5/6">Website available</span>
                                            </div>
                                        @endif
                                        @if($purchase_requirement->person->business->facebook)
                                            <div class="flex space-x-3 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="w-5/6">Facebook available</span>
                                            </div>
                                        @endif
                                        @if($purchase_requirement->person->business->linkedin)
                                            <div class="flex space-x-3 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="w-5/6">Linkedin available</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="availabilityConfigurator()" x-init="init()"
         class="transition-opacity duration-150 lead-modal absolute z-1 w-full h-full top-0 left-0 flex justify-center items-center bg-black-200"
         :class="modalVisible ? 'opacity-100 z-50' : 'opacity-0'"
         @openrequestmodal.window="toggleModal()">
        <div class="flex flex-col w-11/12 sm:w-5/6 lg:w-1/2 max-w-2xl mx-auto rounded-lg border border-gray-300 shadow-xl">
            <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
                <p class="font-semibold text-gray-800">Submit your availability</p>
                <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg" @click="toggleModal()">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div class="flex flex-col px-6 py-5 bg-gray-50 overflow-y-auto overflow-x-hidden">
                <div class="h-full flex flex-col gap-2">
                    <form>
                        <div class="flex flex-col">
                            <div class="flex flex-col gap-2">
                                <div class="flex flex-col gap-1 py-2">
                                    <p class="text-lg text-gray-700">The more slots you select, the more chances of
                                        getting a meeting</p>
                                    <p class="my-2 mt-3 font-semibold text-gray-700">Default availability (Weekdays)</p>
                                    <div class="flex gap-2">
                                        <div class="flex flex-col gap-1">
                                            {!! Form::time('timeslots[1][from]', null, ['x-model' => 'default_start', 'class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                            <span class="text-xs text-gray-500">From</span>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            {!! Form::time('timeslots[1][to]', null, ['x-model' => 'default_end', 'class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                            <span class="text-xs text-gray-500">To</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1 border-t py-2">
                                    <p class="my-2 mt-3 font-semibold text-gray-700">Custom availability based on
                                        day</p>
                                    <div class="flex gap-2">
                                        <template x-for="day in days" :key="day.id">
                                            <div>
                                                <span @click="setCurrentDay(day.id)" x-text="day.name.charAt(0)"
                                                      :class="selected_day === day.id ? 'bg-black-700' : (day.availability.to ? 'bg-green-500' : 'bg-blue-500')"
                                                      class="cursor-pointer hover:bg-blue-900 capitalize w-10 h-10 relative flex justify-center items-center rounded-full text-s text-white"></span>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="flex flex-col gap-2 mt-2" x-show="selected_day !== undefined">
                                        <div class="flex gap-2 grid grid-cols-6">
                                            <div class="flex flex-col gap-1 lg:col-span-2 md:col-span-2 sm:col-span-2 col-span-3">
                                                {!! Form::time('timeslots[1][from]', null, ['x-model'=>'custom_availability_from', 'class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                <span class="text-xs text-gray-500">From</span>
                                            </div>
                                            <div class="flex flex-col gap-1 lg:col-span-2 md:col-span-2 sm:col-span-2 col-span-3">
                                                {!! Form::time('timeslots[1][to]', null, ['x-model'=>'custom_availability_to','class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                <span class="text-xs text-gray-500">To</span>
                                            </div>
                                            <a class="lg:col-span-1 md:col-span-1 sm:col-span-3 col-span-3 bg-primary hover:bg-primary_hover p-2 text-white h-10 w-14 rounded text-center cursor-pointer"
                                               @click="setAvailability()">Add</a>
                                        </div>
                                        <span class="text-red-500 font-bold text-xs"
                                              x-show="custom_availability_error !== undefined"
                                              x-text="custom_availability_error"></span>
                                    </div>
                                </div>
                                <div class="flex flex-col border-t py-2">
                                    <p class="my-2 mt-3 font-semibold text-gray-700">Custom meeting time slot</p>
                                    <div class="flex xs:flex-col gap-2 grid grid-cols-4">
                                        <div class="flex flex-col gap-1 lg:col-span-2 md:col-span-2 sm:col-span-4 col-span-4">
                                            {!! Form::date('timeslots[1][date]', null, ['x-model'=> 'custom_timeslot_date', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}
                                            <span class="text-xs text-gray-500">Date</span>
                                        </div>
                                        <div class="flex gap-2">
                                            <div class="flex flex-col gap-1 lg:col-span-1 md:col-span-1 sm:col-span-4 col-span-4">
                                                {!! Form::time('timeslots[1][from]', null, ['x-model'=> 'custom_timeslot_from','class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                <span class="text-xs text-gray-500">From</span>
                                            </div>
                                            <div class="flex flex-col gap-1 lg:col-span-1 md:col-span-1 sm:col-span-4 col-span-4">
                                                {!! Form::time('timeslots[1][to]', null, ['x-model'=> 'custom_timeslot_to','class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                <span class="text-xs text-gray-500">To</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex pt-4 border-t">
                                    <label class="inline-flex items-center text-sm">
                                        <input x-model="recommend_similar_products" type="checkbox" name="policy_check"
                                               class="form-checkbox h-5 w-5 text-gray-600 outline-none cursor-pointer">
                                        <span class="ml-3 text-gray-700 leading-1">
                                    Recommend me similar contacts
                                </span>
                                    </label>
                                </div>
                                <div class="flex flex-col py-2">
                                    <p class="my-2 font-semibold text-gray-700 required">Message</p>
                                    <textarea x-model="message" rows=2 placeholder="Your message.."
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md mb-2"
                                              value=""></textarea>
                                    <span class="text-red-500 font-bold text-xs" x-show="message_error !== undefined"
                                          x-text="message_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <a @click="sendRequest()"
                               class="cursor-pointer text-sm mt-2 font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-primary hover:bg-primary_hover text-white rounded ">Send
                                request</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function availabilityConfigurator() {
            return {
                modalVisible: false,
                default_start: '09:00',
                default_end: '17:00',
                custom_availability_to: undefined,
                custom_availability_from: undefined,
                custom_availability_error: undefined,
                custom_timeslot_date: undefined,
                custom_timeslot_from: undefined,
                custom_timeslot_to: undefined,
                message_error: undefined,
                message: '',
                recommend_similar_products: false,
                days: [
                    {id: 0, name: 'monday', availability: {}},
                    {id: 1, name: 'tuesday', availability: {}},
                    {id: 2, name: 'wednesday', availability: {}},
                    {id: 3, name: 'thursday', availability: {}},
                    {id: 4, name: 'friday', availability: {}}
                ],
                selected_day: undefined,
                init() {

                },
                toggleModal() {
                    const isLoggedIn = {{auth('person')->check() ? 'true' : 'false'}};
                    if (!isLoggedIn) {
                        window.location.href = '{{route('person.login', ['redirect_to'=> route('purchase_requirements.show', $purchase_requirement->getRouteKey())])}}'
                    } else {
                        this.modalVisible = !this.modalVisible;
                    }
                },
                setCurrentDay(id) {
                    if (id === this.selected_day) {
                        this.selected_day = undefined;
                    } else {
                        this.selected_day = id;
                        if (this.days[id].availability.from && this.days[id].availability.to) {
                            this.custom_availability_from = this.days[id].availability.from;
                            this.custom_availability_to = this.days[id].availability.to;
                        } else {
                            this.custom_availability_from = undefined;
                            this.custom_availability_to = undefined;
                        }
                    }
                },
                setAvailability() {
                    if (this.custom_availability_from && this.custom_availability_to) {
                        const dayIndex = this.days.findIndex((item) => item.id === this.selected_day);
                        this.days[dayIndex].availability = {
                            from: this.custom_availability_from,
                            to: this.custom_availability_to,
                        }

                        this.selected_day = undefined;
                    } else {
                        this.custom_availability_error = 'Please enter both to and from times!';
                    }
                },
                sendRequest() {
                    if (this.validateData()) {
                        const url = '{{route('purchase_requirements.meeting_request.create', $purchase_requirement->getRouteKey())}}';
                        const data = {
                            custom_timeslot: {
                                date: this.custom_timeslot_date,
                                start: this.custom_timeslot_from,
                                end: this.custom_timeslot_to
                            },
                            default_availability: {
                                start: this.default_start,
                                end: this.default_end
                            },
                            day_availability: this.days,
                            message: this.message,
                            recommend_similar_products: this.recommend_similar_products,
                        };

                        window.axios.post(url, data)
                            .then((response) => {
                                let event = new CustomEvent('notice', {
                                    detail: {
                                        'type': 'success',
                                        'text': 'Your request has been sent successfully!'
                                    }
                                });
                                this.toggleModal();
                                window.dispatchEvent(event);
                            })
                            .catch((error) => {

                            });
                    }
                },
                validateData() {
                    this.message_error = undefined;
                    if (this.message == '') {
                        this.message_error = 'Please enter a message';
                        return false;
                    }

                    return true;
                }
            }
        }

        function orderHandler() {
            return {
                m_type: ['Meeting Only', 'Dedicated Host & Meeting', 'Contact Details'],
                price: ['$ {{$costCalculator->calculate($purchase_requirement->person->business->country->id, \App\Enums\Order\OrderItemType::BookAndMeet)}}', '$ {{$costCalculator->calculate($purchase_requirement->person->business->country->id, \App\Enums\Order\OrderItemType::MeetingWithHost)}}', '$ {{$costCalculator->calculate($purchase_requirement->person->business->country->id, \App\Enums\Order\OrderItemType::AccessInformation)}}'],
                type: [{{\App\Enums\Order\OrderItemType::BookAndMeet}},{{\App\Enums\Order\OrderItemType::MeetingWithHost}},{{\App\Enums\Order\OrderItemType::AccessInformation}}],
                select: 1,
                selected_date: undefined,
                time_slots: [],
                selected_timeslot: null,
                view: "loading",
                timeslotTimezone: undefined,
                init() { const date = moment().format('DD-MM-YYYY');
                    const available_dates = this.getAvailableDays(date);
                    this.view = 'calendar';

                    let myCalendar = new VanillaCalendar({
                        selector: "#myCalendar",
                        pastDates: false,
                        datesFilter: true,
                        availableDates: available_dates,

                        onSelect: (data) => {
                            let selectedDate = new Date(data.date).toISOString().substring(0, 10);
                            this.getTimeSlotsByDate(selectedDate);
                        },
                        onMonthChange: (data) => {
                            const date = moment(data).format('DD-MM-YYYY');
                            myCalendar.set({
                                availableDates: this.getAvailableDays(date),
                            })
                        }
                    });
                },
                getAvailableDays(date){
                    let available_dates = [];
                    let result = $.ajax({
                        url: "/api/v1/availability/check_month_availability",
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        global: false,
                        data: {
                            "purchase_requirement_id": '{{$purchase_requirement->getRouteKey()}}',
                            "date": date
                        },
                        success: function (response) {
                            return response;
                        }
                    });

                    if (result.status === 200) {
                        available_dates = Object.keys(result.responseJSON).reduce((filtered, key) => {
                            if(result.responseJSON[key])
                            {
                                filtered.push({date: key});
                            }

                            return filtered;
                        }, []);
                    }

                    return available_dates;
                },
                getOptions(){

                },
                getLocalTime(dateTime, timezone, format = 'YYYY-MM-DD HH:mm:ss') {
                    return moment.utc(dateTime).local().format(format);
                },
                getTimeSlotsByDate(date) {
                    this.selected_date = date;
                    let result = $.ajax({
                        url: "/api/v1/availability/get_time_slots",
                        type: 'POST',
                        dataType: 'json',
                        async: false,
                        global: false,
                        data: {
                            "purchase_requirement_id": '{{$purchase_requirement->getRouteKey()}}',
                            "date": this.selected_date,
                        },
                        success: function (response) {
                            return response;
                        }
                    });

                    if (result.status === 200) {
                        this.time_slots = result.responseJSON.time_slots;
                        this.timeslotTimezone = result.responseJSON.time_zone;
                        this.view = "timeslot";
                    }
                },
                selectTimeslot(time_slot) {
                    this.selected_timeslot = time_slot;
                    let concat_date = this.selected_date + " ";
                    this.view = "change";
                },
                change() {
                    this.selected_timeslot = null;
                    this.view = "calendar";
                }
            }
        }
    </script>

@endsection
