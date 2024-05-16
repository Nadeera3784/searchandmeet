@extends('layouts.admin')
@section('content')
    @inject('costCalculatorService',  'App\Services\Cart\CostCalculatorService')
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                    <h1 class="text-xl font-bold text-gray-500">
                        {{ __('Packages') }}
                    </h1>
                </div>
                <a href="{{route('agent.packages.create')}}" class="bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-blue-100 text-sm font-medium px-2 py-1  rounded float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg> Add New
                </a>
            </div>
            <div class="flow-root my-3">
                <div class="flex-col">
                    <div class="flex">
                        <span>Search by</span>
                    </div>
                    {!! Form::open(['url' => route('agent.purchase_requirements.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                        <div class="flex-col">
                            {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('keyword', request()->get('keyword'), ['placeholder' => 'Search keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                        </div>
                        <div class="flex-col w-96">
                            @component('components.peopleSearch')
                                @slot('nativeSelection')
                                    true
                                @endslot
                                @slot('personID')
                                    null
                                @endslot
                                @slot('labelClass')
                                    block text-sm font-medium text-gray-700 required
                                @endslot
                                @slot('selectClass')
                                    mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md
                                    shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                    md:text-sm text-base
                                @endslot
                            @endcomponent
                        </div>

                        <div>
                            <div class="flex-col">
                                {!! Form::label('date', 'Date Filter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                {!! Form::date('date', request()->get('date'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                            </div>
                         </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm" x-data="paymentActionsHandler()">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if($packages->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200 table-fixed w-100">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Title
                                            </th>
                                            <th scope="col" class=" px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Country
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Meeting count
                                            </th>
                                            <th scope="col" class=" px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Remaining quota
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Discount rate
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Estimated cost
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($packages as $package)
                                            <tr>
                                                <td class="px-6 py-3 text-xs font-medium text-gray-700">
                                                    {{ $package->title }}
                                                </td>
                                                <td class="px-6 py-3 text-xs font-medium text-gray-700">
                                                    {{ $package->country->name }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ $package->allowed_meeting_count }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ $package->allowed_meeting_count - $package->quota_used }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{$package->person->name}} {{$package->person->email}}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ number_format($package->discount_rate, 2) }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    ${{ number_format($costCalculatorService->calculatePackageCost($package)) }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500 flex flex-col gap-1">
                                                    <span class="bg-gray-700 rounded text-white px-4 py-1">{{\App\Enums\Package\PackageStatus::getDescription($package->status)}}</span>
                                                    @if($package->status === \App\Enums\Package\PackageStatus::Awaiting_Payment)
                                                        <span class="bg-blue-700 hover:bg-blue-800 rounded text-white px-4 py-1 cursor-pointer" @click="copyToClipboard('{{$package->payment_link}}')">Copy payment link</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-3 text-right text-xs font-medium">
                                                    <a href="{{route('agent.people.show', $package->person->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-yellow-800 hover:text-yellow-100 transition-colors duration-150 bg-yellow-200 rounded focus:shadow-outline hover:bg-yellow-500">
                                                        Person
                                                    </a>
                                                    <a href="{{route('agent.packages.show', $package->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-blue-800 hover:text-blue-100 transition-colors duration-150 bg-blue-200 rounded focus:shadow-outline hover:bg-blue-500">
                                                        View
                                                    </a>
                                                    <form action="{{route('agent.packages.destroy', $package->getRouteKey())}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure want to delete this record?')"  class="items-center px-2 py-1 ml-1 text-xs text-red-800 font-medium hover:text-red-100 transition-colors duration-150 bg-red-200 rounded focus:shadow-outline hover:bg-red-500">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                </table>
                                @else
                                    <div class="h-16 p-10 flex justify-center items-center">
                                        <span class="text-md italic text-gray-500">No packages to show</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                {{$packages->links()}}
            </div>
        </div>
    </div>

    <script>
        function paymentActionsHandler()
        {
            return {
                copyToClipboard(text) {
                    if(navigator.clipboard)
                    {
                        navigator.clipboard.writeText(text).then(function() {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type': 'success',
                                    'text': 'Copied to clipboard'
                                }
                            });

                            window.dispatchEvent(event);
                        }, function(err) {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type': 'error',
                                    'text': 'Clipboard unavailable, please copy manually'
                                }
                            });
                            window.dispatchEvent(event);
                        });
                    }
                    else
                    {
                        let event = new CustomEvent('notice', {
                            detail: {
                                'type': 'error',
                                'text': 'Clipboard unavailable, please copy manually'
                            }
                        });
                        window.dispatchEvent(event);
                    }

                },
            }
        }
    </script>
@endsection
