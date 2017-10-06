<?php

use app\base\View;
use app\models\Task;
use LessQL\Result;

/**
 * @var View $this
 * @var Result[] $rows
 * @var string $sortByUsername
 * @var string $sortByEmail
 * @var string $sortByStatus
 * @var int $page
 * @var int $pageSize
 * @var int $pagesTotal
 * @var bool $canAccept
 * @var Pagination $pagination
 */

?>

<h1>Список задач</h1>

<table class="table table-responsive">
    <thead class="thead-inverse">
    <tr>
        <th width="16">#</th>
        <th width="96"></th>
        <th>
            Пользователь
            <?php if ( !$sortByUsername ) : ?>
                <a class="text-success" href="/tasks?username=ASC&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-success" href="/tasks?username=DESC&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
            <?php elseif ( $sortByUsername == 'ASC' ) : ?>
                <span>&uarr;</span>
                <a class="text-success" href="/tasks?username=DESC&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php else : ?>
                <span>&darr;</span>
                <a class="text-success" href="/tasks?username=ASC&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=&email=<?= $sortByEmail ?>&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php endif ?>
        </th>
        <th>
            Email
            <?php if ( !$sortByEmail ) : ?>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=ASC&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=DESC&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
            <?php elseif ( $sortByEmail == 'ASC' ) : ?>
                <span>&uarr;</span>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=DESC&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=<?= $sortByUsername ?>&email=&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php else : ?>
                <span>&darr;</span>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=ASC&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=<?= $sortByUsername ?>&email=&status=<?= $sortByStatus ?>&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php endif ?>
        </th>
        <th>
            Статус
            <?php if ( !$sortByStatus ) : ?>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=ASC&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=DESC&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
            <?php elseif ( $sortByStatus == 'ASC' ) : ?>
                <span>&uarr;</span>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=DESC&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php else : ?>
                <span>&darr;</span>
                <a class="text-success" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=ASC&page=<?= $page ?>">
                    <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                </a>
                <a class="text-danger" href="/tasks?username=<?= $sortByUsername ?>&email=<?= $sortByEmail ?>&status=&page=<?= $page ?>">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
            <?php endif ?>
        </th>
        <th>
            Действия
        </th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ( $rows as $n => $row ) : ?>
        <tr class="table-<?= $row->status == 1 ? 'success' : 'danger'?>">
            <td><?= ($page - 1) * $pageSize + $n + 1  ?></td>
            <td>
                <?php $url = Task::imageUrl( $row->media_id, $this->getApp()->getDb() ) ?>
                <img class="img-thumbnail" src="<?= $url ?>"/>
            </td>
            <td><?= $row->username ?></td>
            <td><?= $row->email ?></td>
            <td>
                <?= $row->status ?
                    '<i class="fa fa-check-circle text-success" aria-hidden="true"></i> Выполнена' :
                    '<i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Не выполнена'
                ?>
            </td>
            <td>
                <a class="btn btn-sm btn-info" href="/task/<?= $row->id ?>">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>
                <?php if ( $canAccept ) : ?>
                    <a class="btn btn-sm btn-info" href="/task/<?= $row->id ?>/accept?status=<?= $row->status == 1 ? 0 : 1 ?>">
                        <?= $row->status == 1 ?
                            '<i class="fa fa-times-circle" aria-hidden="true"></i>'
                            : '<i class="fa fa-check-circle" aria-hidden="true"></i>' ?>
                    </a>
                    <a class="btn btn-sm btn-danger" href="/task/<?= $row->id ?>/delete">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<?php if ( !$pagesTotal ) : ?>
    <div class="alert alert-info" role="alert">
        Не найдено ни одной задачи
    </div>
<?php else : ?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?= '' /*$pagination->first(
            '<a class="page-link" href="{url}{nr}"><<</a></li>',
            '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"><<</a></li>'
        )*/ ?>
        <?= $pagination->previous(
            '<li class="page-item"><a class="page-link" href="{url}{nr}"><span aria-hidden="true">&laquo;</span></a><span class="sr-only">Previous</span></a></li>',
            '<li class="page-item disabled"><a class="page-link" href="{url}{nr}" tabindex="-1"><span aria-hidden="true">&laquo;</span></a><span class="sr-only">NePreviousxt</span></a></li>'
        ) ?>
        <?= $pagination->numbers(
            '<li class="page-item"><a class="page-link" href="{url}{nr}">{nr}<span class="sr-only">(current)</span></a></li>',
            '<li class="page-item active"><a class="page-link" href="#">{nr}<span class="sr-only">(current)</span></a></li>'
        ) ?>
        <?= $pagination->next(
            '<li class="page-item"><a class="page-link" href="{url}{nr}"><span aria-hidden="true">&raquo;</span></a><span class="sr-only">Next</span></li>',
            '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>'
        ) ?>
        <?= '' /*$pagination->last(
            '<li class="page-item"><a class="page-link" href="{url}{nr}">>></a></li>',
            '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">>></a></li>'
        ) */ ?>
        <br>
        <br>
    </ul>
</nav>

<div class="float-right">
<?= $pagination->info( 'Всего задач: {total}' ) ?>
    <br>
<?= $pagination->info( 'Всего страниц: {pages} ' ) ?>
</div>

<?php endif ?>

<a href="/tasks/create" class="btn btn-primary btn-lg">Создать задачу</a>
