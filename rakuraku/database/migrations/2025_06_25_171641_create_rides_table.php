<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id('ride_id');
            $table->foreignId('rider_id')->constrained('users', 'user_id');
            $table->foreignId('driver_id')->constrained('users', 'user_id');
            $table->foreignId('vehicle_id')->constrained('vehicles', 'vehicle_id');
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->float('pickup_lat');
            $table->float('pickup_lng');
            $table->float('dropoff_lat');
            $table->float('dropoff_lng');
            $table->float('distance');
            $table->decimal('price', 10, 2);
            $table->enum('status', [
                'requested', 'accepted', 'arrived',
                'in_progress', 'completed', 'cancelled'
            ]);
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rides');
    }
};
