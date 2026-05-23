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
       Schema::table('learning_materials', function (Blueprint $table) {

            // DESCRIPTION
            $table->text('description')
                ->nullable()
                ->after('title');

            // THUMBNAIL
            $table->string('thumbnail')
                ->nullable()
                ->after('description');

            // UPLOAD BY (TEACHER)
            $table->foreignId('teacher_id')
                ->nullable()
                ->after('thumbnail')
                ->constrained('teachers')
                ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_materials', function (Blueprint $table) {

            $table->dropForeign(['teacher_id']);

            $table->dropColumn([
                'description',
                'thumbnail',
                'teacher_id',
            ]);

        });
    }
};
