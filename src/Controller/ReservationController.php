<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTO;
use App\Exception\ReservationIntrouvableException;
use App\Exception\SalleIndisponibleException;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\View\View;

final class ReservationController
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservations,
        private readonly SalleRepositoryInterface $salles,
        private readonly ReservationValidator $validator,
        private readonly CreerReservationService $creerService,
        private readonly AnnulerReservationService $annulerService,
        private readonly View $view,
    ) {
    }

    public function index(): string
    {
        $salleId = isset($_GET['salle_id']) && $_GET['salle_id'] !== '' ? (int) $_GET['salle_id'] : null;

        $reservations = $salleId !== null
            ? $this->reservations->findBySalle($salleId)
            : $this->reservations->all();

        return $this->renderPage('reservation/index', [
            'reservations' => $reservations,
            'salles' => $this->salles->all(),
            'salleId' => $salleId,
        ], 'Liste des réservations');
    }

    public function show(int $id): string
    {
        $reservation = $this->reservations->find($id);

        if ($reservation === null) {
            http_response_code(404);
            return $this->renderPage('error/404', [], 'Réservation introuvable');
        }

        return $this->renderPage('reservation/show', ['reservation' => $reservation], 'Détail de la réservation');
    }

    public function create(): string
    {
        return $this->renderPage('reservation/form', [
            'salles' => $this->salles->all(),
        ], 'Nouvelle réservation');
    }

    public function store(): string
    {
      $donnees = [
        'salle_id' => $_POST['salle_id'] ?? '',
        'responsable' => $_POST['responsable'] ?? '',
        'email' => $_POST['email'] ?? '',
        'motif' => $_POST['motif'] ?? '',
        'date_debut' => str_replace('T', ' ', $_POST['date_debut'] ?? ''),
        'date_fin' => str_replace('T', ' ', $_POST['date_fin'] ?? ''),
        ];

        $resultat = $this->validator->validate($donnees);

        if (!$resultat->isValid()) {
            return $this->renderPage('reservation/form', [
                'salles' => $this->salles->all(),
                'erreurs' => $resultat->errors(),
                'valeurs' => $donnees,
            ], 'Nouvelle réservation');
        }

        $dto = CreerReservationDTO::fromArray($resultat->data());

        try {
            $this->creerService->creer($dto);
        } catch (SalleIndisponibleException $e) {
            return $this->renderPage('reservation/form', [
                'salles' => $this->salles->all(),
                'erreurs' => ['general' => $e->getMessage()],
                'valeurs' => $donnees,
            ], 'Nouvelle réservation');
        }

        header('Location: /reservations');
        exit;
    }

    public function cancel(int $id): string
    {
        try {
            $this->annulerService->annuler($id);
        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            return $this->renderPage('error/404', [], 'Réservation introuvable');
        }

        header('Location: /reservations/' . $id);
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