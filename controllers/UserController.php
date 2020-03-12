<?php

namespace app\controllers;

use app\base\Controller;
use app\models\LoginForm;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!$this->isGuest()) {
            return $this->redirect('@home');
        }
        $request = $this->getApp()->getRequest();
        $model = new LoginForm($this->getDb());
        $data = $request->paramsPost()->all();
        if ($model->load($data) && $model->validate()) {
            $this->getApp()->login($model->getUser());
            return $this->redirect('@home');
        }
        $params = [
            'model' => $model,
        ];
        return $this->render('login', $params);
    }

    public function actionLogout()
    {
        $this->getApp()->logout();
        return $this->redirect('@home');
    }
}
