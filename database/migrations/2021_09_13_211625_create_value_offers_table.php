<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValueOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('value')->nullable();
            $table->string('will_get')->nullable();
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
        Schema::dropIfExists('value_offers');
    }
}
