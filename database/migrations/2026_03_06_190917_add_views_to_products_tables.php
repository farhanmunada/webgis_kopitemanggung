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
        Schema::table('product_beverages', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });

        Schema::table('product_roasteries', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });

        Schema::table('product_beans', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_beverages', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('product_roasteries', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('product_beans', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
