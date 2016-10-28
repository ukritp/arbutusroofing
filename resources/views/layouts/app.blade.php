<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Head + CSS File --}}
    @include('partials._head')

</head>

<body id="app-layout">

    @if (!Auth::guest())
        {{-- Top Navigation Bar --}}
        @include('partials._navtop')
    @endif

    <div class="container">

        <div class="row main-row">

            <div class="col-md-3 side-bar">
                {{-- Left Navigation Bar --}}
                @include('partials._navleft')
            </div>
            <div class="col-md-9 main-content">
                {{-- Messages + Notifications + Sessions --}}
                @include('partials._messages')

                {{-- Main Content --}}
                @yield('content')
            </div>

        </div>

        {{-- Footer --}}
        @include('partials._footer')

    </div>

    {{-- Javascript --}}
    @include('partials._javascript')

</body>
</html>
