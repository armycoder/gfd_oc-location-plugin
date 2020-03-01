<?php

namespace Gigafeed\Locations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::table('offline_openinghours_locations', function ($table) {
            $table->string('phone')->nullable();
            $table->string('addr1')->nullable();
            $table->string('addr2')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2);
            $table->integer('zipcode', 6);
        });
    }
}