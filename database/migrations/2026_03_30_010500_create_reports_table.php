<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->foreignId('citizen_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vehicle_case_id')->nullable()->constrained('vehicle_cases')->nullOnDelete();
            $table->foreignId('submitted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('request_type')->default('vehicle_removal')->index();
            $table->string('submission_channel')->default('web')->index();
            $table->string('subject')->nullable();
            $table->text('complaint_details');
            $table->text('address_text');
            $table->string('nearest_landmark')->nullable();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete();
            $table->text('google_maps_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('vehicle_type')->nullable()->index();
            $table->string('damage_type')->nullable()->index();
            $table->string('plate_number')->nullable()->index();
            $table->string('color')->nullable();
            $table->string('make_model')->nullable();
            $table->string('public_status')->default('received')->index();
            $table->string('internal_status')->default('submitted')->index();
            $table->text('review_note')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
