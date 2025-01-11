<?php

use App\Models\User;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->foreignIdFor(User::class);
            $table->string('name', 200);
            $table->string('company_name', 200)->nullable();
            $table->string('phone', 20);
            $table->string('phone_two', 20)->nullable();
            $table->string('trn', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('buyer_ids')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('category')->nullable()->default('A');
            $table->text('documents')->nullable();
            $table->tinyInteger('block_issue_vcc')->nullable()->default(2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
