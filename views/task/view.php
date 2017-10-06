<?php

use app\base\View;
use app\models\Task;

/**
 * @var View $this
 * @var Task $model
 * @var bool $canAccept
 */

?>


<h1>
    <?= $model->status ?
        '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>' :
        '<i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>'
    ?>
    Задача #<?= $model->id ?>
</h1>

<div class="card" style="width: 320px;">
    <div class="card-header">
        <h4 class="card-title"><?= $model->username ?></h4>
        <div><?= $model->email ?></div>
    </div>
    <img class="card-img-center img-thumbnail" src="<?= $model->getImageUrl() ?>" alt="Task image">
    <div class="card-body">

        <p class="card-text">
            <?= $model->content ?>
        </p>
    </div>
    <div class="card-footer text-muted">
        <?php if ( $canAccept ) : ?>
            <a href="/task/<?= $model->id ?>/update" class="btn btn-primary btn-sm">Изменить</a>
            <a href="/task/<?= $model->id ?>/accept?status=<?= $model->status == 1 ? 0 : 1 ?>" class="btn btn-<?= $model->status == 1 ? 'danger' : 'success' ?> btn-sm">
                <?= $model->status == 1 ? 'Снять' : 'Выполнить'?>
            </a>
        <?php endif ?>
    </div>
</div>

<a href="#" onclick="window.history.back()" class="btn-lg">Назад</a>
<div class="clearfix"></div>