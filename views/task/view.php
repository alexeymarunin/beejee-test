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
    <?php echo $model->status ?
        '<i class="fa fa-check-circle text-success" aria-hidden="true"></i>' :
        '<i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>'
    ?>
    Задача #<?php echo $model->id ?>
</h1>

<div class="card" style="width: 320px;">
    <div class="card-header">
        <h4 class="card-title"><?php echo $model->username ?></h4>
        <div><?php echo $model->email ?></div>
    </div>
    <div class="card-body">

        <p class="card-text">
            <?php echo $model->content ?>
        </p>
    </div>
    <div class="card-footer text-muted">
        <?php if ($canAccept) : ?>
            <a href="/task/<?php echo $model->id ?>/update" class="btn btn-primary btn-sm">Изменить</a>
            <a href="/task/<?php echo $model->id ?>/accept?status=<?php echo $model->status == 1 ? 0 : 1 ?>" class="btn btn-<?php echo $model->status == 1 ? 'danger' : 'success' ?> btn-sm">
                <?php echo $model->status == 1 ? 'Снять' : 'Выполнить' ?>
            </a>
        <?php endif ?>
    </div>
</div>

<a href="#" onclick="window.history.back()" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</a>
