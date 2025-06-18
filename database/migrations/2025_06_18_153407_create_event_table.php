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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();

            
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();

            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();

            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');


            $table->enum('status', ['published', 'cancelled', 'postponed'])->default('published');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['admin', 'user'])->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};
