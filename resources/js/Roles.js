import {Ajax} from "./Ajax";
import {toast} from "./src/toast"

class Roles extends Ajax {
    static removeData = {};
    constructor() {
        const status = document.querySelectorAll('.edit-roles');
        const remove = document.querySelectorAll('.remove__voles');

        const removeButton = document.querySelector('.roleButtonRemove')

        if (remove) {
            remove.forEach(function (item) {
                item.addEventListener("click", function () {
                    Roles.removeData = this.parentElement.parentNode;

                    new bootstrap.Modal(document.getElementById('remove-model')).show();
                });
            });
            if (removeButton) {
                removeButton.addEventListener("click", function (el) {
                    Roles.remove(Roles.removeData)
                });
            }
        }

        if (status) {
            status.forEach(function (item) {
                item.addEventListener("click", function (el) {
                    Roles.status(this.parentElement.parentNode, el)
                });
            });
        }
        super();
    }


    static remove(el) {
        this.post('/telegram/roles/remove', this.formData({
            id: el.dataset.roleId ?? 0
        }), {
            onDone: function (result) {
                if (result.messages) {
                    toast('Отлично', result.messages);
                }
                Roles.removeData = {};
                el.remove();
            },
            onFail: function (error) {
                toast('Ошибка', error.messages);
            }
        });
    }

    static status(parent, element) {
        let classes = {
            0: 'bg-secondary',
            1: 'bg-success',
        }
        this.post('/telegram/roles/edit', this.formData({
            id: parent.dataset.roleId ?? 0,
            status: element.target.dataset.statusId ?? 0
        }), {
            onDone: function (result) {
                if (result.messages) {
                    toast('Отлично', result.messages);
                }
                parent.children[7].children[1].remove();
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
new Roles();
