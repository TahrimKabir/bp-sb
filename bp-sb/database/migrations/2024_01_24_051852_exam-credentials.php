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
        Schema::create('exam_credentials', function (Blueprint $table) {
            $table->id();
            $table->integer('mcstatus_id');
            $table->string('pin_number');
            $table->dateTime('start');
            $table->boolean('is_finished')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
