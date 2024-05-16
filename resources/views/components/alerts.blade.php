@if(auth('person')->user()->status === \App\Enums\Person\AccountStatus::Unverified)
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded my-4 relative" role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
            <div>
                <p class="font-bold">You account is unverified</p>
                <p class="text-sm">An agent will contact you shortly to verify your information, any purchase requirements you create will be unpublished until your account is verified.</p>
            </div>
        </div>
    </div>
@endif

@if(auth('person')->user()->status === \App\Enums\Person\AccountStatus::Suspended)
    <div role="alert" class="my-4 relative">
        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
            You account is suspended
        </div>
        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-70 flex flex-col md:flex-row justify-between">
            <p class="text-sm">Account has been suspended due to policy violations. Please contact customer support.</p>
            <button class="text-sm bg-white text-black-400 hover:bg-black-500 hover:text-white font-bold rounded p-2 shadow-md focus:outline-none whitespace-nowrap mt-2 md:mt-0">Contact support</button>
        </div>
    </div>
@endif

@if(auth('person')->user()->formattedPhoneNumber() && !auth('person')->user()->phone_verified_at)
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md rounded my-4 relative" role="alert">
        <div class="flex justify-between md:flex-row flex-col">
            <div class="py-1 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current h-6 w-6 text-teal-500 mr-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <div class="flex flex-col w-full">
                    <p class="font-bold">Your phone number is unverified</p>
                    <p class="text-sm">Verify your phone number to start receiving SMS alerts for meeting reminders and notifications.</p>
                </div>
            </div>
            <div class="items-center flex gap-2 justify-end mt-2 md:mt-0">
                <a href="{{route('person.profile.show', ['tab' => 'profile'])}}" class="bg-orange-500 text-white hover:bg-orange-600 rounded p-2 cursor-pointer whitespace-nowrap">Update phone number</a>
                <form action="{{route('person.phone.verification.send')}}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white hover:bg-green-600 rounded p-2 cursor-pointer whitespace-nowrap">Verify now</button>
                </form>
            </div>
        </div>
    </div>
@endif
