document.addEventListener('click', (event) => {

    const trigger = event.target.closest('[data-modal-open]');

    if (trigger) {

        const id = trigger.dataset.modalOpen;
        const modal = document.getElementById(id);

        if (modal instanceof HTMLDialogElement && !modal.open) {
            modal.showModal();
        }

        return;
    }

    const close = event.target.closest('[data-modal-close]');

    if (close) {

        const modal = close.closest('dialog');

        if (modal instanceof HTMLDialogElement) {
            modal.close();
        }

    }

});
