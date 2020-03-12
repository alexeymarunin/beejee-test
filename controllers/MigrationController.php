<?php

namespace app\controllers;

use app\base\Controller;

class MigrationController extends Controller
{
    public function actionInstall()
    {
        $db = $this->getApp()->getDb();
        $sql = file_get_contents(BEEJEE_ROOT . '/data/install.sql');
        $db->pdo->exec($sql);
        echo 'Tables created successfully!' . PHP_EOL;
        return true;
    }

    public function actionUninstall()
    {
        $db = $this->getApp()->getDb();
        $sql = file_get_contents(BEEJEE_ROOT . '/data/uninstall.sql');
        $db->pdo->exec($sql);
        echo 'Tables dropped successfully!' . PHP_EOL;
        return true;
    }
}
