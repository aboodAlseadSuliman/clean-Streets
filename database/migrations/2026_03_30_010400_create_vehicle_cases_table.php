<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->unsignedBigInteger('source_report_id')->nullable()->index();
            $table->foreignId('owning_agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete();
            $table->text('location_text');
            $table->string('nearest_landmark')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('vehicle_type')->default('unknown')->index();
            $table->string('damage_type')->default('unknown')->index();
            $table->string('plate_number')->nullable()->index();
            $table->string('color')->nullable();
            $table->string('make_model')->nullable();
            $table->string('priority')->default('medium')->index();
            $table->string('current_status')->default('new')->index();
            $table->unsignedInteger('reports_count')->default(0);
            $table->timestamp('first_reported_at')->nullable();
            $table->timestamp('last_reported_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('removed_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_cases');
    }
};
