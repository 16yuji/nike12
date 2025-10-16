<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
      $table->string('code')->unique();
      $table->unsignedInteger('subtotal');
      $table->unsignedInteger('discount')->default(0);
      $table->unsignedInteger('shipping_fee')->default(0);
      $table->unsignedInteger('total');
      $table->string('status')->default('pending');
      $table->string('payment_method')->nullable();
      $table->string('shipping_name');
      $table->string('shipping_phone');
      $table->string('shipping_address');
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('orders'); }
};
