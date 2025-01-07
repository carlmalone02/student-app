{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    {{-- Include CSS/JS here --}}
</head>
<body>
    <header>
        {{-- Navigation, Logo, etc. --}}
    </header>

    <main>
        @yield('content')  {{-- Child views' content will be injected here --}}
    </main>

    <footer>
        {{-- Footer content --}}
    </footer>
</body>
</html>
