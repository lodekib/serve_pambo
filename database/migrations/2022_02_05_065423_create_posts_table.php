<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_number');
            $table->string('category');
            $table->string('title');
            $table->string('county');
            $table->string('sub_county');
            $table->string('location');
            $table->string('price_from');
            $table->string('price_to');
            $table->string('email');
            $table->string('phone');
            $table->text('description');
            $table->string('sponsorship');
            $table->timestamps();

            $table->index('id_number');
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
    }
}
