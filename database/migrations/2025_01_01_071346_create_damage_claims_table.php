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
        Schema::create('damage_claims', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->integer('customer_user_id');
            $table->decimal('claim_amount', 10, 2);
            $table->decimal('approved_amount', 10, 2)->nullable();
            $table->text('description');
            $table->text('note')->nullable();
            $table->json('photos');
            $table->string('attachment')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\DamageClaimStatus::Pending->value);
            $table->integer('approve_reject_by')->nullable();
            $table->timestamp('approve_reject_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_claims');
    }
};
