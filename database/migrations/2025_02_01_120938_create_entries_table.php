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
        Schema::create('entries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('arrangement_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUlid('invoice_id')
                ->nullable()
                ->constrained('invoices')
                ->cascadeOnDelete();
            $table->float('hours');
            $table->float('rate')->nullable();
            $table->timestamp('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
