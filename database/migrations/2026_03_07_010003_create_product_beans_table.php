<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_beans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('bean_status', ['green_bean', 'roasted_bean', 'ground'])->index();
            $table->string('variety', 100);
            $table->string('origin', 100);
            $table->enum('process', ['natural', 'washed', 'honey', 'anaerobic', 'wet_hulled'])->nullable();
            $table->enum('roast_level', ['light', 'medium', 'medium_dark', 'dark'])->nullable();
            $table->enum('grind_size', ['whole', 'coarse', 'medium', 'fine', 'extra_fine'])->nullable();
            $table->smallInteger('weight_gram')->unsigned();
            $table->smallInteger('altitude_masl')->unsigned()->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->unsigned()->default(0);
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->index();
            $table->text('rejected_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_beans');
    }
};
