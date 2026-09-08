<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;
use App\View\View;

final class SalleController
{
    public function __construct(
        private readonly SalleRepositoryInterface $salles,
        private readonly SalleValidator $validator,
        private readonly View $view,
    ) {
    }

    public function index(): string
    {
        $salles = $this->salles->all();

        return $this->renderPage('salle/index', ['salles' => $salles], 'Liste des salles');
    }

    public function show(int $id): string
    {
        $salle = $this->salles->find($id);

        if ($salle === null) {
            http_response_code(404);
            return $this->renderPage('error/404', [], 'Salle introuvable');
        }

        return $this->renderPage('salle/show', ['salle' => $salle], $salle->nom);
    }

    public function create(): string
    {
        return $this->renderPage('salle/form', [], 'Ajouter une salle');
    }

    public function store(): string
    {
        $donnees = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => $_POST['capacite'] ?? '',
            'type' => $_POST['type'] ?? '',
            'active' => isset($_POST['active']),
        ];

        $resultat = $this->validator->validate($donnees);

        if (!$resultat->isValid()) {
            return $this->renderPage('salle/form', [
                'erreurs' => $resultat->errors(),
                'valeurs' => $donnees,
            ], 'Ajouter une salle');
        }

        $salle = new Salle($resultat->data());
        $this->salles->save($salle);

        header('Location: /salles');
        exit;
    }

    public function edit(int $id): string
    {
        $salle = $this->salles->find($id);

        if ($salle === null) {
            http_response_code(404);
            return $this->renderPage('error/404', [], 'Salle introuvable');
        }

        return $this->renderPage('salle/form', ['salle' => $salle], 'Modifier la salle');
    }

    public function update(int $id): string
    {
        $salle = $this->salles->find($id);

        if ($salle === null) {
            http_response_code(404);
            return $this->renderPage('error/404', [], 'Salle introuvable');
        }

        $donnees = [
            'nom' => $_POST['nom'] ?? '',
            'batiment' => $_POST['batiment'] ?? '',
            'capacite' => $_POST['capacite'] ?? '',
            'type' => $_POST['type'] ?? '',
            'active' => isset($_POST['active']),
        ];

        $resultat = $this->validator->validate($donnees);

        if (!$resultat->isValid()) {
            return $this->renderPage('salle/form', [
                'salle' => $salle,
                'erreurs' => $resultat->errors(),
                'valeurs' => $donnees,
            ], 'Modifier la salle');
        }

        $salle->fill($resultat->data());
        $this->salles->save($salle);

        header('Location: /salles/' . $salle->id);
        exit;
    }

    private function renderPage(string $template, array $data, string $titre, ?string $messageSucces = null): string
    {
        $contenu = $this->view->render($template, $data);

        return $this->view->render('layout/base', [
            'contenu' => $contenu,
            'titre' => $titre,
            'messageSucces' => $messageSucces,
        ]);
    }
}