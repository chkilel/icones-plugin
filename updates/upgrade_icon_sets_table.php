<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

return new class extends Migration
{
    public function up()
    {
        DB::table('chkilel_icones_icon_sets')->where('palette', 'Colorless')->update(['palette' => false]);
        DB::table('chkilel_icones_icon_sets')->where('palette', 'Colorful')->update(['palette' => true]);

        Schema::table('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->boolean('palette')->change();
        });
    }

    public function down()
    {
        Schema::table('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->string('palette')->change();
        });

        DB::table('chkilel_icones_icon_sets')->where('palette', '0')->update(['palette' => 'Colorless']);
        DB::table('chkilel_icones_icon_sets')->where('palette', '1')->update(['palette' => 'Colorful']);
    }
};
