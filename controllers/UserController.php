<?php

namespace app\controllers;

use app\base\Controller;
use app\models\LoginForm;
use app\models\RegisterForm;
use Klein\Response;


/**
 * Класс UserController
 *
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * @return Response|string
     */
    public function actionLogin()
    {
        if ( !$this->isGuest() ) {
            return $this->redirect( '@home' );
        }
        $request = $this->getApp()->getRequest();

        $model = new LoginForm( $this->getDb() );
        $data = $request->paramsPost()->all();
        if ( $model->load( $data ) && $model->validate() ) {
            $this->getApp()->login( $model->getUser() );

            return $this->redirect( '@home' );
        }

        return $this->render( 'login', [
            'model' => $model,
        ] );
    }

    /**
     * @return Response|string
     */
    public function actionRegister()
    {
        if ( !$this->isGuest() ) {
            return $this->redirect( '@home' );
        }

        $request = $this->getApp()->getRequest();
        $data = $request->paramsPost()->all();

        $model = new RegisterForm( $this->getDb() );
        if ( $model->load( $data ) && $model->validate() ) {
            $model->getUser()->save();
            $this->getApp()->login( $model->getUser() );
            return $this->redirect( '@home' );
        }

        return $this->render( 'register', [
            'model' => $model,
        ] );
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        $this->getApp()->logout();

        return $this->redirect( '@home' );
    }
}
