<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->references('id')->on('offers')->cascadeOnDelete();
            $table->string('ip');
            $table->integer('status')->default(0);
            $table->string('reference_code');
            $table->string('phone')->nullable();
            $table->foreignId('value_offer_id')->nullable()->references('id')->on('value_offers')->cascadeOnDelete();
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
        Schema::dropIfExists('participants');
    }
}
