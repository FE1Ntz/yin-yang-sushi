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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phoneNumber');
            $table->enum('status', ['Отримано', 'Готується', 'Доставляється', 'Виконано', 'Скасовано'])->default('Отримано');
            $table->enum('delivery_way', ['В закладі', 'Доставка', 'Самовивіз'])->default('Доставка');
            $table->enum('payment_method', ['Готівка', 'Кредитна карта'])->default('Кредитна карта');
            $table->decimal('price');
            $table->integer('table_id')->nullable();
            $table->dateTime('starDelivery')->nullable();
            $table->dateTime('finishDelivery')->nullable();
            $table->string('address')->nullable();
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
