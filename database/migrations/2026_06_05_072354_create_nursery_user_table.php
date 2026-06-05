<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nursery_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursery_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role');
            $table->timestamps();

            $table->unique(['nursery_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nursery_user');
    }
};