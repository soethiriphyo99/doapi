<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('module', ['agent','shop', 'customer','driver','admin','vet']);
            $table->string('referral_code')->nullable()->unique();
            $table->string('short_link')->nullable();
            $table->string('full_name')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->bigInteger('mobile')->unsigned();
            $table->string('email')->nullable();
            $table->tinyInteger('is_email_verified')->unsigned()->default(0);
            $table->string('profile_photo_uri')->nullable();
            $table->string('identification_number')->nullable();
            $table->string('identification_photo_uri')->nullable();
            $table->date('birth_date')->nullable();
            $table->bigInteger('upline_user_id')->unsigned()->nullable();
            $table->index('upline_user_id'); 
            $table->decimal('referral_reward_for_upline', 20, 2)->unsigned()->default(0.00); 
            $table->tinyInteger('is_active')->unsigned()->nullable()->default(null)->change();
            $table->bigInteger('flags')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
