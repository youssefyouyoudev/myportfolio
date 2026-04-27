<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crm_leads', function (Blueprint $table): void {
            $table->string('review_status')->default('approved')->after('status');
            $table->string('source_type')->nullable()->after('source');
            $table->string('external_id')->nullable()->after('source_type');
            $table->unsignedSmallInteger('online_presence_score')->nullable()->after('external_id');
            $table->json('online_presence_issues')->nullable()->after('online_presence_score');
            $table->json('social_links')->nullable()->after('online_presence_issues');
            $table->json('pitch_payload')->nullable()->after('social_links');
            $table->json('source_data')->nullable()->after('pitch_payload');
            $table->unsignedInteger('reply_count')->default(0)->after('source_data');
            $table->decimal('estimated_revenue', 12, 2)->nullable()->after('reply_count');
            $table->timestamp('found_at')->nullable()->after('estimated_revenue');

            $table->index(['source_type', 'external_id']);
            $table->index(['review_status', 'status']);
            $table->index('found_at');
        });
    }

    public function down(): void
    {
        Schema::table('crm_leads', function (Blueprint $table): void {
            $table->dropIndex(['source_type', 'external_id']);
            $table->dropIndex(['review_status', 'status']);
            $table->dropIndex(['found_at']);

            $table->dropColumn([
                'review_status',
                'source_type',
                'external_id',
                'online_presence_score',
                'online_presence_issues',
                'social_links',
                'pitch_payload',
                'source_data',
                'reply_count',
                'estimated_revenue',
                'found_at',
            ]);
        });
    }
};
