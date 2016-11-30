<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('surname',100)->index();
            $table->string('middlename',100);
            $table->date('work_from')->index();
            $table->decimal('salary', 8, 2)->index();
            $table->integer('post_id')->unsigned()->nullable()->index();
            $table->integer('boss_id')->unsigned()->nullable()->index();
            $table->foreign('boss_id')->references('id')->on('employee');
            $table->timestamps();
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
        Schema::dropIfExists('employee');
    }
}
