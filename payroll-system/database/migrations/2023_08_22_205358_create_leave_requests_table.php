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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' );
            $table->unsignedBigInteger( 'leave_category_id' );
            $table->date( 'start_date' );
            $table->date( 'end_date' );
            $table->integer( 'number_of_days' );
            $table->text( 'reason' );
            $table->string( 'status' )->default( 'Pending' );
            $table->unsignedBigInteger( 'approved_by' )->nullable();
            $table->date( 'approved_at' )->nullable();
            $table->timestamp( 'created_at' )->useCurrent();
            $table->timestamp( 'updated_at' )->useCurrent()
                ->useCurrentOnUpdate();

            // Foreign key constraints
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreign( 'leave_category_id' )->references( 'id' )->on( 'leave_categories' )
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
        Schema::dropIfExists('leave_requests');
    }
};
