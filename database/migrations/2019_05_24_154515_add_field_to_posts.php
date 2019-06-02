<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('nickname');
            $table->string('bod')->nullable();
            $table->string('location')->default('');
            $table->string('marriage');
            $table->string('hobby')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('nickname');
            $table->dropColumn('bod');
            $table->dropColumn('location');
            $table->dropColumn('marriage');
            $table->dropColumn('hobby');
        });
    }
}
