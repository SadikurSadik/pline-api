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
        Schema::create('vcc_exit_papers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vcc_id');
            $table->dateTime('received_date')->nullable();
            $table->decimal('refund_amount', 11)->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(\App\Enums\VccStatus::EXIT_PAPER_RECEIVED);
            $table->date('submission_date')->nullable();
            $table->decimal('custom_duty_amount', 11)->nullable();
            $table->decimal('receivable_claim_amount', 11)->nullable();
            $table->decimal('amount_received_in_bank', 11)->nullable();
            $table->date('date_amount_received_in_bank')->nullable();
            $table->string('received_from')->nullable();
            $table->integer('received_by')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->integer('submitted_by')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vcc_exit_papers');
    }
};
