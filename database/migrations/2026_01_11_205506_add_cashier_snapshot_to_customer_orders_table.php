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
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->string('cashier_name')->nullable()->after('cashier_id');
            $table->string('cashier_email')->nullable()->after('cashier_name');
            $table->string('cashier_phone')->nullable()->after('cashier_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn(['cashier_name', 'cashier_email', 'cashier_phone']);
        });
    }
};
