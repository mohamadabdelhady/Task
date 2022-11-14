<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('body');
            $table->string('cover_img');
            $table->boolean('pinned');
//            $table->
            $table->timestamps();
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

};
