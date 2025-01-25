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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->integer('version_number')->default(0);
            $table->integer('customer_user_id');
            $table->integer('assigned_to')->nullable();
            $table->integer('container_id')->nullable();
            $table->integer('lot_number');
            $table->string('vin_number', 25);
            $table->string('year', 5);
            $table->string('make', 150);
            $table->string('model', 150);
            $table->string('color', 50);
            $table->decimal('value', 10)->nullable()->default(0);
            $table->string('service_provider', 100)->nullable();
            $table->string('auction_name', 100)->nullable();
            $table->string('weight', 50)->nullable();
            $table->string('license_number', 30)->nullable();
            $table->string('check_number', 30)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('handed_over_date')->nullable();
            $table->smallInteger('towed_from')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->decimal('title_amount')->nullable()->default(0);
            $table->decimal('storage_amount')->nullable()->default(0);
            $table->decimal('additional_charges')->nullable()->default(0);
            $table->text('note')->nullable();
            $table->tinyInteger('note_status')->default(0);

            // Towing Request
            $table->tinyInteger('condition')->nullable();
            $table->tinyInteger('damaged')->nullable();
            $table->tinyInteger('pictures')->nullable();
            $table->tinyInteger('towed')->nullable();
            $table->tinyInteger('keys')->nullable();
            $table->tinyInteger('title_received')->nullable();
            $table->date('title_received_date')->nullable();
            $table->string('title_number', 50)->nullable();
            $table->string('title_state', 50)->nullable();
            $table->date('towing_request_date')->nullable();
            $table->date('pickup_date')->nullable();
            $table->date('deliver_date')->nullable();
            $table->tinyInteger('tow_by')->nullable();
            $table->decimal('tow_fee')->nullable();
            $table->integer('title_type_id')->nullable();

            $table->unsignedTinyInteger('status')->nullable()->default(6);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
