
let characters;		
let episodes;		
let locations; 

await fetch('/data/characters.json')
    .then(response => response.json())
    .then(json => {
        characters = json;
        characters = characters.map(item => ({ ...item, type: 'character' }));
    });

await fetch('/data/episodes.json')
    .then(response => response.json())
    .then(json => {
        episodes = json;
        episodes = episodes.map(item => ({ ...item, type: 'episode' }));
    });

await fetch('/data/locations.json')
    .then(response => response.json())
    .then(json => {
        locations = json;
        locations = locations.map(item => ({ ...item, type: 'location' }));
    });

console.log(' Ready loading');

const handleToggle = (selector) => {
    const label = document.querySelector(`[for="${selector}"]`);
    label.classList.toggle('btn-outline-success');
    label.classList.toggle('btn-outline-danger');
    label.classList.toggle('active');
}

document.querySelectorAll('.btn-group > .btn').forEach(button => {
    button.classList.toggle('active', true);

    let id = button.getAttribute('for');
    document.querySelector(`#${id}`).checked = true;
    
    button.addEventListener('click', (event) => {
        handleToggle(event.currentTarget.getAttribute('for'));
        
        setTimeout(() => {
            buildChoices();

            document.querySelector('.list-group').innerHTML = '';
            listItemGenerator();
        }, 10);

    });
});

let choices;

const buildChoices = () => {
    choices = [];

    if (document.querySelector('#search-characters').checked === true) {
        choices.push(...characters);
    }
    if (document.querySelector('#search-episodes').checked === true) {
        choices.push(...episodes);
    }
    if (document.querySelector('#search-locations').checked === true) {
        choices.push(...locations);
    }

    console.log(' Ready building choices', choices.length);
}

buildChoices();

const icons = {
    'character' : '<i class="bi bi-person-fill"></i>',
    'dimension' : '<i class="bi bi-stars"></i>',
    'episode' : '<i class="bi bi-film"></i>',
    'location' : '<i class="bi bi-geo-alt-fill"></i>',
};	

const listGroup = document.querySelector('.list-group');
const search = document.querySelector('#search');

const creatingList = (items) => {
let createdList = items.map((item) => {
    // Add icon and id
    return `<li>${icons[item.type]} ${item.name}</li>`;
});

let customListItem;

if (!createdList.length) {
    customListItem = `<div>Oops...not found '${search.value}'</div>`;
} else {
    customListItem = createdList.join('');
}

listGroup.innerHTML = customListItem;

completeText();
}

const completeText = () => {
listGroup.querySelectorAll('li').forEach((list) => {
    list.addEventListener('click', (event) => {
    console.log(event);
        search.value = event.currentTarget.textContent.trim();
        listGroup.style.display = 'none';
    });
});
}

const hideSuggestions = () => {
search.parentElement.classList.remove('active');
listGroup.style.display = 'none';
}

const listItemGenerator = () => {
if (! search.value) {
    hideSuggestions();
} else {
    search.parentElement.classList.add('active');
    listGroup.style.display = 'block';

    let searchResults = choices.filter((choice) => {
        return choice.name.toLowerCase().startsWith(search.value.toLowerCase());
    });

    creatingList(searchResults);
}
}

search.addEventListener("keyup", listItemGenerator);
search.addEventListener("focus", listItemGenerator);
document.addEventListener("click", (event) => {
if (!event.target.closest('.list-group') && !event.target.closest('.suggest-group')) {
    hideSuggestions();
}
});




document.querySelectorAll('#random-search button').forEach(button => {
const source = button.getAttribute('data-source');
const data = eval(source); // Bah...

const randomChoice = data[Math.floor(Math.random() * data.length)];

button.innerHTML = `${icons[randomChoice.type]} ${randomChoice.name}`;
});