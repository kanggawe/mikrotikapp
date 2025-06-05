<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_nas', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->unsignedBigInteger('nas_id')->nullable();
            $table->foreign('nas_id')->references('id')->on('nas')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user_nas');
    }
};
