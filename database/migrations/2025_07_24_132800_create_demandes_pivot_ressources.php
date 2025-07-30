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
        Schema::create('demandes_pivot_ressources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');
            $table->unsignedBigInteger('ressource_id');
            $table->foreign('ressource_id')
                ->references('id')
                ->on('ressources')
                ->onDelete('cascade');
            $table->enum('status',['A payer','Payer','Ne sera pas payé','En stock'])->default('A payer');
            $table->decimal('estimation_montant',10,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_pivot_ressources');
    }
};
