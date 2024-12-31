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
        Schema::create('towing_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate');
            $table->decimal('rate_a');
            $table->decimal('rate_b');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('location_id');
            $table->tinyInteger('status')->nullable()->default(\App\Enums\VisibilityStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('towing_rates');
    }
};
