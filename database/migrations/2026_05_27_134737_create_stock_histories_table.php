<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->enum('type', ['in', 'out', 'adjustment']);
            $table->integer('qty');
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->text('notes')->nullable();
            $table->string('reference_type')->nullable(); // e.g. transaction, purchase
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('stock_histories');
    }
};