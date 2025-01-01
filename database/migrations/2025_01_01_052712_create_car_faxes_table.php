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
        Schema::create('car_faxes', function (Blueprint $table) {
            $table->id();
            $table->integer('carfax_subscription_id')->nullable();
            $table->integer('requested_by')->nullable();
            $table->string('vin', 50);
            $table->unsignedInteger('lot_number');
            $table->integer('year')->nullable();
            $table->string('make', 150)->nullable();
            $table->string('model', 150)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('status')->nullable()->default(1);
            $table->string('document_url', 500)->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_faxes');
    }
};
