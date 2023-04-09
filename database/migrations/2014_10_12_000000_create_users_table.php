<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->default(DB::raw('uuid_generate_v4()'));
            // $table->uuid('id')->primary()->unique()->default(DB::raw('extensions.uuid_generate_v4()'));
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique()->nullable();

            $table->string('profilePhoto')->nullable();
            $table->string('education')->nullable();
            $table->string('designation')->nullable();
            $table->string('bio')->nullable();

            $table->string('website_url')->nullable();
            $table->string('location')->nullable();
            $table->json('social_links')->nullable();

            $table->text('profile_readme')->nullable();
            $table->string('skills')->nullable();
            $table->string('password')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
