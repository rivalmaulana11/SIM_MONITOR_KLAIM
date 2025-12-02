<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('eklaim_bpjs', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('id');
            $table->index('file_name');
        });
    }

    public function down()
    {
        Schema::table('eklaim_bpjs', function (Blueprint $table) {
            $table->dropIndex(['file_name']);
            $table->dropColumn('file_name');
        });
    }
};
