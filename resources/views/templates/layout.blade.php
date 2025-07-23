<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/scss/app.scss','resources/js/app.js'])
</head>
<body>

@yield('content')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif

        @if($errors->has('email'))
        toastr.error("{{ $errors->first('email') }}");
        @endif
    });
</script>

</body>
</html>




