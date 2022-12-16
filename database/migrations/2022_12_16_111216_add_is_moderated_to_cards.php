<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsModeratedToCards extends Migration
{
    public function up()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->boolean('is_moderated')->default(0);
        });
    }

    public function down()
    {
        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn('is_moderated');
        });
    }
}
