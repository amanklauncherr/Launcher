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
        // Drop the 'sub-heading' column
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('sub-heading');
        });

        // Recreate the 'sub-heading' column as TEXT
        Schema::table('sections', function (Blueprint $table) {
            $table->text('sub-heading')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'sub-heading' column
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('sub-heading');
        });

        // Recreate it as varchar(255) (the original type)
        Schema::table('sections', function (Blueprint $table) {
            $table->string('sub-heading', 255)->nullable();
        });
    }
};
