<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ $title ?? 'DDIGraph' }} </title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>

    <x-layouts.navbar></x-layouts.navbar>

    <main class="container flex-grow-1 py-4">
        {{ $slot }}   
    </main>

    <footer></footer>

</body>
</html>