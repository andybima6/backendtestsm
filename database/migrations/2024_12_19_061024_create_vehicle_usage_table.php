<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vehicle_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver')->constrained('reservations')->onDelete('cascade');

            $table->decimal('distance_travelled', 10, 2);
            $table->decimal('fuel_used', 10, 2);
            $table->date('usage_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('vehicle_usages');
    }
};
