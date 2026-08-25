<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex-col justify-center leading-tight">
                        <span class="text-lg font-bold text-teal-700">Spedition Neumann GmbH</span>
                        <span class="text-[10px] text-gray-500 hidden xl:block">Effiziente Logistik. Klar. Verlässlich. Norddeutsch.</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if (auth()->user()->role !== 'kunde')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'administrator')
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center h-16 px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                 {{ request()->routeIs('articles.*','storage-locations.*','stock-movements.*') ? 'border-teal-500 text-gray-900': 'border-transparent text-gray-500
                                 hover:text-teal-700 hover:border-teal-300' }}">
                                    Lager
                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1
                                    1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('articles.index')">Artikel</x-dropdown-link>
                                <x-dropdown-link :href="route('categories.index')">Kategorien</x-dropdown-link>
                                <x-dropdown-link :href="route('storage-locations.index')">Lagerplatz</x-dropdown-link>
                                <x-dropdown-link :href="route('stock-movements.index')">Buchungen</x-dropdown-link>
                                <x-dropdown-link :href="route('stock-movements.deliveries')">Lieferungen</x-dropdown-link>
                                <x-dropdown-link :href="route('articles.stock')">Bestand</x-dropdown-link>

                            </x-slot>
                        </x-dropdown>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center h-16 px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                 {{ request()->routeIs('sales.*','reservations.*','reports.z','invoices.index') ? 'border-teal-500 text-gray-900': 'border-transparent text-gray-500
                                 hover:text-teal-700 hover:border-teal-300' }}">
                                    Verkauf
                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1
                                    1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('sales.index')">Kasse</x-dropdown-link>
                                <x-dropdown-link :href="route('reservations.index')">Reservierungen</x-dropdown-link>
                                <x-dropdown-link :href="route('reports.z')">Z-Bericht</x-dropdown-link>
                                <x-dropdown-link :href="route('invoices.index')">Rechnungen</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>

                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center h-16 px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                 {{ request()->routeIs('customers.*','users.*') ? 'border-teal-500 text-gray-900': 'border-transparent text-gray-500
                                 hover:text-teal-700 hover:border-teal-300' }}">
                                    Verwaltung
                                    <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1
                                    1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('customers.index')">Kunden</x-dropdown-link>
                                <x-dropdown-link :href="route('users.index')">Benutzer</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif


                    @if (auth()->user()->role ==='kassenkraft')
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">
                            {{ __('Kasse') }}
                        </x-nav-link>
                        <x-nav-link :href="route('articles.stock')" :active="request()->routeIs('articles.stock')">
                            {{ __('Bestand') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                            {{ __('Reservierungen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reports.z')" :active="request()->routeIs('reports.z')" class="whitespace-nowrap">
                            {{ __('Z-Bericht') }}
                        </x-nav-link>
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                            {{ __('Kunden') }}
                        </x-nav-link>
                        <x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.index')">
                            {{ __('Rechnungen') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'spediteur')
                        <x-nav-link :href="route('stock-movements.deliveries')" :active="request()->routeIs('stock-movements.deliveries')">
                            {{ __('Lieferungen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pickups.index')" :active="request()->routeIs('pickups.index')">
                            {{ __('Abholungen') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'lagermitarbeiter')
                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                            {{ __('Artikel') }}
                        </x-nav-link>
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                            {{ __('Kategorien') }}
                        </x-nav-link>
                        <x-nav-link :href="route('pickups.create')" :active="request()->routeIs('pickups.create')">
                            {{ __('Abholung anlegen') }}
                        </x-nav-link>
                        <x-nav-link :href="route('storage-locations.index')" :active="request()->routeIs('storage-locations.*')">
                            {{ __('Lagerplätze') }}
                        </x-nav-link>
                        <x-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.index')">
                            {{ __('Bestand') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'lagermitarbeiter')
                        <x-nav-link :href="route('stock-movements.index')" :active="request()->routeIs('stock-movements.*')">
                            {{ __('Buchungen') }}
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->role === 'kunde')
                        <x-nav-link :href="route('portal.index')" :active="request()->routeIs('portal.*')">
                            {{ __('Kundenportal') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Ausloggen') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->role !== 'kunde')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(auth()->user()->role, ['administrator','spediteur']))
                <x-responsive-nav-link :href="route('stock-movements.deliveries')" :active="request()->routeIs('stock-movements.deliveries')">
                    {{ __('Lieferungen') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->role === 'spediteur')
                <x-responsive-nav-link :href="route('pickups.index')" :active="request()->routeIs('pickups.index')">
                    {{ __('Abholungen') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(auth()->user()->role, ['administrator', 'lagermitarbeiter']))
                <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                    {{ __('Artikel') }}
                 </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                    {{ __('Kategorien') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('storage-locations.index')" :active="request()->routeIs('storage-locations.*')">
                    {{ __('Lagerplätze') }}
                </x-responsive-nav-link>
            @endif
            @if (in_array(auth()->user()->role, ['lagermitarbeiter', 'administrator']))
                <x-responsive-nav-link :href="route('stock-movements.index')" :active="request()->routeIs('stock-movements.*')">
                    {{ __('Buchungen') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->role === 'lagermitarbeiter')
                <x-responsive-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.index')">
                    {{ __('Bestand') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pickups.create')" :active="request()->routeIs('pickups.create')">
                    {{ __('Abholung anlegen') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(auth()->user()->role, ['kassenkraft', 'administrator']))
                <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">
                    {{ __('Kasse') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('articles.stock')" :active="request()->routeIs('articles.stock')">
                    {{ __('Bestand') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                    {{ __('Reservierungen') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.z')" :active="request()->routeIs('reports.z')" class="whitespace-nowrap">
                    {{ __('Z-Bericht') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                    {{ __('Kunden') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.index')">
                    {{ __('Rechnungen') }}
                </x-responsive-nav-link>
            @endif

            @if (in_array(auth()->user()->role, ['administrator']))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Benutzer') }}
                </x-responsive-nav-link>
            @endif

            @if(auth()->user()->role === 'kunde')
                <x-responsive-nav-link :href="route('portal.index')" :active="request()->routeIs('portal.*')">
                    {{ __('Kundenportal') }}
                </x-responsive-nav-link>
            @endif



        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Ausloggen') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
