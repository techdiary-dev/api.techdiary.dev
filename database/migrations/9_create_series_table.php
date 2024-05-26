<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->string('cover')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
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
        Schema::dropIfExists('series');
        Schema::dropIfExists('article_series');
    }
};
