<?php

namespace Database\Seeders;

use App\Models\Caisse;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaisseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $caisse = Caisse::create([
            'montant_init' => 0,
            'user_id' => 1
        ]);


        Transaction::create([
            'user_id' => 1,
            'caisse_id' => $caisse->id,
            'montant_transaction' => $caisse->montant_init,
            'type' => 'Entree',
            'motif' => 'Initialisation de la caisse',
        ]);
    }

}
