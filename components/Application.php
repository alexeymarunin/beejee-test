<?php

namespace app\components;

use app\base\Controller;
use app\models\User;
use Klein\DataCollection\RouteCollection;
use Klein\Klein as Router;
use Klein\Request;
use Klein\Response;
use Klein\Route;
use PDO;

class Application
{
    protected string $name;

    protected Controller $controller;

    protected Request $request;

    protected Response $response;

    protected Database $db;

    protected Router $router;

    protected $user;

    public function __construct(array $config)
    {
        $this->name = $config['name'];
        $db = $config['db'];
        $pdo = new PDO('sqlite:' . $db['path']);
        $this->db = new Database($pdo);
        $this->request = Request::createFromGlobals();
        $this->response = new Response();
        $routes = $config['routes'];
        $routeCollection = new RouteCollection();
        foreach ($routes as $name => $params) {
            $path = $params['path'];
            $method = $params['method'];
            $controller = $params['controller'];
            $action = $params['action'];
            $callback = function ($request, $response, $service, $app) use ($controller, $action) {
                return $app->runAction($controller, $action);
            };
            $route = new Route($callback, $path, $method, true, is_string($name) ? $name : null);
            $routeCollection->addRoute($route);
        }
        $this->router = new Router(null, $this, $routeCollection);
    }

    public function run()
    {
        @session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $row = $this->getDb()->users()->where('id', $userId)->fetch();
            if ($row) {
                $user = new User($this->getDb());
                $user->load($row->getData());
                $this->user = $user;
            } else {
                unset($_SESSION['user_id']);
            }
        }
        $this->router->dispatch($this->request, $this->response, false);
        return $this->response->send();
    }

    public function action404()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
        die();
    }

    public function action403()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden', true, 403);
        die();
    }

    public function runAction(string $controllerName = 'default', string $actionName = 'index')
    {
        $controllerClass = 'app\controllers\\' . ucfirst($controllerName) . 'Controller';
        $controller = new $controllerClass(strtolower($controllerName), $this);
        $this->controller = $controller;
        $controller->action = $actionName;
        return $controller->runAction($actionName);
    }

    public function login(User $user): bool
    {
        if ($user) {
            $_SESSION['user_id'] = $user->id;
            $this->user = $user;
            return true;
        }
        return false;
    }

    public function logout()
    {
        if ($this->user) {
            $this->user = null;
        }
        @session_destroy();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function isGuest(): bool
    {
        return !$this->user;
    }

    public function isAdmin(): bool
    {
        return (!$this->isGuest() && $this->getUser()->isAdmin());
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function getDb(): Database
    {
        return $this->db;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
