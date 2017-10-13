<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpqjTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->date('registered_date')->nullable();
            $table->string('name',63);
            $table->string('slug',63);
            $table->string('image')->nullable();
            $table->string('gender',15);
            $table->string('address')->nullable();
            $table->string('phone',15)->nullable();
            $table->date('stop_date')->nullable();

            $table->timestamps();
        });        

        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',63);
            $table->string('slug',63);
            $table->date('established_date')->nullable();
            $table->integer('headmaster')->unsigned(); //persons_id
            $table->string('address')->nullable();

            $table->foreign('headmaster')->references('id')->on('persons')
                  ->onUpdate('restrict')->onDelete('restrict');
        });

        Schema::create('institution_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('section',['main','extra']);
            $table->integer('institution_id')->unsigned();
            $table->integer('person_id')->unsigned();

            $table->foreign('institution_id')->references('id')->on('institutions')
                  ->onUpdate('restrict')->onDelete('restrict');

            $table->foreign('person_id')->references('id')->on('persons')
                  ->onUpdate('restrict')->onDelete('restrict');                              
        });     

        Schema::create('class_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 15);
            $table->string('slug', 15);
            $table->string('description')->nullable();            
        });        

        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->date('registered_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place',63)->nullable();
            $table->string('registration_number',15)->nullable();
            $table->integer('institution_id')->unsigned(); 
            $table->string('fullname',63);
            $table->string('slug',63);
            $table->string('nickname',31);
            $table->string('gender',15);
            $table->string('parent',63)->nullable();
            $table->string('address')->nullable();
            $table->string('phone',31)->nullable();
            $table->string('job',63)->nullable();
            $table->decimal('tuition', 6,0)->nullable();
            $table->decimal('infrastructure_fee',7,0)->nullable();
            $table->integer('group_id')->unsigned();
            $table->string('image')->nullable();
            $table->tinyInteger('status',1)->default(1);
            $table->date('stop_date')->nullable();
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institutions')
                  ->onUpdate('restrict')->onDelete('restrict'); 

            $table->foreign('group_id')->references('id')->on('class_groups')
                  ->onUpdate('restrict')->onDelete('restrict'); 


        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('class_groups');
        Schema::dropIfExists('institution_teachers');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('persons');
    }
}