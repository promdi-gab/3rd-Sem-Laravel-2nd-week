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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id'); //increments instead of normal id kasi pwede mo palitan yung id like customer_id pag increments
            $table->text(column: 'title');
            $table->text(column: 'lname'); //Column: for professionality This is optional prefer ko ilagay mo pa ren
            $table->text(column: 'fname');
            $table->text(column: 'address');
            $table->text(column: 'town');
            $table->text(column: 'zipcode');
            $table->text(column: 'phone');
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
        Schema::dropIfExists('customers');
    }
};
