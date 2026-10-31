
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
        Schema::create('legacy_quotes', function (Blueprint $table) {
            $table->id();

            // Quote information
            $table->text('content');

            // Original speaker, separate from the user who added it
            $table->string('speaker');
            $table->text('speaker_bio')->nullable();

            // Quote category
            $table->string('category')->default('عام')->index();

            // Featured quote
            $table->boolean('is_featured')->default(false)->index();

            // Admin or Owner who added the quote
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legacy_quotes');
    }
};
