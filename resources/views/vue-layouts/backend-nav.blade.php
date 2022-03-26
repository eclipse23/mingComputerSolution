<nav class="bg-orange-600 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
        <div class="flex-shrink-0">
            <a href="/"><img class="h-8 w-8" src="{{ asset('img/ming-logo.png') }}" alt="Workflow"></a>
        </div>
        <div class="hidden md:block">
            @if(auth()->user())
                <div class="ml-10 flex items-baseline space-x-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin-products') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Products</a>

                        <a href="{{ route('admin-categories') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Categories</a>

                        <a href="{{ route('admin-orders') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Orders  <order-icon /></a>

                        <a href="{{ route('cashier') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Cashier</a>

                        <a href="{{ route('admin-messages') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Queries</a>

                        <a href="{{ route('reports') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Reports</a>
                        
                        <a href="{{ route('inventory') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">Inventory</a>
                        
                        <a href="{{ route('e-payment-logs') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 px-3 py-2 rounded-md text-sm font-medium">E-Payment Logs</a>
                    @endif
                </div>
            @endif
        </div>
        </div>
        <div class="hidden md:block">
            @if(auth()->user())
                <div class="ml-4 flex items-center md:ml-6">
                    @if(auth()->user()->isCustomer())
                        <user-icons></user-icons>
                    @endif
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button id="user-menu-button" type="button" class="max-w-xs bg-orange-600 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-orange-600 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                @if(auth()->user()->isAdmin())
                                    <img class="h-8 w-8 rounded-full" src="{{ asset('img/ming-logo.png') }}" alt="">
                                @else
                                    <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profilePicture() ? auth()->user()->profilePicture() : 'https://cdn.pixabay.com/photo/2014/04/03/10/32/businessman-310819_960_720.png' }}" alt="">
                                @endif
                            </button>
                        </div>

                    <!--
                        Dropdown menu, show/hide based on menu state.

                        Entering: "transition ease-out duration-100"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
                    <div id="user-menu" class="z-10 hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a class="block px-4 py-2 text-sm text-gray-700"  role="menuitem" tabindex="-1" id="user-menu-item-2" href="{{ route('settings') }}">
                            {{ __('User Settings') }}
                        </a>
                        <a class="block px-4 py-2 text-sm text-gray-700"  role="menuitem" tabindex="-1" id="user-menu-item-2" href="{{ route('change-password') }}">
                            {{ __('Change Password') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="block px-4 py-2 text-sm text-gray-700"  role="menuitem" tabindex="-1" id="user-menu-item-2" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                    </div>
                </div>
            @else
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                            <a href="{{ route('login') }}" class="text-white hover:text-gray-300 group w-full p-3 rounded-md flex flex-col items-center text-xs font-medium">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                <p class="text-xs">Login/Register</p>
                            </a>
                    </div>
                </div> 
            @endif
        </div>
        <div class="-mr-2 flex md:hidden">
        <!-- Mobile menu button -->
        @if(auth()->user())
            @if(auth()->user()->isAdmin())
                <button id="hamburger" type="button" class="bg-orange-600 inline-flex items-center justify-center p-2 rounded-md text-orange-200 hover:text-white hover:bg-orange-500 hover:bg-opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-orange-600 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!--
                    Heroicon name: outline/menu

                    Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!--
                    Heroicon name: outline/x

                    Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @else
                <div class="ml-4 flex items-center md:ml-6">
                    <user-icons></user-icons>
                </div>
            @endif
        @else
            <a href="{{ route('login') }}" class="text-white inline-block no-underline hover:text-gray-500" href="#">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
            </a>
        @endif
        </div>
    </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden">
    <div id="nav-sub-menu" class="hidden px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <!-- Current: "bg-orange-700 text-white", Default: "text-white hover:bg-orange-500 hover:bg-opacity-75" -->
        @if(auth()->user())
            @if(auth()->user()->isCustomer())
                customersds
            @else
                <a href="{{ route('admin-products') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Products</a>

                <a href="{{ route('admin-categories') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Categories</a>

                <a href="{{ route('reports') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Reports</a>

                <a href="{{ route('admin-orders') }}" href="#" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Orders <order-icon /></a>

                <a href="{{ route('cashier') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Cashier</a>
                
                <a href="{{ route('admin-messages') }}" href="#" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Queries</a>

                <a href="{{ route('inventory') }}" href="#" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Inventory</a>

                <a href="{{ route('e-payment-logs') }}" href="#" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">E-Payment Logs</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="text-white hover:bg-orange-500 hover:bg-opacity-75 block px-3 py-2 rounded-md text-base font-medium">Login</a>
        @endif
    </div>
    @if(auth()->user())
        <div class="pt-4 pb-3 border-t border-orange-700">
            <div id="mobile-user-menu" class="flex items-center px-5">
                @if(auth()->user()->isAdmin())
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ asset('img/ming-logo.png') }}" alt="">
                    </div>
                @else
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->profilePicture() ? auth()->user()->profilePicture() : 'https://cdn.pixabay.com/photo/2014/04/03/10/32/businessman-310819_960_720.png' }}" alt="">
                    </div>
                @endif
                <div class="ml-3">
                    <div class="text-base font-medium text-white">{{ auth()->user()->name }}</div>
                    <div class="text-sm font-medium text-orange-300">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div id="mobile-menu" class="hidden mt-3 px-2 space-y-1">
                <a class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-orange-500 hover:bg-opacity-75" href="{{ route('settings') }}">
                    {{ __('User Settings') }}
                </a>
                <a class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-orange-500 hover:bg-opacity-75" href="{{ route('change-password') }}">
                    {{ __('Change Password') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-orange-500 hover:bg-opacity-75" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
            </div>
        </div>
    @endif
    </div>
</nav>