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
        Schema::create('buyer_numbers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sheet_id');
            $table->string('buyer_id');
            $table->string('username', 50);
            $table->string('password', 50)->nullable();
            $table->string('auction_name', 150)->nullable();
            $table->string('account_name', 150)->nullable();
            $table->integer('account_type')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('company_name', 150)->nullable();
            $table->integer('grade_id')->nullable();
            $table->text('note')->nullable();
            $table->text('attachments')->nullable();
            $table->tinyInteger('status')->default(\App\Enums\VisibilityStatus::ACTIVE);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyer_numbers');
    }
};
