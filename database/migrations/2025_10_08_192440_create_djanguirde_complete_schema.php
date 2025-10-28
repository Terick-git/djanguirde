<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table users (base Laravel + nos colonnes)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('student');
                $table->string('avatar')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Table categories
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('color')->default('#2E5FE0');
                $table->timestamps();
            });
        }

        // Table courses
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->string('short_description');
                $table->string('thumbnail')->nullable();
                $table->decimal('price', 8, 2)->default(0);
                $table->enum('level', ['beginner', 'intermediate', 'advanced', 'collège', 'lycée'])->default('beginner');
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
                $table->foreignId('instructor_id')->constrained('users');
                $table->foreignId('category_id')->constrained();
                $table->timestamps();
            });
        }

        // Table lessons (avec video_type inclus)
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content');
                $table->string('video_url')->nullable();
                $table->string('video_type')->nullable(); // ← INCLUSE DIRECTEMENT
                $table->integer('duration')->default(0);
                $table->integer('order')->default(0);
                $table->boolean('is_free')->default(false);
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Table enrollments
        if (!Schema::hasTable('enrollments')) {
            Schema::create('enrollments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->foreignId('course_id')->constrained();
                $table->integer('progress')->default(0);
                $table->json('completed_lessons')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                $table->unique(['user_id', 'course_id']);
            });
        }

        // Tables système Laravel
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        if (!Schema::hasTable('cache')) {
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->integer('expiration');
            });
        }

        if (!Schema::hasTable('cache_locks')) {
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration');
            });
        }

        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
        }

        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('users');
    }
};