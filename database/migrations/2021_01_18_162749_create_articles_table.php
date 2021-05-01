<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->default(DB::raw('extensions.uuid_generate_v4()'));
            // $table->uuid('id')->primary()->unique()->default(DB::raw('uuid_generate_v4()'));
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->string('seriesName')->nullable();
            $table->json('body');
            $table->string('excerpt')->nullable();
            $table->boolean('isPublished')->default(false);
            $table->boolean('isApproved')->default(false);

            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('articles');
    }
}
