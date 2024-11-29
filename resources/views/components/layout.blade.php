<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ $attributes }}>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

        @stack('meta')

        <title>{{ $title ?? 'BlockchainTraders' }}</title>

        <link rel="icon" type="image/x-icon" href="/assets/images/Logo.svg">

        @vite(['resources/css/app.css'])

        @stack('vite')

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link href="https://fonts.cdnfonts.com/css/graphik" rel="stylesheet">
        
        @livewireStyles

        @stack('styles')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        
        @stack('scripts')
    </head>
    <body>
        {{ $slot }}

        @livewireScripts

        @stack('foot')
    </body>
</html>