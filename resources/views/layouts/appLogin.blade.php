<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <title>@yield('title','Gestion des demandes')</title>

</head>


<body class="bg-gradient-success">

<div class="container">

   @yield('content')
</div>
<!-- Outer Row -->



@include('partials.jsBody')

</body>

</html>
