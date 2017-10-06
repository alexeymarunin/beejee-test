<?php

namespace app\base;

use app\components\Application;
use app\components\Database;


/**
 * Класс Controller
 * Базовый контроллер
 *
 * @package app\base
 */
class Controller
{
    /**
     * @var string
     * Текущее действие контроллера
     */
    public $action;

    /**
     * @var string
     */
    public $layout = 'main_layout';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var Application
     */
    protected $app;

    /**
     * Controller constructor.
     *
     * @param string $id
     * @param Application $app
     */
    public function __construct( $id, $app )
    {
        $this->id = $id;
        $this->app = $app;
    }

    /**
     * @param string $action
     *
     * @return mixed
     */
    public function runAction( $action )
    {
        if ( !method_exists( $this, $action ) ) {
            $action = 'action' . ucfirst( $action );
        }
        if ( !method_exists( $this, $action ) ) {
            $this->getApp()->action404();
        }

        return call_user_func( [ $this, $action ] );
    }

    /**
     * @param string $viewName
     * @param array $params
     *
     * @return string
     */
    public function render( $viewName, $params = [ ] )
    {
        $view = new View( $this->getApp(), $this->id );
        $content = $view->render( $viewName, $params );

        $layout = new View( $this->getApp() );
        $page = $layout->render( $this->layout, [ 'content' => $content ] );

        return $page;
    }

    /**
     * @param string $url
     * @param int $code
     *
     * @return \Klein\AbstractResponse
     */
    public function redirect( $url, $code = 302 )
    {
        if ( substr( $url, 0, 1 ) == '@' ) {
            $routeName = ltrim( $url, '@' );
            /** @var \Klein\Route $route */
            $route = $this->getApp()->getRouter()->routes()->get( $routeName );
            if ( $route ) {
                $url = $route->getPath();
            }
        }

        return $this->getApp()->getResponse()->redirect( $url, $code );
    }

    /**
     * @return \Klein\AbstractResponse
     */
    public function back()
    {
        $referer = $this->getApp()->getRequest()->server()->get( 'HTTP_REFERER' );
        if ( null !== $referer ) {
            return $this->redirect( $referer );
        }
        else {
            return $this->refresh();
        }
    }

    /**
     * @return \Klein\AbstractResponse
     */
    public function refresh()
    {
        return $this->redirect( $this->getApp()->getRequest()->uri() );
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return ( $_SERVER['REQUEST_METHOD'] === 'POST' );
    }

    /**
     * @return bool
     */
    public function isGuest()
    {
        return ( $this->getApp()->isGuest() );
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return ( $this->getApp()->isAdmin() );
    }

    /**
     * @return Application
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->getApp()->getDb();
    }
}
