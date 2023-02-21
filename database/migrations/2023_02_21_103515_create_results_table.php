<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id')->nullable();   
            $table->foreign('course_id','course_id_foreign')->references('id')->on('courses')->onDelete('set null');     
            $table->unsignedBigInteger('user_id')->nullable();   
            $table->foreign('user_id','user_id_foreign')->references('id')->on('users')->onDelete('set null');     
            $table->string('score', 20)->nullable();   
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign('course_id_foreign');
            $table->dropForeign('user_id_foreign');            
        });
        Schema::dropIfExists('results');
    }
};
