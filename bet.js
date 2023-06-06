quote=[];

function onResponse(response){
    return response.json();
}

function onResponse2(response){
    console.log(response);
}

function onJson(json){
    matches=json.matches;
    matches.sort(function(a,b){
        if(a.competition.code<b.competition.code){
            return -1;
        }
        else if(a.competition.code>b.competition.code){
            return 1;
        }
        else{
            return 0;
        }
    });
    length=matches.length;
    let i=0;
    while(i<length){
        competition_code=matches[i].competition.code;
        competition_name=matches[i].competition.name;
        competition_logo=matches[i].competition.emblem;
        let li_competition=document.createElement('li');
        li_competition.classList.add('competition');
        li_competition.addEventListener('click', showMatches);
        let img=document.createElement('img');
        img.src=competition_logo;
        let span=document.createElement('span');
        span.textContent=competition_name;
        li_competition.appendChild(img);
        li_competition.appendChild(span);
        document.querySelector(".matches").appendChild(li_competition);
        let competition_matches=document.createElement('div');
        document.querySelector(".matches").appendChild(competition_matches);
        while((i<length) && (matches[i].competition.code === competition_code)){
            let match=document.createElement('div');
            competition_matches.appendChild(match);
            let li_match=document.createElement('li');
            li_match.classList.add('match');
            let img_home=document.createElement('img');
            img_home.src=matches[i].homeTeam.crest;
            let home_team=document.createElement('span');
            home_team.textContent=matches[i].homeTeam.shortName;
            let date=document.createElement('span');
            date.textContent=matches[i].utcDate;
            let away_team=document.createElement('span');
            away_team.textContent=matches[i].awayTeam.shortName;
            let img_away=document.createElement('img');
            img_away.src=matches[i].awayTeam.crest;
            let data=document.createElement('span');
            data.classList.add('data');
            li_match.appendChild(img_home);
            data.appendChild(home_team);
            data.appendChild(date);
            data.appendChild(away_team);
            li_match.appendChild(data);
            li_match.appendChild(img_away);
            match.appendChild(li_match);

            li_bet=document.createElement('li');
            li_bet.classList.add('bet');
            let odd1=document.createElement('a');
            odd1.href="#";
            odd1.innerHTML="1"+"<br>"+matches[i].odds.homeWin;
            odd1.addEventListener('click', addBet);
            let oddX=document.createElement('a');
            oddX.href="#";
            oddX.innerHTML="X"+"<br>"+matches[i].odds.draw;
            oddX.addEventListener('click', addBet);
            let odd2=document.createElement('a');
            odd2.href="#";
            odd2.innerHTML="2"+"<br>"+matches[i].odds.awayWin;
            odd2.addEventListener('click', addBet);
            li_bet.appendChild(odd1);
            li_bet.appendChild(oddX);
            li_bet.appendChild(odd2);
            match.appendChild(li_bet);
            i++;
        }
    }
}

function showMatches(event){
    competition=event.currentTarget;
    matches=competition.nextElementSibling;
    if(matches.classList.contains('hidden')){
        matches.classList.remove('hidden');
    }
    else{
        matches.classList.add('hidden');
    }
}

