<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 30);
            $table->boolean('active')->default(1);
            $table->boolean('is_www')->default(0);
            $table->boolean('is_https')->default(0);
            $table->boolean('out_total_visibility')->default(0);
            $table->integer('report_day')->unsigned();
            $table->integer('level')->default(0);

            $table->integer('manager_id')->unsigned();
            $table->integer('optimizer_id')->unsigned();
            $table->integer('client_id')->unsigned();

            $table->string('ga_acount', 20)->nullable();
            $table->string('ga_count_number', 20)->nullable();
            $table->string('ga_profile_id', 20)->nullable();
            $table->string('bitrix24_project_id', 20)->nullable();
            $table->string('link_bitrix24', 150)->nullable();
            $table->string('link_y_webmaster', 150)->nullable();
            $table->string('link_g_search_cosole', 150)->nullable();
            $table->string('link_ga', 150)->nullable();
            $table->string('logo', 30)->nullable();

            $table->float('monthly_payment')->default(0);

            $table->integer('tic')->default(0);
            $table->integer('sqi')->default(0);

            $table->timestamps();

            $table->unique('domain');

            $table->foreign('manager_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('optimizer_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
