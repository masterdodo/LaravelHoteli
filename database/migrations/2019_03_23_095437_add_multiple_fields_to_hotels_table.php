<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMultipleFieldsToHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->integer('free_wifi');
            $table->integer('airport_shuttle');
            $table->integer('non_smoking_rooms');
            $table->integer('lift');
            $table->integer('air_conditioning');
            $table->integer('parking');
            $table->integer('family_rooms');
            $table->integer('fitness_centre');
            $table->integer('spa_and_wellness_centre');
            $table->integer('swimming_pool');
            $table->integer('bar');
            $table->integer('outdoor_pool');
            $table->integer('room_service');
            $table->integer('heating');
            $table->integer('terrace');
            $table->integer('garden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('free_wifi');
            $table->dropColumn('airport_shuttle');
            $table->dropColumn('non_smoking_rooms');
            $table->dropColumn('lift');
            $table->dropColumn('air_conditioning');
            $table->dropColumn('parking');
            $table->dropColumn('family_rooms');
            $table->dropColumn('fitness_centre');
            $table->dropColumn('spa_and_wellness_centre');
            $table->dropColumn('swimming_pool');
            $table->dropColumn('bar');
            $table->dropColumn('outdoor_pool');
            $table->dropColumn('room_service');
            $table->dropColumn('heating');
            $table->dropColumn('terrace');
            $table->dropColumn('garden');
        });
    }
}
