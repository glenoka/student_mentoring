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
       Schema::table('mentoring_sessions', function (Blueprint $table) {
    $table->dropForeign(['teacher_id']);
    $table->renameColumn('teacher_id', 'user_id');
});

Schema::table('mentoring_sessions', function (Blueprint $table) {
    $table->foreign('user_id')
        ->references('id')
        ->on('users')
        ->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_id_on_mentoring_sessions', function (Blueprint $table) {
            //
        });
    }
};
