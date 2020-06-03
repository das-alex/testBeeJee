<div class="tasks_wrapper">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center tasks_header mb-3">
        <h4>Задачи</h4>
        <div>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTask" data-whatever="@mdo">Авторизация</button>
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addTask" data-whatever="@mdo">Добавить задачу</button>
        </div>
    </div>
    <!-- Sorting -->
    <div id="filtersGroup" class="d-flex justify-content-between align-items-center tasks_sort mb-3">
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
            <? session_start(); ?>
            <button
                id="sortByName"
                type="button"
                sort="user_name"
                class="btn btn-<?=$_SESSION['sorting']['field'] === 'user_name' ? 'success' : 'secondary'?>">
                Имени пользователя
            </button>
            <button
                id="sortByEmail"
                type="button"
                sort="email"
                class="btn btn-<?=$_SESSION['sorting']['field'] === 'email' ? 'success' : 'secondary'?>">
                Email
            </button>
            <button
                id="sortByStatus"
                type="button"
                sort="status"
                class="btn btn-<?=$_SESSION['sorting']['field'] === 'status' ? 'success' : 'secondary'?>">
                Статуса
            </button>
        </div>
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Сортировка по
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a
                    sort="asc"
                    class="dropdown-item <?=$_SESSION['sorting']['type'] === 'asc' ? 'bg-success text-white' : ''?>"
                    href="#">
                    Возрастанию
                </a>
                <a
                    sort="desc"
                    class="dropdown-item <?=$_SESSION['sorting']['type'] === 'desc' ? 'bg-success text-white' : ''?>"
                    href="#">
                    Убыванию
                </a>
            </div>
        </div>
    </div>
    <!-- List of tasks -->
    <div class="d-flex tasks_body mb-3">
        <ul class="list-group tasks_list">
            <?foreach($tasks as $task):?>
                <li class="list-group-item tasks_item <?=$task["status"] != 0 ? 'list-group-item-success' : ''?>">
                    <div class="tasks_item_card">
                        <p class="tasks_item_text">
                            <?=$task["task"]?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge badge-info"><?=$task["user_name"]?></span>
                            <span class="badge badge-light"><?=$task["email"]?></span>
                        </div>
                    </div>
                </li>
            <?endforeach?>
        </ul>
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-content-end align-items-center tasks_footer">
        <nav aria-label="...">
            <ul class="pagination pagination-sm mb-0">
                <?for($i=1; $i<=$countPages["countPages"]; $i++):?>
                    <li class="page-item <?=$i == $page ? 'active' : ''?>">
                        <?if($i == $page):?>
                            <span class="page-link">
                                <?=$i?>
                                <span class="sr-only">(current)</span>
                            </span>
                        <?endif?>

                        <?if($i != $page):?>
                            <a class="page-link" href="/tasks/<?=$i?>"><?=$i?></a>
                        <?endif?>
                    </li>
                <?endfor?>
            </ul>
        </nav>
    </div>
</div>
<!-- Add task modal -->
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Новая задача</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_new_task_form" method="post" action="/tasks/add">
                    <div class="form-group">
                        <label for="name" class="col-form-label">Имя пользователя:</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="task" class="col-form-label">Задача:</label>
                        <textarea class="form-control" id="task"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="addTaskBtn" type="button" class="btn btn-primary">Добавить задачу</button>
            </div>
        </div>
    </div>
</div>
<!-- Notification -->
<div class="tasks_alerts">
    <div class="alert alert-success" role="alert"></div>
    <div class="alert alert-danger" role="alert"></div>
</div>