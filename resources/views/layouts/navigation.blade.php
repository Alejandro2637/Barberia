<nav x-data="{ mobileMenuOpen: false }" class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-amber-700/30 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo + Navigation Links (left side) -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <x-application-logo class="block h-9 w-auto fill-current text-amber-400" />
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:ml-8 space-x-6">
                    <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-amber-400 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-amber-400">
                        Inicio
                    </a>
                    <a href="#nosotros" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-amber-400 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-amber-400">
                        Nosotros
                    </a>
                    <a href="#servicios" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-300 hover:text-amber-400 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-amber-400">
                        Servicios
                    </a>
                    <a href="#reserva" class="inline-flex items-center px-4 py-1.5 text-sm font-semibold text-white bg-amber-600 rounded-full hover:bg-amber-700 transition duration-150 ease-in-out shadow-md">
                        Reserva tu turno
                    </a>
                </div>
            </div>

            <!-- Right side: Auth or User Dropdown (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <!-- Authenticated User Dropdown (Jetstream style) -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-300 hover:text-amber-400 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.edit') }}">
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar Sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest: Login & Register buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-amber-400 border border-amber-400 rounded-full hover:bg-amber-400 hover:text-gray-900 transition duration-150">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-amber-600 rounded-full hover:bg-amber-700 transition duration-150 shadow">
                                Registrarse
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Hamburger Menu Button (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-amber-400 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-amber-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Menu -->
    <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="hidden sm:hidden bg-gray-800 border-t border-amber-700/30">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-amber-400 hover:bg-gray-700 border-l-4 border-transparent hover:border-amber-400 transition duration-150">
                Inicio
            </a>
            <a href="#nosotros" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-amber-400 hover:bg-gray-700 border-l-4 border-transparent hover:border-amber-400 transition duration-150">
                Nosotros
            </a>
            <a href="#servicios" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-amber-400 hover:bg-gray-700 border-l-4 border-transparent hover:border-amber-400 transition duration-150">
                Servicios
            </a>
            <a href="#reserva" class="block pl-3 pr-4 py-2 text-base font-medium text-amber-400 hover:text-white hover:bg-amber-600 transition duration-150">
                📅 Reserva tu turno
            </a>
        </div>

        <!-- Mobile Auth Links / User Menu -->
        <div class="pt-4 pb-3 border-t border-gray-700">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-amber-400 hover:bg-gray-700 transition duration-150">
                        Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-medium text-gray-300 hover:text-amber-400 hover:bg-gray-700 transition duration-150">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-2 px-4">
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2 text-sm font-medium text-amber-400 border border-amber-400 rounded-full hover:bg-amber-400 hover:text-gray-900 transition">
                        Iniciar Sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block text-center px-4 py-2 text-sm font-medium text-white bg-amber-600 rounded-full hover:bg-amber-700 transition">
                            Registrarse
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
