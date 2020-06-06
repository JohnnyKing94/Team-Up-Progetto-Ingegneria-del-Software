<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teammate_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->string('identifier');
            $table->timestamp('join_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
}