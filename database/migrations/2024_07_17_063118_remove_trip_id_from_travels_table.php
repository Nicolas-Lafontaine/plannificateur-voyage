<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTripIdFromTravelsTable extends Migration
{
    public function up()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->dropColumn('trip_id');
        });
    }

    public function down()
    {
        Schema::table('travels', function (Blueprint $table) {
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
        });
    }
}
