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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->integer('nidn');
            $table->string('nama', 50);
            $table->string('jenisKelamin', 12);
            $table->string('email', 50);
            $table->string('noHp', 15);
            $table->string('foto', 20);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 50);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
