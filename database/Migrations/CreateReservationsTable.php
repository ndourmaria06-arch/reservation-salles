<?php

declare(strict_types=1);

namespace Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

final class CreateReservationsTable
{
    public function up(Builder $schema): void
    {
        $schema->create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salle_id')->constrained('salles')->cascadeOnDelete();
            $table->string('responsable', 120);
            $table->string('email', 180);
            $table->string('motif', 255);
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->enum('statut', ['confirmée', 'annulée'])->default('confirmée');
            $table->timestamps();

            $table->index(['salle_id', 'date_debut', 'date_fin']);
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('reservations');
    }
}