<nav class="h-full shadow-lg fixed p-2 items-center align-middle w-full overflow-auto">
    <div class="flex justify-normal items-center">
        <img src="{{ asset('img/logo.jpg') }}" class="mx-2 w-10">
        <h1 class="text-2xl font-bold">Samahang Nayon</h1>
    </div>

    {{-- Admin sidebar --}}
    @if (Auth::check() && Auth::user()->Position === 'System Administrator')
        <ul class="items-center pt-7">
            <x-menu-item title="Dashboard" url="{{ route('dashboard') }}" icon="fas fa-tachometer-alt mx-2" active="{{ request()->routeIs('dashboard') }}" />
        </ul>

        <hr>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Management
            </li>
            <x-menu-item title="User Account Management" url="{{ route('user') }}" icon="fas fa-users-cog mx-2" active="{{ request()->routeIs('user') }}" />
            <x-menu-item title="Room Management" url="{{ route('rooms') }}" icon="fas fa-door-open mx-2" active="{{ request()->routeIs('rooms') }}" />
            <x-menu-item title="Activity Log" url="{{ route('system-log') }}" icon="fas fa-file-alt mx-2" active="{{ request()->routeIs('system-log') }}" />
        </ul>

        <hr>
        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Others
            </li>
            <x-menu-item title="Setting" url="{{ route('settings') }}" icon="fas fa-cog mx-2" active="{{ request()->routeIs('settings') }}" />
        </ul>
    @endif

    {{-- Receptionist sidebar --}}
    @if (Auth::check() && Auth::user()->Position === 'Receptionist')
        <ul class="items-center pt-7">
            <x-menu-item title="Dashboard" url="{{ route('dashboard') }}" icon="fas fa-tachometer-alt mx-2" active="{{ request()->routeIs('dashboard') }}" />
        </ul>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Management
            </li>
            <x-menu-item title="Booking" url="{{ route('booking') }}" icon="fas fa-calendar-check mx-2" active="{{ request()->routeIs('booking') }}" />
            <x-menu-item title="Room" url="{{ route('receptionistRoom') }}" icon="fas fa-door-open mx-2" active="{{ request()->routeIs('receptionistRoom') }}" />
            <x-menu-item title="Payment" url="{{ route('payment') }}" icon="fas fa-credit-card mx-2" active="{{ request()->routeIs('payment') }}" />
            <x-menu-item title="Message" url="{{ route('message') }}" icon="fas fa-envelope mx-2" badge="true" badgeCount="1" active="{{ request()->routeIs('message') }}" />
            <x-menu-item title="Amenities" url="{{ route('amenities') }}" icon="fas fa-concierge-bell mx-2" active="{{ request()->routeIs('amenities') }}" />
            <x-menu-item title="Check-in/out" url="{{ route('check-in-out') }}" icon="fas fa-sign-in-alt mx-2" active="{{ request()->routeIs('check-in-out') }}" />
            <x-menu-item title="Report" url="{{ route('report') }}" icon="fas fa-chart-bar mx-2" active="{{ request()->routeIs('report') }}" />
        </ul>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Other
            </li>
            <x-menu-item title="Setting" url="{{ route('settings') }}" icon="fas fa-cog mx-2" active="{{ request()->routeIs('settings') }}" />
        </ul>
    @endif

    {{-- Manager sidebar --}}
    @if (Auth::check() && Auth::user()->Position === 'Manager')
        <ul class="items-center pt-7">
            <x-menu-item title="Dashboard" url="{{ route('dashboard') }}" icon="fas fa-tachometer-alt mx-2" active="{{ request()->routeIs('dashboard') }}" />
        </ul>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Management
            </li>
            <x-menu-item title="Promotions" url="{{ route('promotion') }}" icon="fas fa-bullhorn mx-2" active="{{ request()->routeIs('promotion') }}" />
        </ul>

        <ul class="items-center pt-3 text-gray-700">
            <li class="mb-2 font-bold">
                Other
            </li>
            <x-menu-item title="Setting" url="{{ route('settings') }}" icon="fas fa-cog mx-2" active="{{ request()->routeIs('settings') }}" />
        </ul>
    @endif
</nav>
