<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_series', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignUuid('series_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('article_id')->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('series_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_series');
    }
}
