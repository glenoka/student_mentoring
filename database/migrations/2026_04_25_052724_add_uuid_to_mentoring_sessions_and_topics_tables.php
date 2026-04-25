<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mentoring_sessions_and_topics_tables', function (Blueprint $table) {
           Schema::table('mentoring_sessions', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        // isi data lama mentoring_sessions
        DB::table('mentoring_sessions')->whereNull('uuid')->get()->each(function ($row) {
            DB::table('mentoring_sessions')
                ->where('id', $row->id)
                ->update(['uuid' => Str::uuid()]);
        });

        // isi data lama topics
        DB::table('topics')->whereNull('uuid')->get()->each(function ($row) {
            DB::table('topics')
                ->where('id', $row->id)
                ->update(['uuid' => Str::uuid()]);
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mentoring_sessions_and_topics_tables', function (Blueprint $table) {
           Schema::table('mentoring_sessions', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
        });
    }
};
