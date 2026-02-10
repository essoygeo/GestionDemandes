<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');



            $table->unsignedBigInteger('demande_id')->nullable();
            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');

            $table->enum('type',['Entree','Sortie']);
            $table->decimal('montant_transaction',10,2);
            $table->string('motif');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
