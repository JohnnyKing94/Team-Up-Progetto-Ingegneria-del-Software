<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeammatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teammates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teammate_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->string('identifier');
            $table->timestamp('date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teammates');
    }
}