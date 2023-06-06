function wait(event){
    setTimeout(hideTeams, 100);
}

function hideTeams(){
    for (let i = 0; i < teams.length; i++){
        teams[i].classList.add('hidden');
    }
}

function searchTeams(event){
    const input = event.currentTarget;
    lenght = input.value.length;
    for (let i = 0; i < teams.length; i++){
        if (teams[i].textContent.toLowerCase().indexOf(input.value.toLowerCase()) !== -1 && lenght > 0){
            teams[i].classList.remove('hidden');
        } else{
            teams[i].classList.add('hidden');
        }
    }
}

function addFavourite(event){
    document.querySelector('.favourites .list div').classList.remove('hidden');
    document.querySelector('#noresults').classList.add('hidden');
    document.querySelector('#search_teams').value = "";
    for (let i = 0; i < teams.length; i++){
        teams[i].classList.add('hidden');
    }
    const logo = document.createElement('img');
    logo.src = event.currentTarget.querySelector('img').src;
    const team = document.createElement('li');
    const nome = document.createElement('span');
    nome.textContent = event.currentTarget.textContent;
    team.addEventListener('click', removeFavourite);
    team.appendChild(logo);
    team.appendChild(nome);
    const favourites = document.querySelectorAll('.favourites li');
    let i = 0;
    while (i < favourites.length && favourites[i].querySelector("span").textContent < event.currentTarget.textContent){
        i++;
    }
    if (i === favourites.length){
        document.querySelector('.favourites .list div').appendChild(team);
        const data = new FormData();
        data.append('team_name', event.currentTarget.textContent);
        data.append('username', username);
        fetch("save_favourites.php", {method: "POST", body: data});
    }
    else if (favourites[i].querySelector("span").textContent === event.currentTarget.textContent){
        return;
    }
    else{
        document.querySelector('.favourites .list div').insertBefore(team, favourites[i]);
        const data = new FormData();
        data.append('team_name', event.currentTarget.textContent);
        data.append('username', username);
        fetch("save_favourites.php", {method: "POST", body: data});
    }
    let count = document.querySelector('.stat h2');
    numfavourites++;
    count.textContent = numfavourites;
}

function onResponse(response){
    return response.json();
}

function onJsonCount(json){
    const count = document.querySelector('.stat h2');
    count.textContent = json;
}

function removeFavourite(event){
    const data = new FormData();
    data.append('team_name', event.currentTarget.textContent);
    data.append('username', username);
    fetch("remove_favourites.php", {method: "POST", body: data});
    event.currentTarget.remove();
    if (document.querySelectorAll('.favourites li').length === 0){
        document.querySelector('.favourites .list div').classList.add('hidden');
        document.querySelector('#noresults').classList.remove('hidden');
    }
    let count = document.querySelector('.stat h2');
    numfavourites--;
    count.textContent = numfavourites;
}

document.querySelector('#search_teams').addEventListener('blur', wait);
document.querySelector('#search_teams').addEventListener('keydown', searchTeams);
document.querySelector('#search_teams').addEventListener('keyup', searchTeams);
teams = document.querySelectorAll(".menu li");
for (let i = 0; i < teams.length; i++){
    teams[i].addEventListener('click', addFavourite);
}
favourite_teams = document.querySelectorAll(".favourites li");
for (let i = 0; i < favourite_teams.length; i++){
    favourite_teams[i].addEventListener('click', removeFavourite);
}