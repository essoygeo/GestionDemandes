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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->foreign('demande_id')
                ->references('id')
                ->on('demandes')
                ->onDelete('cascade');

            $table->string('filesize');

            $table->string('path_image');
            $table->date('date');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
