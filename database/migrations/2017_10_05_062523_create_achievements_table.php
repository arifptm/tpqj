<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->date('achievement_date');
            $table->integer('student_id')->unsigned();
            $table->integer('stage_id')->unsigned();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->reference('id')->on('students')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('stage_id')->reference('id')->on('stages')
                ->onDelete('restrict')->onUpdate('cascade');                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
