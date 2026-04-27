<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('leads') || ! Schema::hasTable('contact_messages')) {
            return;
        }

        $legacyLeads = DB::table('leads')->get();

        foreach ($legacyLeads as $lead) {
            $exists = DB::table('contact_messages')
                ->where('email', $lead->email)
                ->where('message', $lead->message)
                ->where('created_at', $lead->created_at)
                ->exists();

            if ($exists) {
                continue;
            }

            $meta = json_decode((string) $lead->meta, true) ?: [];

            DB::table('contact_messages')->insert([
                'name' => $lead->name,
                'email' => $lead->email,
                'company' => $lead->company,
                'project_type' => $meta['project_type'] ?? null,
                'budget' => $lead->budget,
                'timeline' => $meta['timeline'] ?? null,
                'message' => $lead->message,
                'locale' => $lead->locale ?? 'en',
                'source' => $lead->source ?? 'website',
                'ip_address' => $meta['ip'] ?? null,
                'user_agent' => $meta['user_agent'] ?? null,
                'path' => $meta['path'] ?? null,
                'read_at' => null,
                'created_at' => $lead->created_at,
                'updated_at' => $lead->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        // Preserve imported contact history on rollback.
    }
};