function addBet(event){
    event.preventDefault();
    bet_div=document.querySelector('#bet');
    bet_div.classList.remove('hidden');
    if(bet_div.querySelector("h1") === null){
        title=document.createElement('h1');
        title.textContent="La tua schedina";
        bet_div.appendChild(title);
    }
    a=event.currentTarget;
    bet=a.textContent;
    li=a.parentNode;
    info=li.parentNode;
    match=info.querySelector(".match");
    span=match.querySelector("span");
    data=span.querySelectorAll("span");
    home=data[0].textContent;
    date=data[1].textContent;
    away=data[2].textContent;
    if(quote[home] === undefined || quote[home] === null){
        quote[home]=bet.slice(-(bet.length-1));
    }
    else{
        return;
    }
    bet_li=document.createElement('li');
    match_div=document.createElement('div');
    homeTeam=document.createElement('span');
    homeTeam.textContent=home;
    separator=document.createElement('span');
    separator.textContent=" - ";
    awayTeam=document.createElement('span');
    awayTeam.textContent=away;
    match_div.appendChild(homeTeam);
    match_div.appendChild(separator);
    match_div.appendChild(awayTeam);
    bet_li.appendChild(match_div);
    div_stake=document.createElement('div');
    div_stake.textContent="Esito: "+bet.charAt(0)+" - Quota: "+bet.slice(-(bet.length-1));
    bet_li.appendChild(div_stake);
    bet_li.addEventListener('click', removeBet);
    bet_div.appendChild(bet_li);
    if(bet_div.querySelector("button") === null){
        result=document.createElement('div');
        result.classList.add('result');
        total_quote=document.createElement('div');
        total_quote.textContent="Quota totale: "+calculateQuote();
        result.appendChild(total_quote);
        input=document.createElement('input');
        input.id='quota';
        input.type='number';
        input.value=1;
        input.min=1;
        input.name='quota';
        input.addEventListener('change', calculateWin);
        label=document.createElement('label');
        label.textContent="€";
        label.for='quota';
        label.appendChild(input);
        result.appendChild(label);
        win=document.createElement('div');
        win.classList.add('win');
        win.textContent="Vincita: "+(calculateQuote()*input.value).toFixed(2);
        result.appendChild(win);
        bet_div.appendChild(result);
        button=document.createElement('button');
        button.textContent="Conferma";
        button.addEventListener('click', sendBet);
        bet_div.appendChild(button);
    } else{
        button.addEventListener('click', sendBet);
        result.textContent="Quota totale: "+calculateQuote();
        label.appendChild(input);
        result.appendChild(label);
        win.textContent="Vincita: "+(calculateQuote()*input.value).toFixed(2);
        result.appendChild(win);
        bet_div.appendChild(result);
        bet_div.appendChild(button);
    }
}

function removeBet(event){
    event.preventDefault();
    li=event.currentTarget;
    bet_div=document.querySelector('#bet');
    bet_div.removeChild(li);
    if(bet_div.querySelectorAll("li").length === 0){
        toDelete=li.querySelector("span").textContent;
        delete quote[toDelete];
        bet_div.classList.add('hidden');
    }
    else{
        toDelete=li.querySelector("span").textContent;
        delete quote[toDelete];
        result=document.querySelector('.result');
        result.textContent="Quota totale: "+calculateQuote();
        label.appendChild(input);
        result.appendChild(label);
        win.textContent="Vincita: "+(calculateQuote()*input.value).toFixed(2);
        result.appendChild(win);
        bet_div.appendChild(result);
        bet_div.appendChild(button);
        button.addEventListener('click', sendBet);
    }
}

function calculateQuote(){
    let total=1;
    for(let key in quote){
        total*=quote[key];
    }
    return total.toFixed(2);
}

function calculateWin(event){
    win=document.querySelector('.win');
    win.textContent="Vincita: "+(calculateQuote()*input.value).toFixed(2);
}

function sendBet(event){
    event.preventDefault();
    date_bet = new Date().toISOString().slice(0, 10);
    win_bet = document.querySelector('.win').textContent.substring(9);
    win_bet = parseFloat(win_bet);
    const quotation = {};
    const puntata = document.querySelector('#quota').value;
    quotation.puntata = puntata;
    const matches = document.querySelectorAll('#bet li');
    const matches_data = [];
    for (match of matches) {
        const match_data = {};
        const teams = match.querySelectorAll('div span');
        match_data.home_team = teams[0].textContent;
        match_data.away_team = teams[2].textContent;
        quote_divs = match.querySelectorAll('div');
        match_data.bet = quote_divs[1].textContent.charAt(7);
        match_data.odd = quote_divs[1].textContent.slice(-4).trim();
        matches_data.push(match_data);
    }
    matches_data.push(quotation);

    const form_data = new FormData();
    form_data.append('user_id', user_id);
    form_data.append('win', win_bet);
    form_data.append('date_bet', date_bet);
    form_data.append('details', JSON.stringify(matches_data, null, 2));

    fetch("save_bet.php", {method: 'post', body: form_data}).then(onResponse2);
    button=event.currentTarget;
    button.removeEventListener('click', sendBet);
    let counts = document.querySelectorAll('.stat h2');
    let count = counts[1];
    numbets++;
    count.textContent = numbets;
}

fetch("fetch_matches.php").then(onResponse).then(onJson);