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

/**
 * Класс Application
 *
 * @package app\components
 */
class Application
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Controller
     * Текущий контроллер
     */
    protected $controller;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Database
     */
    protected $db;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Library
     */
    protected $library;

    /**
     * @var User
     */
    protected $user;


    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct( $config )
    {
        $this->name = $config['name'];

        $db = $config['db'];
        $pdo = new PDO( 'sqlite:' . $db['path'] );
        $this->db = new Database( $pdo );

        $this->request = Request::createFromGlobals();
        $this->response = new Response();

        $routes = $config['routes'];
        $routeCollection = new RouteCollection();
        foreach ( $routes as $name => $params ) {
            $path = $params['path'];
            $method = $params['method'];
            $controller = $params['controller'];
            $action = $params['action'];
            $callback = function ( $request, $response, $service, $app ) use ( $controller, $action ) {
                return $app->runAction( $controller, $action );
            };
            $route = new Route( $callback, $path, $method, true, is_string( $name ) ? $name : null );
            $routeCollection->addRoute( $route );

        }
        $this->router = new Router( null, $this, $routeCollection );

        $this->library = new Library( $this, $config['library'] );
    }

    /**
     * @return Response
     */
    public function run()
    {
        @session_start();

        if ( isset( $_SESSION['user_id'] ) ) {
            $userId = $_SESSION['user_id'];
            $row = $this->getDb()->users()->where( 'id', $userId )->fetch();
            if ( $row ) {
                $user = new User( $this->getDb() );
                $user->load( $row->getData() );
                $this->user = $user;
            }
            else {
                unset( $_SESSION['user_id'] );
            }
        }

        $this->router->dispatch( $this->request, $this->response, false );

        return $this->response->send();
    }

    /**
     *
     */
    public function action404()
    {
        header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404 );
        die();
    }

    /**
     *
     */
    public function action403()
    {
        header( $_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden', true, 403 );
        die();
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     *
     * @return mixed
     */
    public function runAction( $controllerName = 'default', $actionName = 'index' )
    {
        $controllerClass = 'app\controllers\\' . ucfirst( $controllerName ) . 'Controller';

        /** @var Controller $controller */
        $controller = new $controllerClass( strtolower( $controllerName ), $this );
        $this->controller = $controller;
        $controller->action = $actionName;

        return $controller->runAction( $actionName );
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function login( User $user )
    {
        if ( $user ) {
            $_SESSION['user_id'] = $user->id;
            $this->user = $user;

            return true;
        }

        return false;
    }

    /**
     *
     */
    public function logout()
    {
        if ( $this->user ) {
            $this->user = null;
        }
        @session_destroy();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isGuest()
    {
        return !$this->user;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return ( !$this->isGuest() && $this->getUser()->isAdmin() );
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return Controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return Library
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
