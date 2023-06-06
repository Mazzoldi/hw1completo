fetch_news();

function fetch_news(){
  let subject = '';
  if (favourites.length !== 0){
    for(let i=0; i<favourites.length; i++){
      subject += favourites[i];
      if(i !== favourites.length-1){
        subject += ' OR ';
      }
    }
    fetch("fetch_news.php?q="+encodeURIComponent(subject)).then(onResponse).then(onJSON);
  }
  else{
    subject = 'calcio';
    fetch("fetch_news.php?q="+encodeURIComponent(subject)).then(onResponse).then(onJSON);
  }
}

function search(event){
  event.preventDefault();
  soggetto = document.querySelector("#input_search").value;
  window.location.href = "show_news.php?q="+soggetto;
}

function onResponse(response){
  return response.json();
}

function onJSON(json){
  const resultsContainer = document.getElementById('results');
  const title = document.getElementById('query');
  title.textContent = 'Risultati per i tuoi preferiti';
  resultsContainer.innerHTML = '';
  articles = json.articles;
  if(json.totalResults === 0){
    const noResult = document.createElement('h1');
    noResult.textContent = 'Nessun risultato';
    resultsContainer.appendChild(noResult);
  }
  else{
    for(article of articles){
      const articleElement = document.createElement('div');
      articleElement.classList.add('articolo');
      const imageElement = document.createElement('img');
      if(article.urlToImage !== null){
        imageElement.setAttribute('src', article.urlToImage);
      } else{
        imageElement.setAttribute('src', 'assets/news-placeholder.jpg');
      }
      articleElement.appendChild(imageElement);

      const linkElement = document.createElement('a');
      linkElement.setAttribute('href', article.url);
      linkElement.textContent = article.title;
      linkElement.textContent = linkElement.textContent.slice(0, 150);
      articleElement.appendChild(linkElement);

      const textElement = document.createElement('p');
      textElement.textContent = article.description;
      textElement.textContent = textElement.textContent.slice(0, -3);
      textElement.textContent += '...';
      articleElement.appendChild(textElement);
        
      resultsContainer.appendChild(articleElement);
    }
  }
}

function onSaveTeamsJSON(json){
  console.log(json);
}

document.querySelector("#search form").addEventListener("submit", search);

/* function onSaveTeamsJSON(json){
  console.log(json);
  let competition_code = json.competition.code;
  let competition_name = json.competition.name;
  let teams = json.teams;
  for(team of teams){
    let team_id = team.id;
    let team_name = team.shortName;
    let team_short_name = team.tla;
    let team_logo_file_path = team.crest;

    const form_data = new FormData();
    form_data.append('team_competition_code', competition_code);
    form_data.append('team_competition_name', competition_name);
    form_data.append('team_id', team_id);
    form_data.append('team_name', team_name);
    form_data.append('team_short_name', team_short_name);
    form_data.append('team_logo_file_path', team_logo_file_path);
    
    fetch("save_teams.php", {method: 'post', body: form_data}).then(onResponse2);
  }
}

function onResponse2(response){
  console.log(response);
}

fetch("fetch_teams.php").then(onResponse).then(onSaveTeamsJSON); */