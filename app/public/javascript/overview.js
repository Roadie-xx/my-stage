document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('#wrapper');

    document.addEventListener('click', (event) => {
        if (! event.target.matches('.list')) {
            return;
        }

        // List view
        event.preventDefault();
        wrapper.classList.add('list');
    });

    document.addEventListener('click', (event) => {
        if (! event.target.matches('.grid')) {
            return;
        }

        // List view
        event.preventDefault();
        wrapper.classList.remove('list');
    });
});