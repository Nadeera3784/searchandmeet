@if (session('success'))
    <div class="flex w-full transform scale-95 max-w-screen sm:max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed  md:bottom-5 bottom-20 z-50 toast">
        <div class="flex items-center justify-center w-12 bg-green-500 flex-shrink-0">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
            </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="flex w-full transform scale-95 max-w-screen sm:max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed  md:bottom-5 bottom-20 z-50 toast">
        <div class="flex items-center justify-center w-12 bg-red-500 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-red-500 dark:text-red-400">Error</span>
                <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="flex w-full transform scale-95 max-w-screen sm:max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed  md:bottom-5 bottom-20 z-50 toast">
        <div class="flex items-center justify-center w-12 bg-yellow-500 flex-shrink-0">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
            </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-yellow-500 dark:text-yellow-400">Warning</span>
                <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('warning') }}</p>
            </div>
        </div>
    </div>
@endif

<div x-data="noticesHandler()" class="fixed inset-0 flex flex-col-reverse items-end justify-start h-screen w-screen z-50" @notice.window="add($event.detail)"
        style="pointer-events:none">
        <template x-for="notice of notices" :key="notice.id">
            <template x-if="visible.includes(notice) && notice.type === 'success'">
                <div @click="remove(notice.id)"
                     class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed bottom-5 left-5 z-20 toast">
                    <div class="flex items-center justify-center w-24 bg-green-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
                        </svg>
                    </div>

                    <div class="px-4 py-2 -mx-3">
                        <div class="mx-3">
                            <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                            <p class="text-sm text-gray-600 dark:text-gray-200" x-text="notice.text"></p>
                        </div>
                    </div>
                </div>
            </template>
        </template>
        <template x-for="notice of notices" :key="notice.id">
            <template x-if="visible.includes(notice) && notice.type === 'error'">
                <div @click="remove(notice.id)" class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed  bottom-5 left-5 z-20 toast">
                    <div class="flex items-center justify-center w-24  bg-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>

                    <div class="px-4 py-2 -mx-3">
                        <div class="mx-3">
                            <span class="font-semibold text-red-500 dark:text-red-400">Error</span>
                            <p class="text-sm text-gray-600 dark:text-gray-200" x-text="notice.text"></p>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    <template x-for="notice of notices" :key="notice.id">
        <template x-if="visible.includes(notice) && notice.type === 'info'">
            <div @click="remove(notice.id)" class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 fixed  bottom-5 left-5 z-20 toast">
                <div class="flex items-center justify-center w-24 bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-blue-500 dark:text-blue-400">Info</span>
                        <p class="text-sm text-gray-600 dark:text-blue-200" x-text="notice.text"></p>
                    </div>
                </div>
            </div>
        </template>
    </template>
    </div>


<script>
    var divs = document.querySelectorAll('.toast');
    setTimeout(() => {
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.add('toast-completed');
        }
    }, 5000);

    function noticesHandler() {
        return {
            notices: [],
            visible: [],
            add(notice) {
                notice.id = Date.now();
                this.notices.push(notice);
                this.fire(notice.id);
            },
            fire(id) {
                this.visible.push(this.notices.find(notice => notice.id === id));
                const timeShown = 5000 * this.visible.length;
                setTimeout(() => {
                    this.remove(id)
                }, timeShown)
            },
            remove(id) {
                const notice = this.visible.find(notice => notice.id === id);
                if(notice)
                {
                    const index = this.visible.indexOf(notice);
                    this.visible.splice(index, 1)
                }
            },
        }
    }
</script>

