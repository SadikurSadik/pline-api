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
        Schema::create('container_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Container::class);
            $table->string('name', 200);
            $table->string('thumbnail', 200);
            $table->tinyInteger('type')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_photos');
    }
};
