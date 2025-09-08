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
        Schema::create('struk_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoice')->onDelete('cascade');
            $table->dateTime('tanggal_cetak');
            $table->text('konten_struk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struk_pembayaran');
    }
};
