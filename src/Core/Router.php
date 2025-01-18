<?php

namespace Vrainsietech\Vrtmvc\Core;

use Vrainsietech\Vrtmvc\Http\Request;
use Vrainsietech\Vrtmvc\Http\Response;
use Vrainsietech\Vrtmvc\Http\RedirectResponse;
use Closure;

class Router
{
    private $routes = [];
    private $namedRoutes = [];
    private $currentRoute = null;
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    function addRoute(string $method, string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'middleware' => $middleware,
            'name' => $name
        ];

        if ($name) {
            $this->namedRoutes[$name] = $path;
        }
    }

    function get(string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('get', $path, $handler, $middleware, $name);
    }

    function post(string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('post', $path, $handler, $middleware, $name);
    }

    function put(string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('put', $path, $handler, $middleware, $name);
    }

    function patch(string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('patch', $path, $handler, $middleware, $name);
    }

    function delete(string $path, $handler, array $middleware = [], ?string $name = null): void
    {
        $this->addRoute('delete', $path, $handler, $middleware, $name);
    }

    function group(array $options, Closure $callback): void
    {
        $originalMiddleware = $options['middleware'] ?? [];
        $callback($this);
        // Reset middleware after group
        $this->currentMiddleware = $originalMiddleware;
    }

    function match(): Response|RedirectResponse|null
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        foreach ($this->routes[$method] ?? [] as $routePath => $routeData) {
            if ($this->matchRoute($path, $routePath, $params)) {
                $this->currentRoute = $routeData;
                $this->request->setAttribute('routeParams', $params);
                return $this->handleRoute($routeData);
            }
        }

        return new Response('Not Found', 404);
    }

    private function matchRoute(string $requestPath, string $routePath, &$params): bool
    {
        $routePath = preg_replace('/\/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '/(?<$1>[^/]+)', $routePath);
        $routePath = str_replace('/', '\/', $routePath);
        $pattern = '/^' . $routePath . '$/';

        if (preg_match($pattern, $requestPath, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
    }

    private function handleRoute(array $routeData): Response|RedirectResponse
    {
        $handler = $routeData['handler'];
        $middleware = $routeData['middleware'];

        // Run middleware
        $response = $this->runMiddleware($middleware, $this->request, function ($request) use ($handler) {
            if (is_callable($handler)) {
                return $handler($request);
            }

            if (is_array($handler) && count($handler) === 2 && class_exists($handler[0]) && method_exists($handler[0], $handler[1])) {
                $controller = new $handler[0]();
                return $controller->{$handler[1]}($request);
            }

            throw new \Exception('Invalid route handler.');
        });
        return $response;
    }

    private function runMiddleware(array $middleware, Request $request, Closure $next)
    {
        if (empty($middleware)) {
            return $next($request);
        }

        $middlewareClass = array_shift($middleware);

        if (is_string($middlewareClass) && class_exists($middlewareClass)) {
            $middlewareInstance = new $middlewareClass();
        } elseif (is_object($middlewareClass)) {
            $middlewareInstance = $middlewareClass;
        } else {
            throw new \Exception('Invalid middleware provided.');
        }

        return $middlewareInstance->handle($request, function ($request) use ($middleware, $next) {
            return $this->runMiddleware($middleware, $request, $next);
        });
    }

    function generate(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \InvalidArgumentException("Route with name '$name' not found.");
        }

        $path = $this->namedRoutes[$name];

        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', $value, $path);
        }

        return $path;
    }
}