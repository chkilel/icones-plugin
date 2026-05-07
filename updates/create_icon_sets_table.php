<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chkilel_icones_icon_sets', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('name');
            $table->integer('total')->nullable();
            $table->string('author');
            $table->string('url')->nullable();
            $table->string('license');
            $table->string('license_url')->nullable();
            $table->string('version')->nullable();
            $table->text('samples')->nullable();
            $table->string('palette')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_installed')->default(false);
            $table->string('height')->default(16);
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
};
