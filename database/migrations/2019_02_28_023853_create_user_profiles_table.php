<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('gender', ['男', '女'])->nullable();
            $table->string('bod')->nullable();
            $table->integer('height')->nullable();
            $table->string('income')->nullable();
            $table->string('area')->nullable();
            $table->string('education')->nullable();
            $table->string('marriage')->nullable();
            $table->boolean('has_children')->default(0);
            $table->boolean('want_children')->default(1);
            $table->string('job')->nullable();
            $table->boolean('automobile')->default(0);
            $table->enum('house', ['租房', '已购房', '和家人同住'])->default('已购房');
            $table->integer('weight')->nullable();

            
            $table->enum('smoking', ['不吸烟', '偶尔', '只在社交场合', '吸烟'])->default('不吸烟');
            $table->enum('drinking', ['不喝酒', '稍微喝一点', '只在社交场合', '喝酒'])->default('不喝酒');
            $table->boolean('is_show')->default(1);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
