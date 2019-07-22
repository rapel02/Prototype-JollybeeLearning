<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialProblemRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material__problem__relations', function (Blueprint $table) {
            $table->integer('material_id');
            $table->integer('problem_id');
            $table->timestamps();
            $table->primary(['material_id','problem_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material__problem__relations');
    }
}
