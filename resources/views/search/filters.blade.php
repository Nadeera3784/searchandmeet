<div class="w-full">
    <form action="">
        <p class="text-xl font-bold mt-5">Search keywords </p>
        <div class="grid gap-2 grid-cols-1 grid-rows-1 my-5">
            {!! Form::input('text', 'keywords', old('keywords'), ['placeholder' => 'Enter search keywords', 'class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}

        </div>

        <p class="text-xl font-bold">Availability</p>
        <div class="grid gap-2 grid-cols-1 w-full mt-5 ml-2">
            <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'today', (request()->get('availability') == 'today' || in_array('today', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold">Today</span>
            </label>

            <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'thisweek', (request()->get('availability') == 'thisweek' || in_array('thisweek', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold">This Week</span>
            </label>

              <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'nextmonth', (request()->get('availability') == 'nextmonth' || in_array('nextmonth', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold ">Next Month</span>
            </label>

              <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'tomorrow', (request()->get('availability') == 'tomorrow' || in_array('tomorrow', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold">Tomorrow</span>
            </label>

              <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'thismonth', (request()->get('availability') == 'thismonth' || in_array('thismonth', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold">This Month</span>
            </label>

              <label class="width-fit-content">
                {!! Form::checkbox('availability[]', 'all', (request()->get('availability') == 'all' || in_array('all', request()->get('availability') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                <span class="ml-1  cursor-pointer font-semibold">All</span>
            </label>
        </div>

        <p class="text-xl font-bold mt-5">Purchase Value USD </p>
        <div class="grid gap-2 grid-cols-2 grid-rows-1">
            {!! Form::input('number', 'min_price', old('min_price'), ['placeholder' => 'Min price', 'class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
            {!! Form::input('number', 'max_price', old('max_price'), ['placeholder' => 'Max price', 'class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
        </div>

        <p class="text-xl font-bold mt-5">Company Type</p>
        <div class="grid gap-2 grid-cols-1 w-full mt-5 ml-2">
            @foreach($company_types as $key => $value)
                <label class="width-fit-content">
                    {!! Form::checkbox('company_type[]', $key, (request()->get('type') == $key|| in_array($key, request()->get('type') ?? [])), ['class' => 'text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray']) !!}
                    <span class="ml-1  cursor-pointer font-semibold">{{$value}}</span>
                </label>
            @endforeach
        </div>

        <p class="text-xl font-bold mt-5">Job Title</p>
        {!! Form::select('designation', $contact_titles, request()->get('designation'), ['class' => 'block w-full mt-3 ml-2 text-sm p-2 pl-10 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300', 'placeholder' => '- Select Job Title -']) !!}

        <p class="text-xl font-bold mt-5">Category</p>
        {!! Form::select('category', $categories, request()->get('category'), ['class' => 'block w-full mt-3 ml-2 text-sm p-2 pl-10 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300', 'placeholder' => '- Select Category -']) !!}

        <p class="text-xl font-bold mt-5">Country</p>
        {!! Form::select('country', $countries, request()->get('country'), ['class' => 'block w-full mt-3 ml-2 text-sm p-2 pl-10 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300', 'placeholder' => '- Select Country -']) !!}

        <br>
        {!! Form::submit('Search', ['class' => "block w-full mt-3 ml-2 text-sm p-2 bg-primary hover:bg-primary_hover cursor-pointer text-white border-solid border border-gray-200 focus:outline-none rounded focus:border-primary"]) !!}
    </form>
</div>
