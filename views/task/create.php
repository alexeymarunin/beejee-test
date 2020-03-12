<?php

use app\base\View;
use app\models\Task;

/**
 * @var View $this
 * @var Task $model
 * @var bool $canAccept
 */

?>


<h1>Новая задача</h1>

<?php echo $this->alertModelErrors($model) ?>

<form method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <label for="username" class="col-sm-2 col-form-label">Пользователь</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $model->username ?>" placeholder="Имя пользователя" />
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $model->email ?>" placeholder="Email" />
        </div>
    </div>
    <div class="form-group row">
        <label for="content" class="col-sm-2 col-form-label">Описание</label>
        <div class="col-sm-8">
            <textarea id="content" name="content" class="form-control"><?php echo $model->content ?></textarea>
        </div>
    </div>
    <?php if ($canAccept) : ?>
        <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label">Статус</label>
            <div class="col-sm-8">
                <select id="status" name="status" class="form-control">
                    <option value="1" <?php echo $model->status == 1 ? 'selected' : '' ?>>Выполнена</option>
                    <option value="0" <?php echo $model->status != 1 ? 'selected' : '' ?>>Не выполнена</option>
                </select>
            </div>
        </div>
    <?php endif ?>
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="#" onclick="window.history.back()" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
            <button type="submit" class="btn btn-primary btn-lg">Создать</button>
        </div>
    </div>
</form>
