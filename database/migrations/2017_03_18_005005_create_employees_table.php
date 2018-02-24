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
            $table->string('city', 255)->nullable();
            $table->integer('state_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->char('zipcode', 10)->nullable();
            $table->tinyInteger('age');
            $table->date('birth');
            $table->date('date_hired');
            $table->integer('department_id')->unsigned();
            $table->integer('division_id')->unsigned();
            $table->string('avatar', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onUpdate('cascade')
                ->onDelete('no action');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('no action');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('no action');
            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')
                ->onDelete('no action');
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
