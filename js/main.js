const addTaskBtn = document.getElementById('addTaskBtn');
const filtersGroup = document.getElementById('filtersGroup');
const addTaskOpenModal = document.getElementById('addTaskOpenModal');
const loginBtn = document.getElementById('loginBtn');
const editTaskBtn = document.querySelectorAll('.editTask');

const addTaskForm = document.getElementById('add_new_task_form')
    ? document.getElementById('add_new_task_form').elements
    : undefined;

const isTaskEdited = {
    dataId: undefined,
    openToEdit: false,
    changed: false
}

const xhr = (function() {
    function xhr() {
        this.query = new XMLHttpRequest();
    }

    function handleResponse(xhr) {
        return new Promise((res) => {
            xhr.addEventListener('load', (event) => {
                const {status, response} = event.target;
                res({
                    status,
                    response
                });
            });
        });
    }

    xhr.prototype.post = function(path, data) {
        this.query.open('POST', path, true);
        this.query.send(data);

        return handleResponse(this.query);
    }

    xhr.prototype.get = function(path) {
        this.query.open('GET', path, true);
        this.query.send();

        return handleResponse(this.query);
    }

    return new xhr();
})();

const alert = (function() {
    function alert() {
        this.successAlert = document.querySelector('.alert-success');
        this.dangerAlert = document.querySelector('.alert-danger');
    }

    function off(el) {
        setTimeout((event) => {
            el.style.display = 'none';
        }, 10000);
    }

    alert.prototype.success = function(message) {
        this.successAlert.innerHTML = message;
        this.successAlert.style.display = 'block';
        off(this.successAlert);
    }

    alert.prototype.danger = function(message) {
        this.dangerAlert.innerHTML = message;
        this.dangerAlert.style.display = 'block';
        off(this.dangerAlert);
    }

    return new alert();
})();

if (addTaskBtn) {
    addTaskBtn.addEventListener('click', (ev) => {
        ev.preventDefault();
    
        const formData = new FormData();

        let path = '/tasks/add';
        formData.append('task', addTaskForm.task.value);

        if (isTaskEdited.openToEdit) {
            path = '/tasks/update';
            formData.append('taskDone', +addTaskForm.taskDone.checked + (isTaskEdited.changed ? 2 : 0));
            formData.append('dataId', isTaskEdited.dataId);
        } else {
            formData.append('name', addTaskForm.name.value);
            formData.append('email', addTaskForm.email.value);
        }

        xhr.post(path, formData).then(data => {
            if (data.status === 200) {
                location.reload();
                alert.success('Запись успешно сохранена');
            } else if (data.status === 400) {
                alert.danger('Не все поля заполнены или введён неправильный email');
            }
        });
    });

    addTaskForm.task.addEventListener('input', (ev) => {
        // Если отредактировать и вернуть в исхлдное состояние - засчитает как редактирование
        isTaskEdited.changed = true;
    });
}

if (filtersGroup) {
    filtersGroup.addEventListener('click', (ev) => {
        ev.preventDefault();

        const {nodeName, attributes} = ev.target;
        const {pathname} = location;
        const page = pathname[pathname.length-1];

        if (nodeName === 'BUTTON' && attributes.sort !== undefined) {
            sortQuery(`/tasks/sort/filterBy?field=${attributes.sort.value}&page=${page}`);
        }

        if (nodeName === 'A' && attributes.sort !== undefined) {
            sortQuery(`/tasks/sort/filterBy?type=${attributes.sort.value}&page=${page}`);
        }
    });

    function sortQuery(path) {
        xhr.get(path).then(data => {
            if (data.status === 200) {
                location.reload();
                alert.success('Записи отсортированы');
            } else if (data.status === 400) {
                alert.danger('Не удалось отсортировать');
            }
        });
    }
}

if (loginBtn) {
    loginBtn.addEventListener('click', (ev) => {
        ev.preventDefault();

        const login_form = document.querySelector('.login_form').elements;
        const formData = new FormData();

        formData.append('name', login_form.name.value);
        formData.append('password', login_form.password.value);

        xhr.post('/login/check', formData).then(data => {
            if (data.status === 200) {
                alert.success('Авторизация прошла успешно');
                location.replace('/tasks/1');
            } else if (data.status === 400) {
                alert.danger('Введенные данные не верные');
            }
        });
    });
}

if (editTaskBtn) {
    editTaskBtn.forEach(item => {
        item.addEventListener('click', (ev) => {
            const {firstElementChild} = ev.target.offsetParent;

            addTaskForm.task.value = firstElementChild.querySelector('.tasks_item_text').innerText;
            addTaskForm.email.value = firstElementChild.querySelector('.tasks_item_email').innerText;
            addTaskForm.email.disabled = true;
            addTaskForm.name.value = firstElementChild.querySelector('.tasks_item_name').innerText;
            addTaskForm.name.disabled = true;
            addTaskForm.taskDone.checked = firstElementChild.offsetParent.classList.contains('list-group-item-success');

            isTaskEdited.openToEdit = true;
            isTaskEdited.dataId = ev.target.getAttribute('data-id');
        });
    });
}

if (addTaskOpenModal) {
    addTaskOpenModal.addEventListener('click', (ev) => {
        isTaskEdited.openToEdit = false;

        addTaskForm.task.value = '';
        addTaskForm.email.value = '';
        addTaskForm.email.disabled = false;
        addTaskForm.name.value = '';
        addTaskForm.name.disabled = false;
        addTaskForm.taskDone.checked = false;
    });
}
