<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_beverages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkms')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('drink_type', ['espresso_based', 'manual_brew', 'non_coffee', 'signature']);
            $table->enum('temperature', ['hot', 'iced', 'blended', 'all'])->default('all');
            $table->string('size_options', 100)->nullable();
            $table->boolean('is_customizable')->default(false);
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
        Schema::dropIfExists('product_beverages');
    }
};
