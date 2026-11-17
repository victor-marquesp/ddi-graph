class DrugSelector {

    constructor(element) {

        this.element = element;

        this.availableList = element.querySelector(
            '[data-available-list]'
        );

        this.selectedList = element.querySelector(
            '[data-selected-list]'
        );

        this.search = element.querySelector('[data-drug-search]');

        this.items = Array.from(
            element.querySelectorAll('[data-drug-id]')
        );

        this.addAllButton = element.querySelector('[data-add-all]');
        this.removeAllButton = element.querySelector('[data-remove-all]');

        this.bindEvents();
        this.render();

    }

    bindEvents() {

        this.search.addEventListener('input', () => {
            this.render();
        });

        this.element.addEventListener('click', (event) => {

            const add = event.target.closest('[data-drug-add]');
            const remove = event.target.closest('[data-drug-remove]');

            if (add || remove) {

                const item = (add || remove).closest('[data-drug-id]');

                this.setSelected(item, Boolean(add));
                this.render();

            }

        });

        this.addAllButton.addEventListener('click', () => {

            for (const item of this.getAvailable()) {

                if (this.matchesSearch(item)) {
                    this.setSelected(item, true);
                }

            }

            this.render();

        });

        this.removeAllButton.addEventListener('click', () => {

            for (const item of this.getSelected()) {
                this.setSelected(item, false);
            }

            this.render();

        });

    }

    normalize(value) {

        return value
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .trim();

    }

    matchesSearch(item) {

        const name = this.normalize(item.dataset.drugName);
        const query = this.normalize(this.search.value);

        return name.includes(query);

    }

    isSelected(item) {
        return item.dataset.selected === 'true';
    }

    setSelected(item, selected) {
        item.dataset.selected = String(selected);
    }

    getSelected() {
        return this.items.filter(item => this.isSelected(item));
    }

    getAvailable() {
        return this.items.filter(item => !this.isSelected(item));
    }

    render() {

        let visibleAvailable = 0;

        for (const item of this.items) {

            const selected = this.isSelected(item);

            const add = item.querySelector('[data-drug-add]');
            const remove = item.querySelector('[data-drug-remove]');
            const input = item.querySelector('input[type="hidden"]');

            add.hidden = selected;
            remove.hidden = !selected;
            input.disabled = !selected;

            if (selected) {

                item.hidden = false;
                this.selectedList.append(item);

            } else {

                const visible = this.matchesSearch(item);

                item.hidden = !visible;
                this.availableList.append(item);

                if (visible) {
                    visibleAvailable++;
                }

            }

        }

        const selectedCount = this.getSelected().length;
        const availableCount = this.getAvailable().length;

        this.element.querySelector('[data-available-count]')
            .textContent = `${availableCount} medicamentos`;

        this.element.querySelector('[data-selected-count]')
            .textContent = `${selectedCount} medicamentos`;

        this.element.querySelector('[data-selection-summary]')
            .textContent =
                `${selectedCount} de ${this.items.length} medicamentos selecionados.`;

        const availableEmpty = visibleAvailable === 0;
        const selectedEmpty = selectedCount === 0;

        this.element.querySelector('[data-available-empty]')
            .hidden = !availableEmpty;

        this.element.querySelector('[data-selected-empty]')
            .hidden = !selectedEmpty;

        this.availableList.hidden = availableEmpty;
        this.selectedList.hidden = selectedEmpty;

        this.addAllButton.disabled = availableEmpty;
        this.removeAllButton.disabled = selectedEmpty;

        this.element.dispatchEvent(new CustomEvent('selection:change', {
            bubbles: true,
            detail: {
                count: selectedCount,
                ids: this.getSelected().map(item => item.dataset.drugId)
            }
        }));

    }

}

document.querySelectorAll('[data-drug-selector]').forEach(element => {
    new DrugSelector(element);
});
