document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('#wrapper');

    document.addEventListener('click', (event) => {
        if (! event.target.matches('.list')) {
            return;
        }

        event.preventDefault();
        wrapper.classList.add('list');
    });

    document.addEventListener('click', (event) => {
        if (! event.target.matches('.grid')) {
            return;
        }

        event.preventDefault();
        wrapper.classList.remove('list');
    });

    document.querySelectorAll('[data-character-id="yes"]').forEach(characterButton => {
        characterButton.addEventListener('click', (event) => {
            window.location = `/character/${event.currentTarget.dataset.id}`;
        })
    })
});