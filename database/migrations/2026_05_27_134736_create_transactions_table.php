<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // cashier
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->string('payment_method'); // cash, transfer
            $table->decimal('paid_amount', 15, 2);
            $table->decimal('change_amount', 15, 2)->default(0);
            $table->string('status')->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};