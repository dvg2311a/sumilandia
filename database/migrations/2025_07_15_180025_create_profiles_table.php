<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->nullable();
            $table->string('nickname')->nullable()->unique();
            $table->date('birthdate')->nullable();
            $table->enum('academic_level', ['primary', 'secondary'])->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();

            // Foreign key to users table
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
