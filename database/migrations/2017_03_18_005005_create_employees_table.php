<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 60);
            $table->string('middlename', 60)->nullable();
            $table->string('lastname', 60);
            $table->string('address', 255);
            $table->integer('city_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->char('zip', 10)->nullable();
            $table->tinyInteger('age');
            $table->date('birth');
            $table->date('date_hired');
            $table->integer('department_id')->unsigned();
            $table->integer('division_id')->unsigned();
            $table->string('avatar', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')
                ->references('id')
                ->on('city');
            $table->foreign('state_id')
                ->references('id')
                ->on('state');
            $table->foreign('country_id')
                ->references('id')
                ->on('country');
            $table->foreign('department_id')
                ->references('id')
                ->on('department');
            $table->foreign('division_id')
                ->references('id')
                ->on('division');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
