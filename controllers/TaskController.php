<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Task;
use Pagination;

class TaskController extends Controller
{
    public function actionIndex()
    {
        $request = $this->getApp()->getRequest();
        $sortByUsername = strtoupper($request->param('username', ''));
        $sortByEmail = strtoupper($request->param('email', ''));
        $sortByStatus = strtoupper($request->param('status', ''));
        $page = $request->param('page', 1);
        $pageSize = env('PAGE_SIZE', 3);
        if (!$sortByUsername && !$sortByEmail && !$sortByStatus) {
            $tasks = $this->getDb()->tasks()->paged($pageSize, $page);
        }
        if ($sortByUsername) {
            $tasks = $this->getDb()->tasks()->orderBy('username', $sortByUsername)->paged($pageSize, $page);
        }
        if ($sortByEmail) {
            $tasks = $this->getDb()->tasks()->orderBy('email', $sortByEmail)->paged($pageSize, $page);
        }
        if ($sortByStatus) {
            $tasks = $this->getDb()->tasks()->orderBy('status', $sortByStatus)->paged($pageSize, $page);
        }
        $rows = $tasks->fetchAll();
        $pagesTotal = $this->getDb()->tasks()->count();
        $pagination = new Pagination($pageSize, $pagesTotal);
        $pagination->page = $page;
        $pagination->url = "/tasks?username=$sortByUsername&email=$sortByEmail&status=$sortByStatus&page=";
        $canAccept = $this->isAdmin();
        $params = [
            'rows'           => $rows,
            'sortByUsername' => $sortByUsername,
            'sortByEmail'    => $sortByEmail,
            'sortByStatus'   => $sortByStatus,
            'page'           => $page,
            'pagesTotal'     => $pagesTotal,
            'pageSize'       => $pageSize,
            'canAccept'      => $canAccept,
            'pagination'     => $pagination,
        ];
        return $this->render('index', $params);
    }

    public function actionView()
    {
        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get('id');
        $model = $this->findModel($id);
        if (!$model) {
            $this->getApp()->action404();
        }
        $canAccept = $this->isAdmin();
        $params = [
            'model'     => $model,
            'canAccept' => $canAccept,
        ];
        return $this->render('view', $params);
    }

    public function actionCreate()
    {
        $request = $this->getApp()->getRequest();
        $data = $request->paramsPost()->all();
        $model = new Task($this->getDb());
        if ($model->load($data) && $model->save()) {
            return $this->redirect('@tasks');
        }
        $canAccept = $this->isAdmin();
        $params = [
            'model'     => $model,
            'canAccept' => $canAccept,
        ];
        return $this->render('create', $params);
    }

    public function actionUpdate()
    {
        if (!$this->isAdmin()) {
            $this->getApp()->action403();
        }
        $request = $this->getApp()->getRequest();
        $data = $request->paramsPost()->all();
        $id = $request->paramsNamed()->get('id');
        $model = $this->findModel($id);
        if (!$model) {
            $this->getApp()->action404();
        }
        if ($model->load($data) && $model->save()) {
            return $this->redirect('@tasks');
        }
        $canAccept = $this->isAdmin();
        $params = [
            'model'     => $model,
            'canAccept' => $canAccept,
        ];
        return $this->render('update', $params);
    }

    public function actionAccept()
    {
        if (!$this->isAdmin()) {
            $this->getApp()->action403();
        }
        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get('id');
        $model = $this->findModel($id);
        if (!$model) {
            $this->getApp()->action404();
        }
        $status = $request->paramsGet()->get('status', 1);
        $model->status = $status;
        $model->save(false);
        return $this->back();
    }

    public function actionDelete()
    {
        if (!$this->isAdmin()) {
            $this->getApp()->action403();
        }
        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get('id');
        $model = $this->findModel($id);
        if (!$model) {
            $this->getApp()->action404();
        }
        $model->delete();
        return $this->back();
    }

    protected function findModel(int $id): ?Task
    {
        $model = null;
        if ($id) {
            $row = $this->getDb()->tasks()->where('id', $id)->fetch();
            if ($row) {
                $model = new Task($this->getDb());
                $model->load($row->getData());
            }
        }
        return $model;
    }
}
