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
        Schema::create('jobpostings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('experience');
            $table->string('salary');
            $table->string('location');
            $table->string('extra_info')->nullable();
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Assuming you have a users table and foreign key for the creator
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobpostings');
    }
};
