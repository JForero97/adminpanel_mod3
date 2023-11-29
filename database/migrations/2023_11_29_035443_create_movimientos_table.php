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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id('movimiento_id'); // Cambié 'id' por 'movimiento_id'
            $table->foreignId('id')->constrained('users'); // Cambié 'usuario_id' por 'id' y referencié la tabla 'users'
            $table->decimal('cantidad', 10, 2);
            $table->enum('tipo_movimiento', ['cargar','retirar','transferir','transferencia_recibida']);
            $table->timestamp('fecha')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
