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
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->date('date_of_birth');
            $table->string('ktp')->unique();
            $table->string('phone')->unique();
            $table->text('profile_picture')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password');
            $table->enum('role', ['Admin', 'User'])->default('User');
            $table->enum('status', ['0', '1'])->default('1');
            $table->rememberToken();
            $table->timestamps();
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
