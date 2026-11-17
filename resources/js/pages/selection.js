document.querySelectorAll('[data-selection-form]').forEach(form => {

    const buttons = form.querySelectorAll(
        '[data-selection-submit]'
    );

    function updateButtons(count) {

        buttons.forEach(button => {
            button.disabled = count < 1;
        });

    }

    form.addEventListener('selection:change', event => {

        updateButtons(event.detail.count);

    });

    const initialCount = form.querySelectorAll(
        'input[name="drug_ids[]"]:not(:disabled)'
    ).length;

    updateButtons(initialCount);

});
