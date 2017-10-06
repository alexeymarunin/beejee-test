<?php

namespace app\controllers;

use app\base\Controller;


/**
 * Класс MigrationController
 *
 * @package app\controllers
 */
class MigrationController extends Controller
{
    /**
     * @return bool
     */
    public function actionInstall()
    {
        $db = $this->getApp()->getDb();
        $sql = file_get_contents( BEEJEE_ROOT . '/data/install.sql' );
        $db->pdo->exec( $sql );

        echo 'Tables created successfully!' . PHP_EOL;
        return true;
    }

    /**
     * @return bool
     */
    public function actionUninstall()
    {
        $db = $this->getApp()->getDb();
        $sql = file_get_contents( BEEJEE_ROOT . '/data/uninstall.sql' );
        $db->pdo->exec( $sql );

        echo 'Tables dropped successfully!' . PHP_EOL;
        return true;
    }
}
