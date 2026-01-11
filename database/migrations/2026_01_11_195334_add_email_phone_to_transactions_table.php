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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('user_email')->nullable()->after('user_name');
            $table->string('user_phone')->nullable()->after('user_email');
            $table->string('cashier_email')->nullable()->after('cashier_name');
            $table->string('cashier_phone')->nullable()->after('cashier_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['user_email', 'user_phone', 'cashier_email', 'cashier_phone']);
        });
    }
};
