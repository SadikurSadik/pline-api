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
        Schema::create('vccs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id');
            $table->bigInteger('container_id');
            $table->integer('shipping_invoice_id')->nullable();
            $table->string('declaration_number')->nullable();
            $table->date('declaration_date')->nullable();
            $table->date('received_date')->nullable();
            $table->decimal('custom_duty', 11)->nullable()->default(0);
            $table->date('expire_date')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(0);
            $table->double('deposit_amount', 11)->nullable();
            $table->string('handed_over_to')->nullable();
            $table->unsignedTinyInteger('vehicle_registration_type')->nullable();
            $table->integer('issued_by')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->integer('handed_over_by')->nullable();
            $table->timestamp('handed_over_at')->nullable();
            $table->string('container_bg_color', 20)->nullable();
            $table->string('vcc_attachment', 200)->nullable();
            $table->string('bill_of_entry_attachment', 200)->nullable();
            $table->string('other_attachment', 200)->nullable();
            $table->text('vcc_exit_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vccs');
    }
};
