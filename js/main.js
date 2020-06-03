const addTaskBtn = document.getElementById('addTaskBtn');

const filtersGroup = document.getElementById('filtersGroup');

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
    
        const addTaskForm = document.getElementById('add_new_task_form').elements;
        const formData = new FormData();

        formData.append('name', addTaskForm.name.value);
        formData.append('email', addTaskForm.email.value);
        formData.append('task', addTaskForm.task.value);

        xhr.post('/tasks/add', formData).then(data => {
            if (data.status === 200) {
                location.reload();
                alert.success('Запись успешно добавлена');
            } else if (data.status === 400) {
                alert.danger('Не все поля заполнены или введён неправильный email');
            }
        });
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

