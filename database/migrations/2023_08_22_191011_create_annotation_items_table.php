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
        Schema::create('annotation_items', function (Blueprint $table) {
            $table->id();
            $table->integer("annotation_id");
            $table->string("body_type");
            $table->text("body_value");
            $table->string("item_id");
            $table->string("motivation");
            $table->string("type");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annotation_items');
    }
};
