<?php

namespace App\Http\Controllers;

use App\Models\Caisse;
use App\Models\Demande;
use App\Models\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControlDashbordController extends Controller
{
    //

    function index(Request $request)
    {
        $role = Auth::user()->role;


        switch ($role) {
            case'Admin':
               return redirect()->route('admin.dashboard');
            case'Comptable':
                return  redirect()->route('comptable.dashboard');
            case'Employe':
               return redirect()->route('employe.dashboard');
            default:
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login');
        }

    }
    public function adminDashboard()
    {


        //tt les demandes
        $totaldemandes = Demande::count();
        // Nombre de demandes par statut
        $en_attente = Demande::where('status', 'En attente')->count();
        $validees = Demande::where('status', 'Validé')->count();
        $refusees = Demande::where('status', 'Refusé')->count();

        // Total des ressources
        $ressources = Ressource::count();
        //letotaldumontant ressources payer

        $total_depenses = DB::table('demandes_pivot_ressources')->where('status','Payer')
            ->sum('estimation_montant');


        // 5 dernières demandes (avec l'utilisateur et les ressources associées)
        $last_demandes = Demande::with('user', 'ressources')->latest()->take(5)->get()
            ->map(function ($demande){
                $colors = [
                    'En attente' => 'warning',
                    'Validé' => 'success',
                    'Refusé' => 'danger',
                ];
                $demande->status_color = $colors[$demande->status] ?? 'secondary';
                return $demande;
            }





            );

        // Caisse (s’il y en a une seule)
        $caisse = Caisse::first();
//        $nombreDemande_ressource_paye = Demande::whereHas('ressources', function ($query) {
//            $query->where('demandes_pivot_ressources.status', 'Payer');
//         })->count();


        return view('welcome.dashboard_admin', compact(
            'en_attente',
            'validees',
            'refusees',
            'ressources',
            'last_demandes',
            'caisse',
            'totaldemandes',
            'total_depenses',
        
        ));
    }

    public function employeDashboard()
    {
        $user = Auth::user();

        // Statistiques des demandes de l'employé
        $en_attente = Demande::where('user_id', $user->id)->where('status', 'En attente')->count();
        $validees   = Demande::where('user_id', $user->id)->where('status', 'Validé')->count();
        $refusees   = Demande::where('user_id', $user->id)->where('status', 'Refusé')->count();
        $ressources = Ressource::where('user_id',$user->id)->count();

        // 5 dernières demandes
        $last_demandes = Demande::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($demande) {
                $colors = [
                    'En attente' => 'warning',
                    'Validé' => 'success',
                    'Refusé' => 'danger',
                ];
                $demande->status_color = $colors[$demande->status] ?? 'secondary';
                return $demande;
            });

        return view('welcome.dashboard_employe', compact('en_attente', 'validees', 'refusees', 'last_demandes','ressources'));
    }

}
