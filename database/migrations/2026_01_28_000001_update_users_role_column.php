<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration updates the role column to include 'staff' role
     * which is needed for store staff members.
     */
    public function up(): void
    {
        // For MySQL, we need to modify the enum to include 'staff'
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'store_owner', 'customer', 'staff') DEFAULT 'customer'");
        } else {
            // For SQLite and PostgreSQL, we need a different approach
            // SQLite doesn't support enum, so this should work with string type
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('customer')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'store_owner', 'customer') DEFAULT 'customer'");
        }
    }
};
