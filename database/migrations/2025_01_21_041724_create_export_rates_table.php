<?php

use App\Enums\VisibilityStatus;
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
        Schema::create('export_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate');
            $table->decimal('rate_a');
            $table->decimal('rate_b');
            $table->integer('from_country_id');
            $table->integer('to_country_id');
            $table->tinyInteger('status')->nullable()->default(VisibilityStatus::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_rates');
    }
};
