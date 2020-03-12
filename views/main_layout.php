<?php

use app\base\View;

/**
 * @var View $this
 * @var string $content
 */

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title><?php echo $this->getApp()->getName() ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="/">BeeJee Test</a>

            <ul class="nav justify-content-end">
                <li class="nav-item">
                    Вы вошли как
                    &nbsp;
                </li>
                <li class="nav-item">
                    <?php if (!$this->getApp()->isGuest()) : ?>
                        <span class="badge badge-secondary"><?php echo $this->getApp()->getUser()->login ?></span>
                    <?php else : ?>
                        <span class="badge badge-secondary">Гость</span>
                    <?php endif ?>
                </li>
                <li class="nav-item">
                    &nbsp;
                    <?php if (!$this->getApp()->isGuest()) : ?>
                        <a href="/logout" class="btn btn-primary btn-sm">Выйти</a>
                    <?php else : ?>
                        <a href="/login" class="btn btn-success btn-sm">Войти</a>
                    <?php endif ?>
                </li>
            </ul>
        </nav>

        <?php echo $content ?>

        <hr>
        <footer>
            <div class="float-right">Марунин Алексей &copy; 2020</div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>

</html>
