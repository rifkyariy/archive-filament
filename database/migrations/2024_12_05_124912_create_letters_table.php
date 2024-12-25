<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->string('letter_code')->unique();
            $table->date('letter_date');
            $table->string('letter_source_instance');
            $table->text('letter_description');
            $table->date('letter_forward_date')->nullable();
            $table->string('letter_recipient');
            $table->string('letter_file_pdf');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};