<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Media;
use app\models\Task;
use Pagination;

/**
 * Класс TaskController
 *
 * @package app\controllers
 */
class TaskController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $request = $this->getApp()->getRequest();
        $sortByUsername = strtoupper( $request->param( 'username', '' ) );
        $sortByEmail = strtoupper( $request->param( 'email', '' ) );
        $sortByStatus = strtoupper( $request->param( 'status', '' ) );
        $page = $request->param( 'page', 1 );

        $pageSize = env( 'PAGE_SIZE', 3 );

        if ( !$sortByUsername && !$sortByEmail && !$sortByStatus ) {
            $tasks = $this->getDb()->tasks()->paged( $pageSize, $page );
        }
        if ( $sortByUsername ) {
            $tasks = $this->getDb()->tasks()->orderBy( 'username', $sortByUsername )->paged( $pageSize, $page );
        }
        if ( $sortByEmail ) {
            $tasks = $this->getDb()->tasks()->orderBy( 'email', $sortByEmail )->paged( $pageSize, $page );
        }
        if ( $sortByStatus ) {
            $tasks = $this->getDb()->tasks()->orderBy( 'status', $sortByStatus )->paged( $pageSize, $page );
        }

        $rows = $tasks->fetchAll();

        $pagesTotal = $this->getDb()->tasks()->count();
        $pagination = new Pagination( $pageSize, $pagesTotal );
        $pagination->page = $page;
        $pagination->url = "/tasks?username=$sortByUsername&email=$sortByEmail&status=$sortByStatus&page=";

        $canAccept = $this->isAdmin();

        return $this->render( 'index', [
            'rows'           => $rows,
            'sortByUsername' => $sortByUsername,
            'sortByEmail'    => $sortByEmail,
            'sortByStatus'   => $sortByStatus,
            'page'           => $page,
            'pagesTotal'     => $pagesTotal,
            'pageSize'       => $pageSize,
            'canAccept'      => $canAccept,
            'pagination'     => $pagination,
        ] );
    }

    /**
     * @return string
     */
    public function actionView()
    {
        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get( 'id' );

        $model = $this->findModel( $id );
        if ( !$model ) {
            $this->getApp()->action404();
        }

        $canAccept = $this->isAdmin();

        return $this->render( 'view', [
            'model'     => $model,
            'canAccept' => $canAccept,
        ] );
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $request = $this->getApp()->getRequest();
        $data = $request->paramsPost()->all();

        $model = new Task( $this->getDb() );

        if ( $model->load( $data ) && $model->save() ) {
            $media = $this->uploadMediaForTask( $model );
            if ( $media ) {
                return $this->redirect( '@tasks' );
            }

            return $this->redirect( '@tasks' );
        }

        $canAccept = $this->isAdmin();

        return $this->render( 'create', [
            'model'     => $model,
            'canAccept' => $canAccept,
        ] );
    }

    /**
     * @return string
     */
    public function actionUpdate()
    {
        if ( !$this->isAdmin() ) {
            $this->getApp()->action403();
        }

        $request = $this->getApp()->getRequest();
        $data = $request->paramsPost()->all();
        $id = $request->paramsNamed()->get( 'id' );

        $model = $this->findModel( $id );
        if ( !$model ) {
            $this->getApp()->action404();
        }

        if ( $model->load( $data ) && $model->save() ) {
            $media = $this->uploadMediaForTask( $model );
            return $this->redirect( '@tasks' );
        }

        $canAccept = $this->isAdmin();

        return $this->render( 'update', [
            'model'     => $model,
            'canAccept' => $canAccept,
        ] );
    }

    /**
     * @return \Klein\AbstractResponse
     */
    public function actionAccept()
    {
        if ( !$this->isAdmin() ) {
            $this->getApp()->action403();
        }

        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get( 'id' );
        $model = $this->findModel( $id );
        if ( !$model ) {
            $this->getApp()->action404();
        }

        $status = $request->paramsGet()->get( 'status', 1 );
        $model->status = $status;
        $model->save( false );

        return $this->back();
    }

    /**
     * @return \Klein\AbstractResponse
     */
    public function actionDelete()
    {
        if ( !$this->isAdmin() ) {
            $this->getApp()->action403();
        }

        $request = $this->getApp()->getRequest();
        $id = $request->paramsNamed()->get( 'id' );
        $model = $this->findModel( $id );
        if ( !$model ) {
            $this->getApp()->action404();
        }

        $model->delete();

        return $this->back();
    }

    /**
     *
     */
    public function actionUpload()
    {
        $request = $this->getApp()->getRequest();

        $media = $this->getApp()->getLibrary()->uploadImage( 'image' );

        $data = [
            'url' => $media->getUrl(),
        ];
        $this->getApp()->getResponse()->json( $data );
        die();
    }

    /**
     * @param int $id
     *
     * @return Task|null
     */
    protected function findModel( $id )
    {
        $model = null;
        if ( $id ) {
            $row = $this->getDb()->tasks()->where( 'id', $id )->fetch();
            if ( $row ) {
                $model = new Task( $this->getDb() );
                $model->load( $row->getData() );
            }
        }

        return $model;
    }

    /**
     * @param string $name
     *
     * @return Task $model
     * @return string $name
     *
     * @return Media|null
     */
    protected function uploadMediaForTask( Task $model, $name = 'image' )
    {
        if ( isset( $_FILES[ $name ] ) ) {
            $media = $this->getApp()->getLibrary()->uploadImage( $name );
            if ( $media ) {
                if ( $media->hasErrors() ) {
                    $model->addError( 'media_id', $media->getError( 'filename') );
                }
                else {
                    $model->media_id = $media->id;
                    $model->save( false );
                    return $media;
                }
            }
        }

        return null;
    }
}
