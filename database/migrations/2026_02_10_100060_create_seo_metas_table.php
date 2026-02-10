<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table): void {
            $table->id();
            $table->morphs('seoable');
            $table->string('meta_title');
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('locale', 5)->default('en');
            $table->string('og_type')->nullable();
            $table->json('schema')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
