<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Gestion demandes</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Interface</div>

    <!-- Admin Section -->
    @if(Auth::user()->role === 'Admin')
        <!-- Utilisateurs -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
               aria-expanded="true" aria-controls="collapseUsers">
                <i class="fas fa-fw fa-user"></i>
                <span>Utilisateurs</span>
            </a>
            <div id="collapseUsers" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.users') }}">Nouvel utilisateur</a>
                    <a class="collapse-item" href="{{ route('index.users') }}">Tous les utilisateurs</a>
                </div>
            </div>
        </li>

        <!-- Catégories -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
               aria-expanded="true" aria-controls="collapseCategories">
                <i class="fas fa-tags"></i>
                <span>Catégories</span>
            </a>
            <div id="collapseCategories" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.categories') }}">Nouvelle catégorie</a>
                    <a class="collapse-item" href="{{ route('index.categories') }}">Toutes les catégories</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDemandesAdmin"
               aria-expanded="true" aria-controls="collapseDemandesAdmin">
                <i class="fas fa-clipboard-list"></i>
                <span>Demandes</span>
            </a>
            <div id="collapseDemandesAdmin" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.demandes') }}">Nouvelle demande</a>
                    <a class="collapse-item" href="{{ route('index.demandes') }}">Toutes les demandes</a>
                    <a class="collapse-item" href="{{ route('indexAdmin.demandes') }}">Mes demandes</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRessourcesAdmin"
               aria-expanded="true" aria-controls="collapseRessourcesAdmin">
                <i class="fas fa-briefcase"></i>
                <span>Ressources</span>
            </a>
            <div id="collapseRessourcesAdmin" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.demandes') }}">Nouvelle ressource</a>
                    <a class="collapse-item" href="{{ route('index.demandes') }}">Toutes les ressorces</a>
                </div>
            </div>
        </li>
    @endif

    <!-- Comptable Section -->
    @if(Auth::user()->role === 'Comptable')
        <!-- Demandes -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDemandesComptable"
               aria-expanded="true" aria-controls="collapseDemandesComptable">
                <i class="fas fa-clipboard-list"></i>
                <span>Demandes</span>
            </a>
            <div id="collapseDemandesComptable" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.demandes') }}">Nouvelle demande</a>
                    <a class="collapse-item" href="{{ route('index.demandes') }}">Toutes les demandes</a>
                    <a class="collapse-item" href="{{ route('indexComptable.demandes') }}">Mes demandes</a>
                </div>
            </div>
        </li>

        <!-- Caisse -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCaisse"
               aria-expanded="true" aria-controls="collapseCaisse">
                <i class="fas fa-wallet"></i>
                <span>Caisse</span>
            </a>
            <div id="collapseCaisse" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.demandes') }}">Créer une caisse</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('create.demandes') }}">
                <i class="fas fa-briefcase"></i> <span>Nouvelle ressource</span>
            </a>
        </li>
    @endif

    <!-- Employé Section -->
    @if(Auth::user()->role === 'Employe')
        <!-- Demandes -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDemandesEmploye"
               aria-expanded="true" aria-controls="collapseDemandesEmploye">
                <i class="fas fa-clipboard-list"></i>
                <span>Demandes</span>
            </a>
            <div id="collapseDemandesEmploye" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Actions :</h6>
                    <a class="collapse-item" href="{{ route('create.demandes') }}">Nouvelle demande</a>
                    <a class="collapse-item" href="{{ route('indexEmploye.demandes') }}">Mes demandes</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('create.demandes') }}">
                <i class="fas fa-briefcase"></i> <span>Nouvelle ressource</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
