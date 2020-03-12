<?php

namespace app\base;


use app\components\Application;

class View
{
    protected Application $app;

    protected string $path;

    public function __construct(Application $app, string $path = null)
    {
        $this->app = $app;
        if ($path) {
            $this->path = BEEJEE_ROOT . '/views/' . $path . '/';
        } else {
            $this->path = BEEJEE_ROOT . '/views/';
        }
    }

    public function render(string $viewName, array $params = []): string
    {
        $viewPath = $this->path . $viewName . '.php';
        return $this->renderFile($viewPath, $params);
    }

    public function renderFile(string $path, array $params = []): string
    {
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        require($path);
        return ob_get_clean();
    }

    public function alertModelErrors(Model $model): string
    {
        $errors = $model->getErrors();
        $html = '';
        foreach ($errors as $attribute => $error) {
            $html .= '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        return $html;
    }

    public function getApp(): Application
    {
        return $this->app;
    }
}
