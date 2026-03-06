<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_roasteries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('service_type', ['jasa_roasting', 'biji_sangrai', 'kopi_bubuk'])->index();
            $table->string('variety', 100)->nullable();
            $table->string('origin', 100)->nullable();
            $table->enum('process', ['natural', 'washed', 'honey', 'anaerobic', 'wet_hulled'])->nullable();
            $table->enum('roast_level', ['light', 'medium', 'medium_dark', 'dark'])->nullable();
            $table->smallInteger('weight_gram')->unsigned()->nullable();
            $table->enum('grind_size', ['whole', 'coarse', 'medium', 'fine', 'extra_fine'])->nullable();
            $table->decimal('min_order_kg', 8, 2)->nullable();
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
        Schema::dropIfExists('product_roasteries');
    }
};
