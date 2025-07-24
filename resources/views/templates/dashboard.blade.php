<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard')</title>


</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-violet">
    <div class="container-fluid">
        <span class="navbar-brand">Tableau de bord</span>

        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->role }} {{ Auth::user()->nom }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar (fourni par chaque vue spécifique) -->
        <div class="col-md-3 col-lg-2 bg-white border-end min-vh-100 p-3">
            @include('partials.sidebar')
        </div>
        <main class="col-md-9 col-lg-10 py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
</div>



</body>
</html>
