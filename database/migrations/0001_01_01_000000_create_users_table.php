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
        // Créer la table 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Colonne ID
            $table->string('name'); // Colonne pour le nom de l'utilisateur
            $table->string('email')->unique(); // Colonne pour l'email unique
            $table->string('role')->default("Users"); // Colonne pour l'email unique
            $table->timestamp('email_verified_at')->nullable(); // Colonne pour la vérification de l'email
            $table->string('password'); // Colonne pour le mot de passe
            $table->rememberToken(); // Colonne pour le token de "se souvenir de moi"
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        });

        // Créer la table 'password_reset_tokens'
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Colonne email comme clé primaire
            $table->string('token'); // Colonne pour le token de réinitialisation
            $table->timestamp('created_at')->nullable(); // Colonne pour la date de création du token
        });

        // Créer la table 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Colonne ID pour la session
            $table->foreignId('user_id')->nullable()->index(); // Colonne pour l'ID de l'utilisateur
            $table->string('ip_address', 45)->nullable(); // Colonne pour l'adresse IP
            $table->text('user_agent')->nullable(); // Colonne pour l'agent utilisateur (navigateur)
            $table->longText('payload'); // Colonne pour les données de la session
            $table->integer('last_activity')->index(); // Colonne pour l'activité de la session
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer les tables si nécessaire
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
