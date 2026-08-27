<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Close the Supabase data API over this schema (SRS 8.2, 12.2).
 *
 * Supabase grants every privilege on new tables in `public` to the `anon` and
 * `authenticated` roles so that its auto-generated PostgREST API works. This
 * application does not use that API — Laravel connects directly as `postgres` —
 * so those grants only serve to expose participant contact details, password
 * hashes and session records to anyone holding the project's anon key, which is
 * published in client-side code by design.
 *
 * Two independent layers are applied:
 *
 *  1. The grants are revoked, and default privileges changed so future tables
 *     are not granted either.
 *  2. Row level security is enabled with no policies, which denies every row to
 *     any role that does not bypass RLS. `postgres` and `service_role` do
 *     bypass it, so the application and Supabase tooling are unaffected.
 *
 * Layer 2 alone would be enough, but a policy added later for one table should
 * not silently re-expose the rest, and layer 1 alone would be undone by anyone
 * re-running Supabase's default grants.
 */
return new class extends Migration
{
    /**
     * @var list<string>
     */
    private array $tables = [
        'users',
        'password_reset_tokens',
        'sessions',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
        'failed_jobs',
        'registrations',
        'team_members',
        'competition_information',
        'smart_city_content',
        'faqs',
        'migrations',
    ];

    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('REVOKE ALL ON ALL TABLES IN SCHEMA public FROM anon, authenticated');
        DB::statement('REVOKE ALL ON ALL SEQUENCES IN SCHEMA public FROM anon, authenticated');
        DB::statement('REVOKE USAGE ON SCHEMA public FROM anon, authenticated');

        // Anything created later starts closed as well.
        DB::statement('ALTER DEFAULT PRIVILEGES IN SCHEMA public REVOKE ALL ON TABLES FROM anon, authenticated');
        DB::statement('ALTER DEFAULT PRIVILEGES IN SCHEMA public REVOKE ALL ON SEQUENCES FROM anon, authenticated');

        foreach ($this->tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("ALTER TABLE public.{$table} ENABLE ROW LEVEL SECURITY");
            }
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        foreach ($this->tables as $table) {
            if (Schema::hasTable($table)) {
                DB::statement("ALTER TABLE public.{$table} DISABLE ROW LEVEL SECURITY");
            }
        }

        // Restores Supabase's stock posture. Only reverse this if you actually
        // intend the data API to reach these tables again.
        DB::statement('GRANT USAGE ON SCHEMA public TO anon, authenticated');
        DB::statement('GRANT ALL ON ALL TABLES IN SCHEMA public TO anon, authenticated');
        DB::statement('GRANT ALL ON ALL SEQUENCES IN SCHEMA public TO anon, authenticated');
        DB::statement('ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON TABLES TO anon, authenticated');
        DB::statement('ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT ALL ON SEQUENCES TO anon, authenticated');
    }
};
