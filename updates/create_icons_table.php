<?php namespace Chkilel\Icones\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIconsTable extends Migration
{
    /**
     *   IconesJSON object might include any of the optional properties,
     *   They are used as default values for icons that do not have those properties.
     *
     *   Properties for viewBox:
     *       - left, number. Left position of viewBox. Default value is 0.
     *       - top, number. Top position of viewBox. Default value is 0.
     *       - width, number. Width of viewBox. Default value is 16.
     *       - height, number. Height of viewBox. Default value is 16.
     *
     *   Transformations:
     *       - rotate, number. Number of 90 degrees rotations. Default value is 0.
     *       - hFlip, boolean. Horizontal flip. Default value is false.
     *       - vFlip, boolean. Vertical flip. Default value is false.
     *
     *   Hidden icons:
     *      - If hidden  set to true, icon is hidden. That means icon was removed from collection for some reason,
     *        but it is kept in JSON file to prevent applications that rely on old icon from breaking
     **/

    public function up()
    {
        Schema::create('chkilel_icones_icons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            // Icon set Prefix
            $table->string('icon_set_id');

            //Icon name, dashed name
            $table->string('name');

            //Icon name, Readable name
            $table->string('readable_name');

            // Parent name if is Alias
            $table->string('parent')->nullable();

            // Icon set readable name
            $table->string('icon_set_name');

            // Svg body without <svg> tag
            $table->text('body');

            // If icon is hidden. That means icon was removed from collection for some reason,
            // but it is kept in JSON file to prevent applications that rely on old icon from breaking
            $table->boolean('hidden')->default(false);

            //  Properties for viewBox:
            $table->integer('left'); // Relevant to Alias
            $table->integer('top'); // Relevant to Alias

            // width and height are dimensions of icon. Value can be string (such as "1em", "24px" or a number).
            //  - If only one dimension is set, another dimension will be set using icon's width/height ratio.
            //  - If value is "auto", icon's original dimensions will be used.
            //  - If both width and height are not set, height defaults to "1em".
            $table->integer('width');
            $table->integer('height');

            //   Transformations
            $table->integer('rotate');
            $table->boolean('hFlip');
            $table->boolean('vFlip');

            $table->integer('inlineTop');
            $table->integer('inlineHeight');

            // Inline icons are aligned slightly below baseline,
            // so they look centred compared to text, like glyph fonts.
            $table->float('verticalAlign', 8, 4);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chkilel_icones_icons');
    }
}
