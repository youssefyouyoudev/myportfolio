<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->string('screenshot_path')->nullable()->after('hero_image');
            $table->string('screenshot_webp_path')->nullable()->after('screenshot_path');
            $table->boolean('is_nda')->default(false)->after('is_concept');
            $table->text('context')->nullable()->after('description');
            $table->text('problem_long')->nullable()->after('context');
            $table->text('solution_long')->nullable()->after('problem_long');
            $table->text('outcome_long')->nullable()->after('solution_long');
            $table->string('result_1_label')->nullable()->after('built_at');
            $table->string('result_1_value')->nullable()->after('result_1_label');
            $table->string('result_2_label')->nullable()->after('result_1_value');
            $table->string('result_2_value')->nullable()->after('result_2_label');
            $table->string('result_3_label')->nullable()->after('result_2_value');
            $table->string('result_3_value')->nullable()->after('result_3_label');
        });

        Schema::table('testimonials', function (Blueprint $table): void {
            $table->boolean('published')->default(false)->after('is_featured');
        });

        Schema::table('client_logos', function (Blueprint $table): void {
            $table->boolean('verified')->default(false)->after('is_featured');
            $table->boolean('permission_given')->default(false)->after('verified');
        });
    }

    public function down(): void
    {
        Schema::table('client_logos', function (Blueprint $table): void {
            $table->dropColumn(['verified', 'permission_given']);
        });

        Schema::table('testimonials', function (Blueprint $table): void {
            $table->dropColumn(['published']);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn([
                'screenshot_path',
                'screenshot_webp_path',
                'is_nda',
                'context',
                'problem_long',
                'solution_long',
                'outcome_long',
                'result_1_label',
                'result_1_value',
                'result_2_label',
                'result_2_value',
                'result_3_label',
                'result_3_value',
            ]);
        });
    }
};
