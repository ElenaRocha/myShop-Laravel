<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_supplier', function (Blueprint $table) {
            $table->foreignUuid('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('supplier_id')->constrained()->cascadeOnDelete();
            $table->unique(['brand_id', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_supplier');
    }
};
