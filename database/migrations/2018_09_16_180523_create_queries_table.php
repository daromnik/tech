<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('group_id')->unsigned();
            $table->boolean('active')->default(1);
            $table->string('url', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('h1', 255)->nullable();
            $table->decimal('cost', 255)->default(0);
            $table->float('value_query', 255)->default(0);

            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queries');
    }
}
