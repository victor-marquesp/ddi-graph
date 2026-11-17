const toggle = document.querySelector('[data-navbar-toggle]');
const navigation = document.querySelector('[data-navbar-navigation]');

if (toggle && navigation) {

    toggle.addEventListener('click', () => {

        const open = navigation.classList.toggle(
            'navbar__navigation--open'
        );

        toggle.setAttribute('aria-expanded', String(open));

    });

}

document.querySelectorAll('.navbar__dropdown').forEach(dropdown => {

    document.addEventListener('click', event => {

        if (!dropdown.contains(event.target)) {
            dropdown.open = false;
        }

    });

    dropdown.addEventListener('keydown', event => {

        if (event.key === 'Escape' && dropdown.open) {

            dropdown.open = false;
            dropdown.querySelector('summary')?.focus();

        }

    });

});
