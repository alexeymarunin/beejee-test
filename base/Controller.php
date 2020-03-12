<?php

namespace app\base;

use app\components\Application;
use app\components\Database;

use Klein\AbstractResponse;

class Controller
{
    public string $action = 'index';

    public string $layout = 'main_layout';

    protected string $id;

    protected Application $app;

    public function __construct(string $id, Application $app)
    {
        $this->id = $id;
        $this->app = $app;
    }

    public function runAction(string $action)
    {
        if (!method_exists($this, $action)) {
            $action = 'action' . ucfirst($action);
        }
        if (!method_exists($this, $action)) {
            $this->getApp()->action404();
        }
        return call_user_func([$this, $action]);
    }

    public function render(string $viewName, array $params = []): string
    {
        $view = new View($this->getApp(), $this->id);
        $content = $view->render($viewName, $params);
        $layout = new View($this->getApp());
        $page = $layout->render($this->layout, ['content' => $content]);
        return $page;
    }

    public function redirect(string $url, int $code = 302): AbstractResponse
    {
        if (substr($url, 0, 1) == '@') {
            $routeName = ltrim($url, '@');
            $route = $this->getApp()->getRouter()->routes()->get($routeName);
            if ($route) {
                $url = $route->getPath();
            }
        }
        return $this->getApp()->getResponse()->redirect($url, $code);
    }

    public function back(): AbstractResponse
    {
        $referer = $this->getApp()->getRequest()->server()->get('HTTP_REFERER');
        if (null !== $referer) {
            return $this->redirect($referer);
        } else {
            return $this->refresh();
        }
    }

    public function refresh(): AbstractResponse
    {
        return $this->redirect($this->getApp()->getRequest()->uri());
    }

    public function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] === 'POST');
    }

    public function isGuest(): bool
    {
        return ($this->getApp()->isGuest());
    }

    public function isAdmin(): bool
    {
        return ($this->getApp()->isAdmin());
    }

    public function getApp(): Application
    {
        return $this->app;
    }

    public function getDb(): Database
    {
        return $this->getApp()->getDb();
    }
}
