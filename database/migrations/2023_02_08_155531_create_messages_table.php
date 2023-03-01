<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->date('publishDate');
            $table->text('pathMediaMessage')->nullable();
            $table->bigInteger('reponseMessage')->nullable();
            $table->boolean('view');
            $table->bigInteger('userSend');
            $table->bigInteger('userReceive');
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
