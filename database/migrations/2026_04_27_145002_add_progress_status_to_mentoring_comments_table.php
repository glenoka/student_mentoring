<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('mentoring_comments', function (Blueprint $table) {
            $table->enum('progress_status', [
                'pending_support', //Perlu Pendampingan  
                'developing', //Sedang Berkembang
                'reinforcement', //Perlu Penguatan
                'progressing', //Menunjukkan Perkembangan
                'good', //Memahami dengan Baik
                'excellent', //Sangat Baik
            ])->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('mentoring_comments', function (Blueprint $table) {
            $table->dropColumn('progress_status');
        });
    }
};

