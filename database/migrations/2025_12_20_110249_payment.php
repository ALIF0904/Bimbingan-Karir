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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->string('nama');           // BCA, DANA, OVO
    $table->string('tipe');           // bank, ewallet, qris
    $table->string('nomor')->nullable(); // No rek / no wallet
    $table->string('atas_nama')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
        });
    }

};