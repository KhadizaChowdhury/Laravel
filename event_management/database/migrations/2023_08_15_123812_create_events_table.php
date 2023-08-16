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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' ); // For relation with users
            $table->string( 'title' );
            $table->text( 'description' );
            $table->date( 'date' );
            $table->time( 'time' );
            $table->string( 'location' );
            $table->timestamp( 'created_at' )->useCurrent();
            $table->timestamp( 'updated_at' )->useCurrent()
                ->useCurrentOnUpdate();

            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
            ->restrictOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
