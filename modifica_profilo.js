function checkName(event) {
    const input = event.currentTarget;
    if(formStatus[input.name] = /^[a-zA-Z]+$/.test(input.value)) {
        if (formStatus[input.name] = input.value.length > 0) {
            input.parentNode.classList.remove('errorj');
        } else {
            input.parentNode.classList.add('errorj');
        }
    }
}

function checkSurname(event) {
    const input = event.currentTarget;
    if(formStatus[input.name] = /^[a-zA-Z]+$/.test(input.value)) {
        if (formStatus[input.surname] = input.value.length > 0) {
            input.parentNode.classList.remove('errorj');
        } else {
            input.parentNode.classList.add('errorj');
        }
    }
}

function jsonCheckUsername(json) {
    if (formStatus.username = !json.exists) {
        document.querySelector('.username').classList.remove('errorj');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.username').classList.add('errorj');
    }
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkUsername(event) {
    const input = document.querySelector('.username input');
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
        input.parentNode.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        input.parentNode.classList.add('errorj');
        formStatus.username = false;
    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}

function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password').classList.remove('errorj');
    } else {
        document.querySelector('.password').classList.add('errorj');
    }
}

function checkUpload(event) {
    const upload_original = document.getElementById('upload_original');
    document.querySelector('#upload .file_name').textContent = upload_original.files[0].name;
    const o_size = upload_original.files[0].size;
    const mb_size = o_size / 1000000;
    document.querySelector('#upload .file_size').textContent = mb_size.toFixed(2)+" MB";
    const ext = upload_original.files[0].name.split('.').pop();
    if (o_size >= 7000000) {
        document.querySelector('.fileupload span').textContent = "Le dimensioni del file superano 7 MB";
        document.querySelector('.fileupload').classList.add('errorj');
        formStatus.upload = false;
    } else if (!['jpeg', 'jpg', 'png', 'gif'].includes(ext))  {
        document.querySelector('.fileupload span').textContent = "Le estensioni consentite sono .jpeg, .jpg, .png e .gif";
        document.querySelector('.fileupload').classList.add('errorj');
        formStatus.upload = false;
    } else {
        document.querySelector('.fileupload').classList.remove('errorj');
        formStatus.upload = true;
    }
}

function clickSelectFile(event) {
    upload_original.click();
}

function showImageChoice(event) {
    const upload = document.querySelector('#fileupload');
    if (upload.classList.contains('hidden')) {
       upload.classList.remove('hidden');
    }
    else if (document.getElementById("upload_original").value === ""){
        upload.classList.add('hidden');
    }
}

const formStatus = {'upload': true};
document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('change', checkUsername);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.getElementById('upload').addEventListener('click', clickSelectFile);
document.getElementById('upload_original').addEventListener('change', checkUpload);
document.getElementById('icona_modifica').addEventListener('click', showImageChoice);