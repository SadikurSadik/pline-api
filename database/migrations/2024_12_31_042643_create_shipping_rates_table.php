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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->decimal('amount_40feet');
            $table->decimal('amount_45feet');
            $table->integer('from_country_id');
            $table->integer('from_state_id');
            $table->integer('from_port_id');
            $table->integer('to_country_id');
            $table->integer('to_state_id');
            $table->integer('to_port_id');
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
        Schema::dropIfExists('shipping_rates');
    }
};
