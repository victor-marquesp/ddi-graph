<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') | {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

    @stack('styles')

</head>

<body class="app">

    @unless (View::hasSection('hide-navbar'))

        <x-layout.navbar />

    @endunless

    <main id="main-content" class="app__main">

        <div class="container @yield('container-class')">

            <div class="stack stack--lg">

                {{-- Flash messages --}}

                @if (session('success'))

                    <x-ui.alert variant="success">
                        {{ session('success') }}
                    </x-ui.alert>

                @endif

                @if (session('error'))

                    <x-ui.alert variant="danger">
                        {{ session('error') }}
                    </x-ui.alert>

                @endif

                @if (session('warning'))

                    <x-ui.alert variant="warning">
                        {{ session('warning') }}
                    </x-ui.alert>

                @endif

                @if (session('info'))

                    <x-ui.alert variant="info">
                        {{ session('info') }}
                    </x-ui.alert>

                @endif

                {{-- Page content --}}

                @yield('content')

            </div>

        </div>

    </main>

    @unless (View::hasSection('hide-footer'))

        <x-layout.footer />

    @endunless

    @stack('scripts')

</body>

</html>