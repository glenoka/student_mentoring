<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('topics')
            ->whereNull('category')
            ->update(['category' => 'math']); // default aman

        Schema::table('topics', function (Blueprint $table) {
            // 2. Ubah category jadi NOT NULL
            $table->enum('category', ['math', 'language'])
                  ->nullable(false)
                  ->change();

            // 3. Hapus kolom type
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('topics', function (Blueprint $table) {
            // rollback type
            $table->enum('type', ['image', 'doc', 'link'])->nullable();

            // rollback category jadi nullable lagi
            $table->enum('category', ['math', 'language'])
                  ->nullable()
                  ->change();
        });
    }
};
