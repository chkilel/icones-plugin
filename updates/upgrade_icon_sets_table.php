<?php

namespace Chkilel\Icones\Updates;

use Schema;
use Illuminate\Support\Facades\DB;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpgradeIconSetsTable extends Migration
{
    public function up()
    {
        //move the value to the new datatype
        //Colourful => 1, Colorless => 0
        DB::table('chkilel_icones_icon_sets')->where('palette', 'Colorless')->update(['palette' => false]);
        DB::table('chkilel_icones_icon_sets')->where('palette', 'Colorful')->update(['palette' => true]);

        // Change the datatype of the column
        Schema::table('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->boolean('palette')->change();
        });

    }

    public function down()
    {
        Schema::table('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->string('palette')->change();
        });
        //Roll back the value to the old datatype
        // 1 => Colourful , 0 => Colorless
        DB::table('chkilel_icones_icon_sets')->where('palette', '0')->update(['palette' => 'Colorless']);
        DB::table('chkilel_icones_icon_sets')->where('palette', '1')->update(['palette' => 'Colorful']);
    }
}
