<?php
declare(strict_types=1);

namespace App;

use App\Middlewares\AuthMiddleware;   // ex. middleware par défaut
use App\Middlewares\CsrfMiddleware;
use Closure;

/**
 *  ------------------------------------------------------------------
 *  Router : enregistre des routes et les distribue vers
 *  un contrôleur ou un callback.
 *  ↑ Inspiré de FastRoute, mais tout en interne et “mínimal”.
 *  ------------------------------------------------------------------
 *
 *  Exemple d’enregistrement (dans public/index.php ou config/routes.php) :
 *
 *      $router = new \App\Router();
 *
 *      $router->get('/',    [HomeController::class, 'index']);
 *      $router->post('/login', [AuthController::class, 'login'],
 *                   middlewares: [CsrfMiddleware::class]);
 *
 *      $router->get('/ride/{id}', [RideController::class, 'show']);
 *
 *      $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
 */
class Router
{
    /**  @var array<int,array{method:string,regex:string,vars:array<int,string>,handler:callable|array,mws:array}> */
    private array $routes = [];

    /*──────────────────────── Ajout de routes ────────────────────────*/

    public function get(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->add('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->add('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->add('PUT', $path, $handler, $middlewares);
    }

    public function delete(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->add('DELETE', $path, $handler, $middlewares);
    }

    private function add(string $method,
                         string $path,
                         callable|array $handler,
                         array $middlewares): void
    {
        [$regex, $vars] = $this->compile($path);
        $this->routes[] = [
            'method' => $method,
            'regex'  => $regex,
            'vars'   => $vars,
            'handler'=> $handler,
            'mws'    => $middlewares,
        ];
    }

    /*──────────────────────── Dispatch ──────────────────────────────*/

    public function dispatch(string $uri, string $method): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $path, $matches)) {
                /*— Paramètres nommés extraits de l’URL —*/
                $params = [];
                foreach ($route['vars'] as $name) {
                    $params[$name] = $matches[$name];
                }

                /*— Middlewares “avant” —*/
                foreach ($route['mws'] as $mwClass) {
                    /** @var object{handle:Closure|callable} $mw */
                    $mw = new $mwClass();
                    $mw->handle($params);          // lève exception ou redirige si refuse
                }

                /*— Contrôleur / Callback —*/
                $handler = $route['handler'];

                if (is_callable($handler)) {                       // Closure
                    call_user_func_array($handler, $params);
                } elseif (is_array($handler) && count($handler) === 2) {
                    [$class, $action] = $handler;
                    $controller = is_string($class) ? new $class() : $class;
                    call_user_func_array([$controller, $action], $params);
                } else {
                    throw new \RuntimeException('Handler invalide pour route ' . $path);
                }
                return;
            }
        }

        /*— Route non trouvée —*/
        http_response_code(404);
        echo '404 · Page non trouvée';
    }

    /*────────────────────── Helpers internes ────────────────────────*/

    /**
     *  Convertit un chemin `/ride/{id}` en regex `#^/ride/(?P<id>[^/]+)$#`
     *  et renvoie ["regex", ["id"]] (liste des segments variables).
     *
     *  @return array{0:string,1:array<int,string>}
     */
    private function compile(string $path): array
    {
        $path = rtrim($path, '/') ?: '/';

        $vars = [];
        $regex = preg_replace_callback(
            '/\{(\w+)\}/',
            function (array $m) use (&$vars): string {
                $vars[] = $m[1];
                return '(?P<' . $m[1] . '>[^/]+)';
            },
            $path
        );

        return ['#^' . $regex . '$#', $vars];
    }
}
