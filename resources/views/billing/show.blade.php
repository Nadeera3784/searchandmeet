@extends('layouts.app')

@section('content')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div class="bg-gray-50 h-20">
        <div class="container mx-auto md:w-4/5 md:px-0 px-5 pt-28 relative">
            <div class="grid grid-cols-8 gap-x-0 bg-white shadow-md border-gray-200 rounded-md " x-data="menuClick()" x-init="init()">
                <div class="col-span-8 md:col-span-2 py-6 bg-gray-100">
                    <p class="px-6 text-left font-bold text-xl text-gray-800 mb-3">Billing</p>
                    <li class="flex">
                        <div @click="change('transactions')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white': is_open('transactions') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                            </svg>
                            <span class="ml-2">Transactions</span>
                        </div>
                    </li>
                </div>
                <div class="grid grid-cols-8 col-span-8 md:col-span-6 p-6 px-8 pb-10">
                    <div x-show="is_open('transactions')" class="col-span-12">
                        <div class="p-4 w-full bg-white">
                            <h1 class="text-xl font-semibold text-gray-900 flex items-center space-x-3 rounded-md px-3 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                                </svg>
                                <span>
                                    Transactions
                                 </span>
                            </h1>
                            <div class="w-full overflow-auto">
                                <table class="w-full mt-5 text-sm table-auto">
                                    <thead>
                                    <tr class="text-left border-b">
                                        <th class="px-3 py-2">Order</th>
                                        <th class="px-3 py-2">Cost</th>
                                        <th class="px-3 py-2">Transaction Date</th>
                                        <th class="px-3 py-2">Status</th>
                                        <th class="px-3 py-2">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="border-b">
                                            <td class="px-3 py-2 truncate max-w-xs">{{$transaction->order->items[0]->purchase_requirement->product}}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">$ {{number_format($transaction->cost,2)}}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{$timezoneService->localTime(auth('person')->user(), $transaction->created_at, "d D M Y h:i A")}}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                @switch($transaction->status)
                                                    @case(\App\Enums\TransactionStatus::Pending)
                                                    <span class="text-white bg-purple-200 font-normal text-sm px-2 py-1 rounded-md">
                                                        Completed
                                                    </span>
                                                    @break
                                                    @case(\App\Enums\TransactionStatus::Completed)
                                                    <span class="text-white bg-green-500 font-normal text-sm px-2 py-1 rounded-md">
                                                        Completed
                                                    </span>
                                                    @break
                                                    @case(\App\Enums\TransactionStatus::Failed)
                                                    <span class="text-white bg-red-500 font-normal text-sm px-2 py-1 rounded-md">
                                                        Completed
                                                    </span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="px-3 py-2">
                                                @if($transaction->receipt_url)
                                                <a target="_blank" href="{{$transaction->receipt_url}}" class="w-max text-white transform hover:bg-purple-700 bg-purple-500 px-3 py-2 mt-1 rounded inline-flex items-center text-sm">
                                                    View Receipt
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function menuClick(){
            return {
                currentmenu : 'transactions',
                change(vars){
                    this.currentmenu = vars
                },
                is_open(vars){
                    return this.currentmenu === vars
                },
                init() {
                    const url = new URL(window.location.href);
                    const tab = url.searchParams.get('tab');
                    if(tab) {
                        this.currentmenu = tab;
                    }
                }
            }
        }
    </script>
@endsection
