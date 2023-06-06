fetch("fetch_news.php?q="+encodeURIComponent(query)).then(onResponse).then(onJSON);

function search(event){
  event.preventDefault();
  query = document.querySelector("#input_search").value;
  fetch("fetch_news.php?q="+encodeURIComponent(query)).then(onResponse).then(onJSON);
}
  
function onResponse(response){
  console.log(response);
  return response.json();
}
  
function onJSON(json){
  console.log(json);
  const resultsContainer = document.getElementById('results');
  const title = document.getElementById('query');
  title.textContent = 'Risultati per: ' + query;
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

document.querySelector("#search form").addEventListener("submit", search);