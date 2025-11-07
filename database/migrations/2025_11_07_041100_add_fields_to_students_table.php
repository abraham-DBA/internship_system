<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_email')->nullable()->after('student_contact');
            $table->string('status')->default('pending')->after('notes');
            $table->string('supervisor_name')->nullable()->after('status');
            $table->string('supervisor_email')->nullable()->after('supervisor_name');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_email', 'status', 'supervisor_name', 'supervisor_email']);
        });
    }
};
