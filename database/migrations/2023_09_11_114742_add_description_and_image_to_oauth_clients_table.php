<?php

declare(strict_types=1);

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
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->json('name_translated')->after('name')->nullable();
            $table->json('brand')->after('name_translated')->nullable();
            $table->json('description')->after('brand')->nullable();
            $table->string('link')->after('description')->nullable();
            $table->string('image')->after('link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('name_translated');
            $table->dropColumn('brand');
            $table->dropColumn('description');
            $table->dropColumn('link');
            $table->dropColumn('image');
        });
    }
};
