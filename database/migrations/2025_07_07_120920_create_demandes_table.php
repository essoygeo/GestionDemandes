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
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->unsignedBigInteger('validateur_id')->nullable();
            $table->foreign('validateur_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->string('titre');
            $table->text('raison');
            $table->decimal('estimation_montant',10,2)->nullable();
            $table->decimal('montant_valide',10,2)->nullable();
            $table->enum('type',['Achat','En stock']);
            $table->enum('status',['En attente','Refusé','Validé'])->default('En attente');


            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
