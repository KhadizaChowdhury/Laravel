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
        Schema::create( 'rsvps', function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' );
            $table->unsignedBigInteger( 'event_id' );
            $table->enum( 'status', ['attending', 'maybe', 'not_attending'] );
            $table->timestamps();

            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
            ->restrictOnDelete()
            ->cascadeOnUpdate();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
            ->restrictOnDelete()
            ->cascadeOnUpdate();
            $table->foreign( 'event_id' )->references( 'id' )->on( 'events' )
            ->restrictOnDelete()
            ->cascadeOnUpdate();

            $table->unique( ['user_id', 'event_id'] ); // Ensure a user can only RSVP once for an event
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};
