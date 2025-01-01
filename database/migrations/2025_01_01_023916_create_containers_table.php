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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_user_id');
            $table->string('booking_number', 50);
            $table->string('container_number', 50)->nullable();
            $table->string('seal_number', 30)->nullable();
            $table->string('vessel', 50)->nullable();
            $table->string('voyage', 50)->nullable();
            $table->string('streamship_line', 150)->nullable();
            $table->string('xtn_number', 30)->nullable();
            $table->string('itn', 30)->nullable();
            $table->string('broker_name', 100)->nullable();
            $table->string('oti_number', 30)->nullable();
            $table->string('terminal', 50)->nullable();
            $table->string('destination', 80)->nullable();
            $table->string('ar_number', 30)->nullable();
            $table->date('loading_date')->nullable();
            $table->date('cut_off_date')->nullable();
            $table->date('export_date')->nullable();
            $table->date('eta_date')->nullable();
            $table->text('contact_detail')->nullable();
            $table->integer('port_of_loading_id');
            $table->integer('port_of_discharge_id');
            $table->unsignedTinyInteger('container_type')->nullable();
            $table->text('container_vehicles')->nullable();
            $table->unsignedTinyInteger('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
