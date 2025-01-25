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
        Schema::create('dock_receipts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('container_id');
            $table->string('awb_number', 50)->nullable();
            $table->string('export_reference', 200)->nullable();
            $table->text('forwarding_agent')->nullable();
            $table->text('domestic_routing_instructions')->nullable();
            $table->string('pre_carriage_by')->nullable();
            $table->string('place_of_receipt_by_pre_carrier', 50)->nullable();
            $table->string('exporting_carrier')->nullable();
            $table->string('final_destination')->nullable();
            $table->string('loading_terminal')->nullable();
            $table->string('dock_container_type')->nullable();
            $table->string('number_of_packages')->nullable();
            $table->string('by')->nullable();
            $table->date('date')->nullable();
            $table->date('auto_receiving_date')->nullable();
            $table->date('auto_cut_off')->nullable();
            $table->date('vessel_cut_off')->nullable();
            $table->date('sale_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dock_receipts');
    }
};
