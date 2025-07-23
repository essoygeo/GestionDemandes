<h5 class=" text-center text-primary-emphasis fw-bold mb-4"><i class="fa-solid fa-bars"></i> MENU</h5>

@if(Auth::user()->role ==='Admin')

    <ul class="nav flex-column ">
        <li class="nav-item border-bottom">

            <a href="{{ route('create.users') }}"
               class="nav-link   text-primary-emphasis hover-bg fw-semibold rounded px-3 py-2">
                <i class="fa-solid fa-user-plus"></i> Nouvel utilisateur
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.users')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-users"></i> Tous les utilisateurs
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('create.categories')}}"
               class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-layer-group"></i> Nouvelle categorie
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.categories')}}"
               class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-layer-group"></i> Toutes les categories
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('create.demandes')}}"
               class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-plus"></i> Nouvelle demande
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.demandes')}}"
               class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-bell"></i> Toutes les demandes
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('indexAdmin.demandes')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid  fa-bell"></i> Mes demandes
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('create.ressourcesSimples')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid  fa-plus"></i> Nouvelle ressource
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.demandes')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid   fa-folder"></i> Toutes les ressources
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.users')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid   fa-folder"></i> Mes ressources
            </a>
        </li>
    </ul>
    {{--comptable--}}

@elseif(Auth::user()->role ==='Comptable')
    <ul class="nav flex-column ">
    <li class="nav-item border-bottom">
        <a href="{{route('create.demandes')}}"
           class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid fa-plus"></i> Nouvelle demande
        </a>
    </li>

    <li class="nav-item border-bottom">
        <a href="{{route('index.demandes')}}"
           class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid  fa-bell"></i> Toutes les demandes
        </a>
    </li>
    <li class="nav-item border-bottom">
        <a href="{{route('indexComptable.demandes')}}"
           class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid  fa-bell"></i> Mes demandes
        </a>
    </li>
    <li class="nav-item border-bottom">
        <a href="{{route('create.ressourcesSimples')}}"
           class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid   fa-plus"></i> Nouvelle ressource
        </a>
    </li>
    <li class="nav-item border-bottom">
        <a href="{{route('indexAdmin.demandes')}}"
           class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid   fa-folder"></i> Toutes les ressources
        </a>
    </li>
    <li class="nav-item border-bottom">
        <a href="{{route('index.users')}}"
           class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
            <i class="fa-solid   fa-folder"></i> Mes ressources
        </a>
    </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.users')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid  fa-money-bill"></i> Caisse
            </a>
        </li>
    </ul>

{{---employe--}}

@elseif(Auth::user()->role ==='Employe')
    <ul class="nav flex-column ">
        <li class="nav-item border-bottom">
            <a href="{{route('create.demandes')}}"
               class="nav-link fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid fa-plus"></i> Nouvelle demande
            </a>
        </li>

        <li class="nav-item border-bottom">
            <a href="{{route('indexEmploye.demandes')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid  fa-bell"></i> Mes demandes
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('create.ressourcesSimples')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid   fa-plus"></i> Nouvelle ressource
            </a>
        </li>
        <li class="nav-item border-bottom">
            <a href="{{route('index.users')}}"
               class="nav-link  fw-semibold text-primary-emphasis hover-bg rounded px-3 py-2">
                <i class="fa-solid   fa-folder"></i> Mes ressources
            </a>
        </li>

    </ul>
@endif
