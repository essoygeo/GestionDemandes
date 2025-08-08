<?php

//use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ComptableController;
use App\Http\Controllers\controlDashbordController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RessourceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





//Auth
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm'=>false,


]);
Route::get('/', [ControlDashbordController::class, 'index'])->name('controldashbord')->middleware('auth');

//route pour email des demande
Route::middleware('auth')->group(function (){
    Route::get('/messages/{demande}', [DemandeController::class, 'show'])->name('message.index');



//Demandes(commun)
    Route::get('/create/demande', [DemandeController::class, 'create'])->name('create.demandes');
    Route::post('/store/demande', [DemandeController::class, 'store'])->name('store.demandes');
    Route::get('/show/demande/{demande}', [DemandeController::class, 'show'])->name('show.demandes');
    Route::get('/edit/demande/{demande}', [DemandeController::class, 'edit'])->name('edit.demandes');
    Route::put('/edit/demande/{demande}', [DemandeController::class, 'update'])->name('update.demandes');
    Route::DELETE('/destroy/demande/{demande}', [DemandeController::class, 'destroy'])->name('destroy.demandes');
//Commentaires(commun)
   // Route::get('/demande/{demande}/commentaires', [CommentaireController::class, 'show'])->name('show.commentaires');
    Route::post('/demande/{demande}/commentaires', [CommentaireController::class, 'store'])->name('store.commentaires');
//Ressources(commun)
    //Route::get('/create/demande/{demande?}/ressource/', [RessourceController::class, 'create'])->name('create.ressources');
   // Route::get('/create/ressource/', [RessourceController::class, 'create'])->name('create.ressourcesSimples');
    //Route::get('/show/ressource/{ressource}', [RessourceController::class, 'show'])->name('show.ressources');
    // Route::get('/edit/ressource/{ressource}', [RessourceController::class, 'edit'])->name('edit.ressources');
    Route::post('/store/ressource', [RessourceController::class, 'store'])->name('store.ressources');
    Route::put('/update/ressource/{ressource}/{pivotId}', [RessourceController::class, 'update'])->name('update.ressources');
    Route::DELETE('/destroy/ressource/{ressource}', [RessourceController::class, 'destroy'])->name('destroy.ressources');

// voir son profile(commun)
    Route::get('/show/user/{user}', [AdminController::class, 'show'])->name('show.users');
    //resetPassword(commun)
    Route::get('/edit/password', [PasswordController::class, 'edit'])->name('edit.password');
    Route::put('/update/password', [PasswordController::class, 'update'])->name('update.password');
//notifications(commun)
    Route::post('/notifications/clear', [NotificationController::class, 'clear'])->name('notifications.clear');
    Route::get('/notifications/user', [NotificationController::class, 'Allnotification'])->name('notifications.all');
//dashboard employe (commun)
    Route::get('/user/dashboard', [ControlDashbordController::class, 'employeDashboard'])->name('employe.dashboard');

});


//Admin
Route::middleware('checkrole:Admin')->group(function (){
    Route::get('/admin/dashboard', [ControlDashbordController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/create/user', [AdminController::class, 'create'])->name('create.users');
    Route::post('/admin/store/user', [AdminController::class, 'store'])->name('store.users');
    Route::get('/admin/index/user', [AdminController::class, 'index'])->name('index.users');
    Route::get('/admin/edit/user/{user}', [AdminController::class, 'edit'])->name('edit.users');
    Route::put('/admin/edit/user/{user}', [AdminController::class, 'update'])->name('update.users');
    Route::DELETE('/admin/destroy/user/{user}', [AdminController::class, 'destroy'])->name('destroy.users');


    Route::get('/admin/create/categorie', [CategorieController::class, 'create'])->name('create.categories');
    Route::post('/admin/store/categorie', [CategorieController::class, 'store'])->name('store.categories');
    Route::get('/admin/index/categorie', [CategorieController::class, 'index'])->name('index.categories');
    Route::get('/admin/show/categorie/{categorie}', [CategorieController::class, 'show'])->name('show.categories');
    Route::get('/admin/edit/categorie/{categorie}', [CategorieController::class, 'edit'])->name('edit.categories');
    Route::put('/admin/edit/categorie/{categorie}', [CategorieController::class, 'update'])->name('update.categories');
    Route::DELETE('/admin/destroy/categorie/{categorie}', [CategorieController::class, 'destroy'])->name('destroy.categories');



//indexDemandeAdmin
    Route::get('/admin/index/demande', [DemandeController::class, 'indexUserDemande'])->name('indexadmin.demandes');
//indexRessourceAdmin
    Route::get('/admin/index/ressource', [RessourceController::class, 'indexUserRessource'])->name('indexadmin.ressources');

});


//Comptable
Route::middleware('checkrole:Comptable')->group(function (){
    Route::get('/comptable/dashboard', [ControlDashbordController::class, 'adminDashboard'])->name('comptable.dashboard');
    //indexDemandeComptable
    Route::get('/comptable/index/demande', [DemandeController::class, 'indexUserDemande'])->name('indexcomptable.demandes');
    //indexRessourceComptale
    Route::get('/comptable/index/ressource', [RessourceController::class, 'indexUserRessource'])->name('indexcomptable.ressources');

    //changer status
    Route::PATCH('/updateMontant/{pivotId}', [RessourceController::class, 'updateMontant'])->name('updatemontant.ressources');
    //modifier montant
    Route::PATCH('/ressourcestatus/{pivotId}', [RessourceController::class, 'changeStatus'])->name('changestatus.ressources');
    //validation demande
    Route::post('/comptable/valider/demande/{demande}', [DemandeController::class, 'valider'])->name('valider.demandes');
    Route::post('/comptable/refuser/demande/{demande}', [DemandeController::class, 'refuser'])->name('refuser.demandes');


});


//Employe
Route::middleware('checkrole:Employe')->group(function (){
    Route::get('/employe/index/demande', [DemandeController::class, 'indexUserDemande'])->name('indexemploye.demandes');
    //indexRessourceEmploye
    Route::get('/employe/index/ressource', [RessourceController::class, 'indexUserRessource'])->name('indexemploye.ressources');


});


//Admin et Comptable
Route::middleware(['checkrole:Admin,Comptable'])->group(function (){
    //indexDemandes
    Route::get('/index/demande', [DemandeController::class, 'index'])->name('index.demandes');
//indexRessources
    Route::get('/index/ressource', [RessourceController::class, 'index'])->name('index.ressources');
    //caisse
    //Route::get('/comptable/create/caisse', [caisseController::class, 'create'])->name('create.caisse');
    //Route::post('/store/caisse', [caisseController::class, 'store'])->name('store.caisse');
    Route::get('/index/caisse', [caisseController::class, 'index'])->name('index.caisse');
    //Route::get('/comptable/edit/caisse/{caisse}', [caisseController::class, 'edit'])->name('edit.caisse');
    Route::put('/update/caisse/{caisse}', [caisseController::class, 'update'])->name('update.caisse');
    //Route::DELETE('/comptable/destroy/caisse/{caisse}', [CategorieController::class, 'destroy'])->name('destroy.caisse');
//factures riute
    Route::post('facture/{demande_id}', [\App\Http\Controllers\FactureController::class, 'store'])->name('facture.store');
    Route::delete('/facture/{id}', [FactureController::class, 'destroy'])->name('facture.destroy');

});



Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
