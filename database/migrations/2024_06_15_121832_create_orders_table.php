<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key with cascading delete
            $table->string('user_ip')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key with cascading delete
            $table->integer('quantity');
            $table->enum('status', ['paid', 'waiting', 'delivered'])->default('waiting'); // Enum for status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
