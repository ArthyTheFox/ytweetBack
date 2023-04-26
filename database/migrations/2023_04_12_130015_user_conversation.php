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
        Schema::create('userconversations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_User');
            $table->bigInteger('id_conversation');
            $table->timestamps();
            
        });    
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userconversations');
    }
};
