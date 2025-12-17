<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline_code', 10);
            $table->string('from_city_id', 3);
            $table->string('to_city_id', 3);
            $table->timestamp('depart_at');
            $table->timestamp('arrive_at')->nullable();
            $table->string('cabin_class')->default('economy');
            $table->decimal('base_price', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('seats')->nullable();
            $table->string('status')->default('scheduled');
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['from_city_id','to_city_id','depart_at']);
        });

        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->string('type')->default('flight');
            $table->foreignId('flight_id')->nullable()->constrained('flights')->nullOnDelete();
            $table->json('passengers');
            $table->string('status')->default('created');
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['status','payment_status']);
        });

        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('priority')->default(100);
            $table->json('conditions');
            $table->json('actions');
            $table->boolean('enabled')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->string('type'); // credit/debit
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->string('reference')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('pricing_rules');
        Schema::dropIfExists('travel_requests');
        Schema::dropIfExists('flights');
    }
};
