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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->year('end_year')->nullable();
            $table->decimal('citylng', 12, 9)->nullable();
            $table->decimal('citylat', 12, 9)->nullable();
            //$table->string('citylng')->nullable();
            //$table->string('citylat')->nullable();
            $table->integer('intensity')->nullable();
            $table->string('sector')->nullable();
            $table->string('topic')->nullable();
            $table->text('insight')->nullable();
            $table->text('swot')->nullable();
            $table->text('url')->nullable();
            $table->string('region')->nullable();
            $table->year('start_year')->nullable();
            $table->integer('impact')->nullable();
            $table->timestamp('added')->nullable();
            $table->timestamp('published')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->integer('relevance')->nullable();
            $table->text('pestle')->nullable();
            $table->string('source')->nullable();
            $table->text('title')->nullable();
            $table->integer('likelihood')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
