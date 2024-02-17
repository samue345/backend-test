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
        Schema::create('query_params_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('redirectlog_id');
            $table->string('params');
            $table->foreign('redirectlog_id')->references('id')->on('redirect_logs')->onDelete('cascade');
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
        Schema::dropIfExists('query_params_requests');
    }
};
