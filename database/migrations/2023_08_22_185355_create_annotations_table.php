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
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->integer("annotation_page_id");
            $table->string("item_id");
            $table->string("creator_id");
            $table->string("creator_name");
            $table->string("creator_type")->default("person");
            $table->string("motivation")->default("commenting");
            $table->string("type")->default("Annotation");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annotations');
    }
};
