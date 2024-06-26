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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique()->length(11);
            $table->text('image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('user_status')->default(2)->comment('1=active, 2=inactive');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('cascade');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('cascade');
            $table->foreignId('upazilas_id')->nullable()->constrained('upazilas')->onDelete('cascade');
            $table->foreignId('union_id')->nullable()->constrained('unions')->onDelete('cascade');
            $table->string('zip_code')->nullable();
            $table->string('street_address')->nullable();
            $table->foreignId('created_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->foreignId('updated_by')->nullable()
                ->constrained('users', 'id')
                ->onDelete('set null');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};