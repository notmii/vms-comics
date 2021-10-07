<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Authors extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->unique();
            $table->timestamp('thumbnail_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('authors');
    }
}
