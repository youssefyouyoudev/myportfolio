<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->boolean('featured')->default(false)->after('status');
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->boolean('featured')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn('featured');
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn('featured');
        });
    }
};
