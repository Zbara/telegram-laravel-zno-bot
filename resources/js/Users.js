import {Ajax} from "./Ajax";
import {toast} from "./src/toast"

class Users extends Ajax {
    static removeData = {};
    constructor() {
        const status = document.querySelectorAll('.status_user');
        const filter = document.querySelector('.filterData');
        const resetFilter = document.querySelector('.reset__filter');

        if (filter) {
            filter.addEventListener('submit', (event, form) => {
                event.preventDefault();

                Users.filter(event);
            });
        }
        if (resetFilter) {
            resetFilter.addEventListener('click', (event, form) => {
                event.preventDefault();

                Users.filterClear(event);
            });
        }

        if (status) {
            status.forEach(function (item) {
                item.addEventListener("click", function (el) {
                    Users.status(this.parentElement.parentNode, el)
                });
            });
        }
        super();
    }

    static filter(el) {
        let formData = new FormData(el.target);
        let table = document.querySelector('#userFilter');
        let tableOld = document.querySelector('#users');

        this.post('/telegram/users/filter', formData, {
            onDone: function (result) {
                table.innerHTML = '';
                table.classList.remove('d-none');
                tableOld.classList.add('d-none');

                table.insertAdjacentHTML(
                    "afterbegin", result.filter);
            },
            onFail: function (error) {
                toast('Ошибка', error.messages);
            }
        });
    }

    static filterClear(event) {
        document.querySelector('#userFilter').classList.add('d-none');
        document.querySelector('#users').classList.remove('d-none');
        document.querySelectorAll('input[name]').forEach(function (el,i) {
            if(el.type === 'checkbox'){
                el.checked = false;
            }
        })
    }

    static status(parent, element) {
        let classes = {
            0: 'bg-secondary',
            1: 'bg-success',
        }
        this.post('/telegram/users/status', this.formData({
            id: parent.dataset.usersId ?? 0,
            status: element.target.dataset.statusId ?? 0
        }), {
            onDone: function (result) {
                if (result.messages) {
                    toast('Отлично', result.messages);
                }
                parent.children[6].children[0].classList.remove(parent.children[6].children[0].classList[2]);
                parent.children[6].children[0].classList.add(classes[element.target.dataset.statusId]);
                parent.children[6].childNodes[2].textContent = result.text;
            },
            onFail: function (error) {
                toast('Ошибка', error.messages);
            }
        });
    }
}
new Users();
