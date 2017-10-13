<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlmarufTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almaruf_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('transaction_date');
            $table->integer('transaction_type_id')->unsigned();
            $table->date('tuition_month')->nullable();
            $table->integer('class_group_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->decimal('amount',9,0);
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->foreign('student_id')->references('id')->on('students')
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
        Schema::dropIfExists('transactions');
    }
}
