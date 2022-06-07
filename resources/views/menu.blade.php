<nav class="flex p-2 bg-gradient-to-r from-violet-600 to-blue-200 rounded-lg shadow-md m-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 grow pl-2">
        <li class="inline-flex items-center">
            <a href="{{ route('task.index') }}" class="inline-flex items-center font-medium text-white hover:text-black hover:underline">
                <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Home
            </a>
        </li>
        @hasSection('breadcrumb')
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 font-medium text-gray-300 md:ml-2">@yield('breadcrumb')</span>
                </div>
            </li>
        @endif
    </ol>
    <ol class="inline-flex text-slate-500 pr-2">
        <a href="{{ route('logout') }}" class="font-medium text-blue-600 hover:font-bold hover:underline hover:text-red-800 hover:text-xl">Logout</a>
    </ol>
</nav>
