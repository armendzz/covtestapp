<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('fn');
            $table->string('ln');
            $table->string('dob');
            $table->string('salt');
            $table->string('laborid');
            $table->string('teststelle');
            $table->string('user_id');
            $table->string('hersteller');
            $table->string('addresse');
            $table->string('kunde_id');
            $table->integer('test_nr');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('ergebnis')->nullable();
            $table->boolean('digital')->default('0');
            $table->boolean('ghaanmeldung')->default('0');
            $table->string('filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
