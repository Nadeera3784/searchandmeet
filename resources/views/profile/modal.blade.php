<div x-data="lead()" x-init="init()" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 ">
    <div class="modal-overlay absolute w-full h-full bg-gray-600 opacity-50 z-50"></div>

    <div class="modal-container bg-white w-11/12 md:w-max md:mx-auto rounded-lg shadow-lg z-50 overflow-y-auto mx-3">

      <div class="modal-content text-left w-full mx-auto relative flex">
        <div class="overflow-hidden col-span-1">
          <img class=" h-full w-80  object-cover" src="/img/hero-image-2.png" alt="content-2-img1.png">
        </div>

        <div class="py-8 px-9  ">
          <div class="flex justify-between items-center ">
            <p class="text-xl font-bold mr-8 text-primary">Meet & Close The Deal</p>
            <div class="modal-close cursor-pointer z-50 ml-auto" @click="toggleModal()">
              <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
              </svg>
            </div>
          </div>

          <div class="">
              {!! Form::open(['url' => '', 'class' => 'modal_form', '@submit' => 'submit()', 'x-on:submit' => 'event.preventDefault()']) !!}
                <div class="flex flex-col justify-end py-4 space-y-4">
                    <div class="md:w-60 w-full">
                        {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('name', old('name'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        <div x-show="errors.name" x-text="errors.name ? errors.name[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-96 w-full">
                        {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('email', old('email'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        <div x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-60 w-full">
                        {!! Form::label('bname', 'Business Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('bname', old('bname'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        <div x-show="errors.b_name" x-text="errors.b_name ? errors.b_name[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-60 w-full">
                        {!! Form::label('mobile', 'Mobile', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('mobile', old('mobile'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        <div x-show="errors.mobile" x-text="errors.mobile ? errors.mobile[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-96 w-full">
                        {!! Form::label('website', 'Website Url', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('website', old('website'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        <div x-show="errors.website" x-text="errors.website ? errors.website[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-96 w-full">
                        {!! Form::label('slot', 'Time Slot', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('slot', $timeslots, old('slot'), ['placeholder' => 'Available Slot', 'required' => 'required', 'class' => 'block w-full mt-3 text-sm p-2 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300']) !!}

                        <div x-show="errors.slot" x-text="errors.slot ? errors.slot[0] : ''" class="text-xs text-red-700"></div>
                    </div>

                    <div class="md:w-96 w-full">
                        {!! Form::submit('Send', ['class' => 'cursor-pointer text-sm mt-2 font-medium font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-primary text-white rounded-sm ']); !!}

                        <div x-show="success==true" class="text-sm inline-block text-green-700 mt-4 px-4">Enquiry submitted.</div>
                    </div>
                </div>
              {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
</div>

  <script>
      window.addEventListener('load',()=>{
          var openmodal = document.querySelectorAll('.modal-open')
          for (var i = 0; i < openmodal.length; i++) {
            openmodal[i].addEventListener('click', function(event){
              event.preventDefault()
              toggleModal()
            })
          }

          const overlay = document.querySelector('.modal-overlay')
          overlay.addEventListener('click', toggleModal)

          document.onkeydown = function(evt) {
            evt = evt || window.event
            var isEscape = false
            if ("key" in evt) {
              isEscape = (evt.key === "Escape" || evt.key === "Esc")
            } else {
              isEscape = (evt.keyCode === 27)
            }
            if (isEscape && document.body.classList.contains('modal-active')) {
              toggleModal()
            }
          };

          function toggleModal () {
            const body = document.querySelector('body')
            const modal = document.querySelector('.modal')
            modal.classList.toggle('opacity-0')
            modal.classList.toggle('pointer-events-none')
            body.classList.toggle('modal-active')
            $('.modal_form').trigger("reset");
          }
      })

      function lead () {
        return {
          errors: [],
          success: false,
          init() {
            // console.log('its alpine')
          },
          toggleModal() {
            const body = document.querySelector('body');
            const modal = document.querySelector('.modal');
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');
            document.querySelector('.modal_form').reset();

            this.success = false;
          },
          submit(event) {

              window.axios.post('{{route('inquire')}}', {
                  name: document.querySelector("input[name='name']").value,
                  email: document.querySelector("input[name='email']").value,
                  b_name: document.querySelector("input[name='bname']").value,
                  mobile: document.querySelector("input[name='mobile']").value,
                  website: document.querySelector("input[name='website']").value,
                  slot: document.querySelector("select[name='slot']").value,
              })
              .then((response) => {
                // console.log(response);
                this.success = true;
                document.querySelector('.modal_form').reset();
                setTimeout(() => { this.toggleModal(); }, 1000);
              })
              .catch((e) => {
                if(e.response) {
                  this.errors = e.response.data.errors
                }
              });
          }
        }
      }
  </script>
