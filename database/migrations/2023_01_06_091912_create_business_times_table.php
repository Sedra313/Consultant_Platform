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
        Schema::create('business_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('expert_id')->unsigned()->nullable() ;
            $table->json('days');
            $table->time('mon_s')->nullable()->default(NULL);
            $table->time('mon_e')->nullable()->default(NULL);
            $table->time('tue_s')->nullable()->default(NULL);
            $table->time('tue_e')->nullable()->default(NULL);
            $table->time('wed_s')->nullable()->default(NULL);
            $table->time('wed_e')->nullable()->default(NULL);
            $table->time('thu_s')->nullable()->default(NULL);
            $table->time('thu_e')->nullable()->default(NULL);
            $table->time('fri_s')->nullable()->default(NULL);
            $table->time('fri_e')->nullable()->default(NULL);
            $table->time('sat_s')->nullable()->default(NULL);
            $table->time('sat_e')->nullable()->default(NULL);
            $table->time('sun_s')->nullable()->default(NULL);
            $table->time('sun_e')->nullable()->default(NULL);
            $table->timestamps();

            $table->unsignedInteger('step')->default(60);
            

             $table->foreign('expert_id')
            ->references('id')
            ->on('experts')
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
        Schema::dropIfExists('business_times');
    }
};
