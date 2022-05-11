<?php namespace Chkilel\Icones\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class updateBodyIconsTable extends Migration
{
    public function up()
    {
        Schema::table('chkilel_icones_icons', function (Blueprint $table) {
            // Svg body without <svg> tag
            $table->mediumText('body')->change();
        });
    }

    public function down()
    {
        Schema::table('chkilel_icones_icons', function (Blueprint $table) {
            $table->text('body')->change();
        });
    }
}
