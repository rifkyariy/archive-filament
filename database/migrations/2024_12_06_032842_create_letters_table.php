<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('letter_code')->unique(); // Letter code, must be unique
            $table->date('letter_date'); // Date of the letter
            $table->string('letter_source_instance'); // Source instance of the letter
            $table->text('letter_description'); // Description of the letter
            $table->date('letter_forward_date')->nullable(); // Forward date, optional
            $table->string('letter_recipient'); // Recipient of the letter
            $table->string('letter_file_pdf')->nullable(); // PDF file path, optional
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters'); // Drop the table if exists
    }
};
