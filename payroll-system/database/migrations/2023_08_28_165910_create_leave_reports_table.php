<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' ); // The employee the report is about
            $table->unsignedBigInteger( 'approved_by' )->nullable(); // The manager who approved the report (if applicable)
            $table->integer( 'total_leaves_taken' )->default( 0 ); // The total number of leaves taken during the period
            $table->integer( 'vacation_leaves_taken' )->default( 0 ); // Total vacation leaves taken
            $table->integer( 'unpaid_leaves_taken' )->default( 0 ); // Total unpaid leaves taken
            $table->integer( 'sick_leaves_taken' )->default( 0 ); // Total sick leaves taken
            // ... any other types of leaves
            $table->text( 'comments' )->nullable(); // Any comments or notes regarding the report
            $table->timestamp( 'created_at' )->useCurrent();
            $table->timestamp( 'updated_at' )->useCurrent()
                ->useCurrentOnUpdate();

            // Foreign key constraints
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign( 'approved_by' )->references( 'id' )->on( 'users' )->onDelete( 'set null' );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_reports');
    }
};
