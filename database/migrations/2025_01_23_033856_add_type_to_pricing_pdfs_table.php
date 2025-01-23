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
        Schema::table('pricing_pdfs', function (Blueprint $table) {
            if (! Schema::hasColumn('pricing_pdfs', 'type')) {
                $table->tinyInteger('type')->after('expire_at')->default(\App\Enums\PricingType::IMPORT->value);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_pdfs', function (Blueprint $table) {
            if (Schema::hasColumn('pricing_pdfs', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
