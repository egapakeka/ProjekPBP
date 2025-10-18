<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'discount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('discount', 12, 2)->default(0);
            });
        }

        if (! Schema::hasColumn('orders', 'final_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('final_amount', 12, 2)->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'discount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('discount');
            });
        }

        if (Schema::hasColumn('orders', 'final_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('final_amount');
            });
        }
    }
};
