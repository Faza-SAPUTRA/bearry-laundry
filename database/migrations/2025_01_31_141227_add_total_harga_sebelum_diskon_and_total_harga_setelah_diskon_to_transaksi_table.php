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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->decimal('total_harga_setelah_diskon', 15, 0)->after('total_harga_sebelum_diskon');
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('total_harga_sebelum_diskon');
            $table->dropColumn('total_harga_setelah_diskon');
        });
    }
};
