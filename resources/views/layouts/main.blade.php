<html>
    <head>
        <title> {{ $title ?? 'App' }} </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
    <body>

        <x-navbar />

        <div class='container'>

            {{ $slot }}

        </div>

    </body>
</html>