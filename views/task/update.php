<?php

use app\base\View;
use app\models\Task;

/**
 * @var View $this
 * @var Task $model
 * @var bool $canAccept
 */

?>


<h1>Задача #<?= $model->id ?></h1>

<?= $this->alertModelErrors( $model ) ?>

<form method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <label for="username" class="col-sm-2 col-form-label">Логин</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="username" name="username" value="<?= $model->username ?>"
                   placeholder="Имя пользователя">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="email" name="email" value="<?= $model->email ?>"
                   placeholder="Email">
        </div>
    </div>
    <div class="form-group row">
        <label for="content" class="col-sm-2 col-form-label">Описание</label>
        <div class="col-sm-8">
            <textarea id="content" name="content" class="form-control"><?= $model->content ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="image" class="col-sm-2 col-form-label">Изображение</label>
        <div class="col-sm-8">
            <input type="file" id="image" name="image" class="form-control"/>
        </div>
    </div>
    <?php if ( $canAccept ) : ?>
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Статус</label>
            <div class="col-sm-8">
                <select id="status" name="status" class="form-control">
                    <option value="1" <?= $model->status == 1 ? 'selected' : '' ?>>Выполнена</option>
                    <option value="0"<?= $model->status != 1 ? 'selected' : '' ?>>Не выполнена</option>
                </select>
            </div>
        </div>
    <?php endif ?>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-success btn-lg">Сохранить</button>
            <a href="#" onclick="window.history.back()" class="btn btn-danger">Назад</a>
        </div>
    </div>


</form>

<div id="preview">
    <h2>Предварительный просмотр</h2>
    <div class="card" style="width: 320px;">
        <div class="card-header">
            <h4 class="card-title"><?= $model->username ?></h4>
            <div class="user-email"><?= $model->email ?></div>
        </div>
        <img class="task-image card-img-center img-thumbnail" src="<?= $model->getImageUrl() ?>" alt="Task image">
        <div class="card-body">

            <p class="card-text"><?= $model->content ?></p>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>
</div>

