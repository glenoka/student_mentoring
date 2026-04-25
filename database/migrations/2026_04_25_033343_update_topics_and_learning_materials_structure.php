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
         Schema::table('topics', function (Blueprint $table) {
            $table->enum('type', ['image', 'doc', 'link'])
                ->nullable()
                ->after('description');

            $table->text('url')
                ->nullable()
                ->after('type');
        });

        Schema::table('learning_materials', function (Blueprint $table) {
            if (Schema::hasColumn('learning_materials', 'topic_id')) {
                $table->dropForeign(['topic_id']);
                $table->dropColumn('topic_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn(['type', 'url']);
        });

        Schema::table('learning_materials', function (Blueprint $table) {
            $table->foreignId('topic_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }
};
