<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishDateToCards extends Migration
{
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dateTime('published_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('published_date');
        });
    }
}
