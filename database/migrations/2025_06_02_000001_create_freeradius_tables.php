<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // radcheck
        Schema::create('radcheck', function (Blueprint $table) {
            $table->id();
            $table->string('username')->index();
            $table->string('attribute', 64);
            $table->string('op', 2)->default('==');
            $table->string('value', 253);
            $table->timestamps();
        });

        // radreply
        Schema::create('radreply', function (Blueprint $table) {
            $table->id();
            $table->string('username')->index();
            $table->string('attribute', 64);
            $table->string('op', 2)->default('=');
            $table->string('value', 253);
            $table->timestamps();
        });

        // radusergroup
        Schema::create('radusergroup', function (Blueprint $table) {
            $table->id();
            $table->string('username')->index();
            $table->string('groupname');
            $table->integer('priority')->default(1);
            $table->timestamps();
        });

        // radgroupcheck
        Schema::create('radgroupcheck', function (Blueprint $table) {
            $table->id();
            $table->string('groupname')->index();
            $table->string('attribute', 64);
            $table->string('op', 2)->default('==');
            $table->string('value', 253);
            $table->timestamps();
        });

        // radgroupreply
        Schema::create('radgroupreply', function (Blueprint $table) {
            $table->id();
            $table->string('groupname')->index();
            $table->string('attribute', 64);
            $table->string('op', 2)->default('=');
            $table->string('value', 253);
            $table->timestamps();
        });

        // nas
        Schema::create('nas', function (Blueprint $table) {
            $table->id();
            $table->string('nasname')->unique(); // usually IP address
            $table->string('shortname')->nullable();
            $table->string('type')->default('other');
            $table->string('ports')->nullable();
            $table->string('secret');
            $table->string('server')->nullable();
            $table->string('community')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // radacct
        Schema::create('radacct', function (Blueprint $table) {
            $table->bigIncrements('radacctid');
            $table->string('username')->nullable()->index();
            $table->string('nasipaddress', 15)->nullable();
            $table->string('acctsessionid', 64)->nullable();
            $table->string('acctuniqueid', 32)->nullable();
            $table->string('framedipaddress', 15)->nullable();
            $table->integer('acctsessiontime')->nullable();
            $table->integer('acctauthentic')->nullable();
            $table->timestamp('acctstarttime')->nullable();
            $table->timestamp('acctstoptime')->nullable();
            $table->string('callingstationid', 50)->nullable();
            $table->string('calledstationid', 50)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->string('nasportid', 15)->nullable();
            $table->timestamps();
        });

        // radpostauth
        Schema::create('radpostauth', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->string('pass', 64)->nullable();
            $table->string('reply', 32)->nullable();
            $table->string('authdate', 32)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radpostauth');
        Schema::dropIfExists('radacct');
        Schema::dropIfExists('nas');
        Schema::dropIfExists('radgroupreply');
        Schema::dropIfExists('radgroupcheck');
        Schema::dropIfExists('radusergroup');
        Schema::dropIfExists('radreply');
        Schema::dropIfExists('radcheck');
    }
};
