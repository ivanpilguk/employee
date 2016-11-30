<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name',100);
        });

        //add foreign key to employee table
        if(Schema::hasColumn('employee','post_id'))
        {
            Schema::table('employee', function ($table) {
                $table->foreign('post_id')->references('id')->on('posts');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //delete foreign key from employee table
        if(Schema::hasColumn('employee','post_id'))
        {
            Schema::table('employee', function ($table) {
                $table->dropForeign(['post_id']);
            });
        }
        
        Schema::dropIfExists('posts');
    }
}
