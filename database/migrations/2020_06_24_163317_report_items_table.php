<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reportID');
            $table->foreign('reportID')->references('id')->on('reports');
            $table->unsignedBigInteger('itemID');
            $table->foreign('itemID')->references('id')->on('items');
            $table->integer('quantity');
            $table->integer('portions');
            $table->decimal('price', 10, 2);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('report_items');
    }
}
