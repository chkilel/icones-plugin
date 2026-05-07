<?php

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chkilel_icones_icons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();

            $table->string('icon_set_id');
            $table->string('name');
            $table->string('readable_name');
            $table->string('parent')->nullable();
            $table->string('icon_set_name');

            $table->mediumText('body');

            $table->boolean('hidden')->default(false);

            $table->integer('left');
            $table->integer('top');
            $table->integer('width');
            $table->integer('height');

            $table->integer('rotate');
            $table->boolean('hFlip');
            $table->boolean('vFlip');

            $table->integer('inlineTop');
            $table->integer('inlineHeight');
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
};
