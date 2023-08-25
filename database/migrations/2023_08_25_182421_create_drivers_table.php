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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->index('user_id'); 
            $table->bigInteger('capacity')->unsigned()->default(1073741823);
            $table->string('vehicle_model');
            $table->string('vehicle_color');
            $table->string('vehicle_plate_number');
            $table->tinyInteger('is_online')->unsigned()->default(0);
            $table->bigInteger('total_rates_count')->default(0);
            $table->bigInteger('total_stars_count')->default(0);
            $table->decimal('latitude',17,15)->nullable();
            $table->decimal('longitude',18,15)->nullable();
            $table->bigInteger('tile_index')->unsigned()->nullable();
            $table->datetime('last_location_update_date_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
