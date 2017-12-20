<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DefaultImagePaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('image_path', 100)->default('no_image.jpg')->change();
        });

        Schema::table('instruments', function (Blueprint $table) {
            $table->string('image_path', 100)->default('no_image.jpg')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path', 100)->default('no_image.jpg')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('image_path', 100)->default(null)->change();
        });

        Schema::table('instruments', function (Blueprint $table) {
            $table->string('image_path', 100)->default(null)->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path', 100)->default(null)->change();
        });
    }
}
