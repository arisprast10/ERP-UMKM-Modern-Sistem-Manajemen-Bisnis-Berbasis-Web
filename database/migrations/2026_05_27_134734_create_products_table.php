<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->decimal('buy_price', 15, 2);
            $table->decimal('sell_price', 15, 2);
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('products');
    }
};