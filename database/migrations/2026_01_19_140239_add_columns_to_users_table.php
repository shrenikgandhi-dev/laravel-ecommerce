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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->after('uname');
            $table->string('additional_email')->default('[]')->after('email');
            $table->string('additional_phone')->default('[]')->after('phone');
            $table->string('address_line1')->nullable()->after('photo_id');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('country')->nullable()->after('address_line2');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
            $table->string('zip')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'additional_email', 'additional_phone', 'address_line1', 'address_line2', 'country', 'state', 'city', 'zip']);
        });
    }
};
