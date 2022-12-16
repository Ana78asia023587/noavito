<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewCountToCards extends Migration
{
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->integer('view_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('view_count');
        });
    }
}
