<html>
    <head>
        <title> {{ $title ?? 'App' }} </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {{-- Start styles --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
        {{-- End styles --}}
    </head>


    <body>


        <div class='page page-center'>

            {{ $slot }}

        </div>

        {{-- Start scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
        {{-- End scripts --}}
    </body>
</html>