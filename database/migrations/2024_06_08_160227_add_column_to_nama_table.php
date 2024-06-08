<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->integer("bayar2")->nullable();
            $table->enum("model_bayar2",['cod','tf'])->nullable();
            // $table->string("bukti_bayar")->nullable();
            $table->string("bukti_bayar2")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['bayar2', 'model_bayar2', 'bukti_bayar2']);
        });
    }
};
