<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function($table) {
            $table->string('name', 100);
            $table->string('address', 100);
            $table->integer('filled_places');
            $table->integer('all_places');
            $table->timestamp('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('image');
            $table->text('description');
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
        Schema::table('hotels', function($table) {
            $table->dropColumn('name');
            $table->dropColumn('address');
            $table->dropColumn('filled_places');
            $table->dropColumn('all_places');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('image');
            $table->dropColumn('description');
        });
    }
}
