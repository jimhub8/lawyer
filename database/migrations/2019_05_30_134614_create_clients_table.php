<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('firm_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('client_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('nextof_kin')->nullable();
            $table->string('address')->nullable();
            $table->string('case_nature')->nullable();
            $table->string('counsel')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
