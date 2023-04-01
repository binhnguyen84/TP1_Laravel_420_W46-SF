<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->char('title',255);
            $table->year('release_year')->nullable();
            $table->unsignedSmallInteger('length')->nullable();
            $table->text('description')->nullable();
            $table->char('rating', 5);
            $table->unsignedBigInteger('language_id');
            $table->char('special_features', 200);
            $table->char('image', 40);
            $table->timestamps();
            
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
