<nav class="bg-gradient-to-l from-cyan-400 to-violet-500 px-2 sm:px-4 py-2.5 rounded">
    <div class="flex flex-wrap justify-between items-center mx-auto">
        <a href="{{ route('task.index') }}" class="flex items-center">
            <img src="/images/clock-svgrepo-com.svg" class="mr-3 h-6 sm:h-9" alt="Time Logo">
            <span class="self-center text-xl font-semibold whitespace-nowrap">Time management</span>
        </a>
        <div class="flex items-center md:order-2">
            <button type="button" class="flex mr-3 text-sm bg-gray-300 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="/images/users-svgrepo-com.svg" alt="user photo">
            </button>

            {{-- dropdown menu --}}
            <div class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow" id="dropdown" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1109px, 812px);" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top">
                <div class="py-3 px-4">
                    <span class="block text-sm text-gray-900">{{ auth()->user()->name }}</span>
                    <span class="block text-sm font-medium text-gray-500 truncate">{{ auth()->user()->email }}</span>
                </div>
                <ul class="py-1" aria-labelledby="dropdown">
                    <li>
                        <a href="{{ route('logout') }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                <li>
                    <a href="{{ route('task.index') }}" @class(["block py-2 pr-4 pl-3 hover:underline hover:font-bold hover:text-white", "text-red-700" => request()->routeIs('task.index')]) aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{ route('tracking.overview') }}" @class(["block py-2 pr-4 pl-3 hover:underline hover:font-bold hover:text-white", "text-red-700" => request()->routeIs('tracking.overview')])>Overview</a>
                </li>
                <li>
                    <a href="{{ route('customers.index') }}" @class(["block py-2 pr-4 pl-3 hover:underline hover:font-bold hover:text-white", "text-red-700" => request()->routeIs('customers.index')])>Customers</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
