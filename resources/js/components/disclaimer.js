class Disclaimer {

    constructor(element) {

        this.element = element;

        this.button = element.querySelector(
            '[data-disclaimer-accept]'
        );

        this.duration = Number(
            element.dataset.disclaimerDuration
        ) || 10;

        this.version = element.dataset.disclaimerVersion;

        this.storageKey = `disclaimer:accepted:${this.version}`;

        this.remaining = this.duration;

        this.bindEvents();

        if (!this.isAccepted()) {
            this.show();
        }

    }

    isAccepted() {

        try {
            return localStorage.getItem(this.storageKey) === 'true';
        } catch {
            return false;
        }

    }

    show() {

        this.element.showModal();

        this.button.disabled = true;

        this.updateButton();

        this.timer = setInterval(() => {

            this.remaining--;

            this.updateButton();

            if (this.remaining <= 0) {
                clearInterval(this.timer);
            }

        }, 1000);

    }

    updateButton() {

        if (this.remaining > 0) {

            this.button.textContent =
                `Li e estou ciente (${this.remaining}s)`;

            this.button.disabled = true;

        } else {

            this.button.textContent = 'Li e estou ciente';

            this.button.disabled = false;

        }

    }

    bindEvents() {

        this.element.addEventListener('cancel', event => {

            event.preventDefault();

        });

        this.button.addEventListener('click', () => {

            this.accept();

        });

    }

    accept() {

        if (this.remaining > 0) {
            return;
        }

        try {
            localStorage.setItem(this.storageKey, 'true');
        } catch {
            // Permite continuar caso o armazenamento esteja indisponível.
        }

        clearInterval(this.timer);

        this.element.close();

    }

}

document.querySelectorAll('[data-disclaimer]').forEach(element => {

    new Disclaimer(element);

});
