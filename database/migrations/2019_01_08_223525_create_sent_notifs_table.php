<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentNotifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_notifs', function (Blueprint $table) {
            $table->increments('snotif_id');
            $table->integer( "appointment_id" )->references( "appointments" )->on( "appointment_id" );
            $table->integer( "user_id" )->references( "users" )->on( "user_id" );
            $table->date( "for_date" );
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
        Schema::dropIfExists('sent_notifs');
    }
}
