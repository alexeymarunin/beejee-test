<?php

use app\base\View;
use app\models\LoginForm;

/**
 * @var View $this
 * @var LoginForm $model
 */

?>
<h1>Вход в систему</h1>

<?= $this->alertModelErrors($model) ?>

<form method="post">
    <div class="form-group row">
        <label for="username" class="col-sm-2 col-form-label">Логин</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="username" name="username" value="<?= $model->username ?>" placeholder="Логин">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Пароль</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Войти</button>
        </div>
    </div>

</form>
