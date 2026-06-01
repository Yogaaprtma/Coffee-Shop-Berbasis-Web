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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('order_type', ['dine_in', 'takeaway'])->default('dine_in')->after('status');
            $table->string('table_number')->nullable()->after('order_type');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes')->nullOnDelete()->after('table_number');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('promo_code_id');
            $table->decimal('total_amount', 15, 2)->default(0)->after('discount_amount');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->json('options')->nullable()->after('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropColumn(['order_type', 'table_number', 'promo_code_id', 'discount_amount', 'total_amount']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('options');
        });
    }
};
