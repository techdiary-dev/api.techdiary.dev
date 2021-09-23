<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table){
//            $table->string('title')->default('শিরোনামহীন ডায়েরি')->change();
//            $table->string('slug')->nullable()->change();
//            $table->text('body')->nullable()->change();
//            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table){
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('body');
            $table->timestamp('published_at')->nullable();
        });
    }
}
