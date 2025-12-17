<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('code')->nullable();
            $table->string('logo')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->string('id', 3)->primary(); // IATA-like
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('type')->nullable(); // domestic/international
            $table->string('country', 2)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('governorates', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('capital_ar')->nullable();
            $table->string('capital_en')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('governorates');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('airlines');
    }
};
