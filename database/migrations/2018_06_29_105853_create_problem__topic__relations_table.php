<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemTopicRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problem__topic__relations', function (Blueprint $table) {
            $table->integer('problem_id');
            $table->integer('topic_id');
            $table->timestamps();
            $table->primary(['problem_id','topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problem__topic__relations');
    }
}
