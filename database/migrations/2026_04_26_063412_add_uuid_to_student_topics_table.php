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
       Schema::table('student_topics', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id')->unique();
        });

        // isi data lama
        DB::table('student_topics')->whereNull('uuid')->get()->each(function ($item) {
            DB::table('student_topics')
                ->where('id', $item->id)
                ->update([
                    'uuid' => Str::uuid(),
                ]);
        });

        Schema::table('student_topics', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_topics', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
