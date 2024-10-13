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
    Schema::create('diamond_purchases', function (Blueprint $table) {
        $table->id();
        $table->string('field1');
        $table->string('field2');
        $table->integer('total_diamonds');
        $table->decimal('total_price', 8, 2);
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
        Schema::dropIfExists('diamond_purchases');
    }
};
