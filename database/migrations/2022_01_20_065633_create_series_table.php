<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->default(DB::raw('uuid_generate_v4()'));
            $table->string('title')->nullable();
            $table->json('contents')->nullable();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('series');
    }
}