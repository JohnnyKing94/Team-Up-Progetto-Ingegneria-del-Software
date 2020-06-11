<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->timestamp('date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}