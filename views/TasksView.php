<div class="tasks_wrapper">
    <div class="d-flex justify-content-between align-items-center tasks_header mb-3">
        <h4>Задачи (Всего: <?=$page?>)</h4>
        <button type="button" class="btn btn-success btn-sm">Добавить задачу</button>
    </div>
    <div class="d-flex justify-content-between align-items-center tasks_sort mb-3">
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
            <button type="button" class="btn btn-secondary">Имени пользователя</button>
            <button type="button" class="btn btn-secondary">Email</button>
            <button type="button" class="btn btn-secondary">Статуса</button>
        </div>
        <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Сортировка по
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <a class="dropdown-item" href="#">Возрастанию</a>
                <a class="dropdown-item" href="#">Убыванию</a>
            </div>
        </div>
    </div>
    <div class="d-flex tasks_body mb-3">
        <ul class="list-group tasks_list">
            <li class="list-group-item tasks_item">
                <div class="tasks_item_card">
                    <p class="tasks_item_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, dolores error sit molestiae illum perspiciatis.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-info">user 1</span>
                        <span class="badge badge-light">test@mail.com</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item list-group-item-success tasks_item">
                <div class="tasks_item_card">
                    <p class="tasks_item_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, dolores error sit molestiae illum perspiciatis.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-info">user 1</span>
                        <span class="badge badge-light">test@mail.com</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item tasks_item">
                <div class="tasks_item_card">
                    <p class="tasks_item_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, dolores error sit molestiae illum perspiciatis.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-info">user 1</span>
                        <span class="badge badge-light">test@mail.com</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="d-flex justify-content-end align-items-center tasks_footer">
        <nav aria-label="...">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item active" aria-current="page">
                <span class="page-link">
                    1
                    <span class="sr-only">(current)</span>
                </span>
                </li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>
    </div>
</div>