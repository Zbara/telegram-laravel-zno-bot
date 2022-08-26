import {Ajax} from "./Ajax";
import {toast} from "./src/toast"

class Videos extends Ajax {
    static removeData = {};
    constructor() {
        const status = document.querySelectorAll('.status_video');
        const remove = document.querySelectorAll('.remove__videos');

        const removeButton = document.querySelector('.videosButtonRemove')

        if (remove) {
            remove.forEach(function (item) {
                item.addEventListener("click", function () {
                    Videos.removeData = this.parentElement.parentNode;

                    new bootstrap.Modal(document.getElementById('remove-model')).show();
                });
            });
            if (removeButton) {
                removeButton.addEventListener("click", function (el) {
                    Videos.remove(Videos.removeData)
                });
            }
        }

        if (status) {
            status.forEach(function (item) {
                item.addEventListener("click", function (el) {
                    Videos.status(this.parentElement.parentNode, el)
                });
            });
        }
        super();
    }


    static remove(el) {
        this.post('/telegram/video/remove', this.formData({
            id: el.dataset.videoId ?? 0
        }), {
            onDone: function (result) {
                if (result.messages) {
                    toast('Отлично', result.messages);
                }
                Videos.removeData = {};
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
        this.post('/telegram/video/status', this.formData({
            id: parent.dataset.videoId ?? 0,
            status: element.target.dataset.statusId ?? 0
        }), {
            onDone: function (result) {
                if (result.messages) {
                    toast('Отлично', result.messages);
                }
                parent.children[7].children[0].classList.remove(parent.children[7].children[0].classList[2]);
                parent.children[7].children[0].classList.add(classes[element.target.dataset.statusId]);
                parent.children[7].childNodes[2].textContent = result.text;
            },
            onFail: function (error) {
                toast('Ошибка', error.messages);
            }
        });
    }
}
new Videos();
