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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->double('prix_ht');
            $table->double('tva');
            $table->string('photo')->nullable();
            $table->string('stock');
            $table->bigInteger('codebarre');
            $table->foreignId('famille_id')->constrained('familles')->onDelete('cascade');
            $table->foreignId('marque_id')->constrained('marques')->onDelete('cascade');
            $table->foreignId('unite_id')->constrained('unites')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
