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
        Schema::create('experts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');            
            $table->string('name');
            $table->string('email')->unique();
           $table->bigInteger('category_id')->unsigned()->nullable() ;// here is the probleme ;)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->Integer('rating');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experts');
    }
};
