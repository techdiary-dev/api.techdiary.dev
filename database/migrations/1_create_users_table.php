<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->string('username')->nullable();
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






            // -------------- Fortify --------------
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                    ->after('two_factor_recovery_codes')
                    ->nullable();
            }
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
};
