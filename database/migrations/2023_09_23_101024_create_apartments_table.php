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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->text('uaid')->default(null)->nullable(true);
            $table->double('s_total')->default(0)->nullable(false);
            $table->double('s_living')->default(0)->nullable(false);
            $table->double('s_kitchen')->default(0)->nullable(false);
            $table->double('height')->default(0)->nullable(false);
            $table->bigInteger('price')->default(0)->nullable(false)->index();
            $table->bigInteger('floor')->default(0)->nullable(false);
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
        Schema::dropIfExists('apartments');
    }
};
