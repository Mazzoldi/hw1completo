function search(event){
    soggetto = event.currentTarget.querySelector("span").textContent;
    window.location.href = "show_news.php?q="+soggetto;
}

function showDetails(event){
    event.currentTarget.nextElementSibling.classList.toggle("hidden");
    for(match of matches){
        if(match != event.currentTarget){
            match.nextElementSibling.classList.add("hidden");
        }
    }
}

favourite_teams = document.querySelectorAll(".favourites .list div li");
for (let i = 0; i < favourite_teams.length; i++){
    favourite_teams[i].addEventListener('click', search);
}
matches = document.querySelectorAll(".matches");
for (let i = 0; i < matches.length; i++){
    matches[i].addEventListener('click', showDetails);
}