<?php

use App\Enums\LinkCategory;
use Heritage\Database\Migrations\Migration;
use Heritage\Database\Schema\Blueprint;
use Heritage\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->default(LinkCategory::READ->value);
            $table->foreignId('submitted_by_user_id')->constrained('users');
            $table->json('metadata')->nullable(); // scraped data, og tags, etc
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'created_at']);
            $table->index('submitted_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
