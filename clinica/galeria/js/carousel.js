window.onload = function() {
    const state = {};
    const imageList = document.querySelector('.image_list');
    const clinic_images = document.querySelectorAll('.clinic_image');
    const elems = Array.from(clinic_images);


    imageList.addEventListener('click', function(event) {
        var newActive = event.target;
        var isItem = newActive.closest('.clinic_image');

        if (!isItem || newActive.classList.contains('clinic_image_active')) {
            return;
        };

        update(newActive);
    });

    const update = function(newActive) {
        const newActivePos = newActive.dataset.pos;

        const current = elems.find((elem) => elem.dataset.pos == 0);
        const prev = elems.find((elem) => elem.dataset.pos == -1);
        const next = elems.find((elem) => elem.dataset.pos == 1);
        const second = elems.find((elem) => elem.dataset.pos == -2);
        const sec_last = elems.find((elem) => elem.dataset.pos == 2);
        const first = elems.find((elem) => elem.dataset.pos == -3);
        const last = elems.find((elem) => elem.dataset.pos == 3);

        current.classList.remove('clinic_image_active');

        [current, prev, next, second, sec_last, first, last].forEach(item => {
            var itemPos = item.dataset.pos;

            item.dataset.pos = getPos(itemPos, newActivePos)
        });
    };

    const getPos = function(current, active) {
        const diff = current - active;

        if (Math.abs(current - active) > 3) {
            return -current
        }

        return diff;
    }
}