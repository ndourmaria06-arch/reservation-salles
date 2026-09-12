<?php

declare(strict_types=1);

namespace App;

use App\View\View;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;

use function FastRoute\simpleDispatcher;

final class Application
{
    public function __construct(
        private readonly ContainerInterface $container,
    ) {
    }

    public function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $dispatcher = simpleDispatcher(function (RouteCollector $r): void {
            (require __DIR__ . '/../routes/web.php')($r);
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        if ($uri === '/') {
            echo $this->renderAccueil();
            return;
        }

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo $this->renderErreur('error/404');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                header('Allow: ' . implode(', ', $allowedMethods));
                echo $this->renderErreur('error/405');
                break;

            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $vars = $routeInfo[2];

                $controller = $this->container->get($controllerClass);
                $params = array_map(
                    static fn (string $value) => is_numeric($value) ? (int) $value : $value,
                    array_values($vars)
                );

                echo $controller->{$method}(...$params);
                break;
        }
    }

    private function renderAccueil(): string
    {
        $view = $this->container->get(View::class);
        $contenu = '<h1>Bienvenue</h1><p>Gestion des réservations de salles universitaires.</p>'
            . '<p><a href="/salles" class="btn">Voir les salles</a> <a href="/reservations" class="btn">Voir les réservations</a></p>';

        return $view->render('layout/base', ['contenu' => $contenu, 'titre' => 'Accueil']);
    }

    private function renderErreur(string $template): string
    {
        $view = $this->container->get(View::class);
        $contenu = $view->render($template);

        return $view->render('layout/base', ['contenu' => $contenu, 'titre' => 'Erreur']);
    }
}