<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel OLT
        Schema::create('ftth_olts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address')->unique();
            $table->string('location')->nullable();
            $table->timestamps();
        });

        // Tabel ONT
        Schema::create('ftth_onts', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('olt_id');
            $table->foreign('olt_id')->references('id')->on('ftth_olts')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Port
        Schema::create('ftth_ports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('olt_id');
            $table->unsignedBigInteger('ont_id')->nullable();
            $table->string('port_number');
            $table->enum('type', ['OLT', 'ONT']);
            $table->foreign('olt_id')->references('id')->on('ftth_olts')->onDelete('cascade');
            $table->foreign('ont_id')->references('id')->on('ftth_onts')->onDelete('set null');
            $table->timestamps();
        });

        // Tabel Pelanggan
        Schema::create('ftth_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('ont_id');
            $table->foreign('ont_id')->references('id')->on('ftth_onts')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Log/Status Jaringan
        Schema::create('ftth_network_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('status');
            $table->text('description')->nullable();
            $table->timestamp('logged_at');
            $table->foreign('customer_id')->references('id')->on('ftth_customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ftth_network_logs');
        Schema::dropIfExists('ftth_customers');
        Schema::dropIfExists('ftth_ports');
        Schema::dropIfExists('ftth_onts');
        Schema::dropIfExists('ftth_olts');
    }
};
