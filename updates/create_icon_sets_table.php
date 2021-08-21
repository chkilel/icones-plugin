<?php namespace Chkilel\Icones\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateIconSetsTable extends Migration
{
    public function up()
    {
        Schema::create('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            // Prefix for the icon set used as Id
            $table->string('id');

            // Icon set's name. This field is always set.
            $table->string('name');

            // The total number of icons, optional.
            $table->integer('total')->nullable();

            // Author name. This field is always set.
            $table->string('author');

            // Link to icon set, optional. Usually links to GitHub repository.
            $table->string('url')->nullable();

            // License title. This field is always set.
            $table->string('license');

            // Link to the license, optional.
            $table->string('license_url')->nullable();

            // The current version, optional.
            $table->string('version')->nullable();

            // Value is an array of icon names that should be used
            // as samples when showing the icon set in an icon sets list.
            $table->text('samples')->nullable();

            // Colorless or Colorful
            $table->string('palette')->nullable();

            // Category of the icon set
            $table->string('category')->nullable();

            // Is the icon set enabled in the backend or not
            $table->boolean('is_enabled')->default(false);

            // Is the icon set seeded to the database
            $table->boolean('is_installed')->default(false);

            // Value is a number or array of numbers,
            // values are pixel grids used in the icon set.
            // If any icons in an icon set do not match the grid, this attribute should not be set.
            $table->string('height')->default(16);

            // The height value that should be used for displaying samples.
            // Value is a number between 16 and 30 (inclusive).
            $table->integer('display_height')->default(24);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->primary(['id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chkilel_icones_icon_sets');
    }
}
