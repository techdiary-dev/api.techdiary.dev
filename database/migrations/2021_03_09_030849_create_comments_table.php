<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->default(DB::raw('uuid_generate_v4()'));
            $table->uuidMorphs('commentable');
            $table->text('body');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('parent_id')->nullable()
                ->on('comments')
                ->onDelete('cascade');
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
        Schema::dropIfExists('comments');
    }
}
