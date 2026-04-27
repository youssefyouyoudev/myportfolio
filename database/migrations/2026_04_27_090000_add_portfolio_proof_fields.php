<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table): void {
            $table->string('client_name')->nullable()->after('live_url');
            $table->string('client_industry')->nullable()->after('client_name');
            $table->string('result_headline')->nullable()->after('client_industry');
            $table->boolean('is_concept')->default(false)->after('result_headline');
            $table->date('built_at')->nullable()->after('is_concept');
            $table->string('metric_one_label')->nullable()->after('built_at');
            $table->string('metric_one_value')->nullable()->after('metric_one_label');
            $table->string('metric_two_label')->nullable()->after('metric_one_value');
            $table->string('metric_two_value')->nullable()->after('metric_two_label');
            $table->string('metric_three_label')->nullable()->after('metric_two_value');
            $table->string('metric_three_value')->nullable()->after('metric_three_label');
        });

        Schema::table('testimonials', function (Blueprint $table): void {
            $table->string('client_name')->nullable()->after('id');
            $table->string('client_title')->nullable()->after('client_name');
            $table->string('client_company')->nullable()->after('client_title');
            $table->string('avatar_path')->nullable()->after('quote');
            $table->boolean('is_featured')->default(false)->after('avatar_path');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table): void {
            $table->dropColumn([
                'client_name',
                'client_title',
                'client_company',
                'avatar_path',
                'is_featured',
            ]);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn([
                'client_name',
                'client_industry',
                'result_headline',
                'is_concept',
                'built_at',
                'metric_one_label',
                'metric_one_value',
                'metric_two_label',
                'metric_two_value',
                'metric_three_label',
                'metric_three_value',
            ]);
        });
    }
};
