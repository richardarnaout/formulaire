document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    // Récupérer les valeurs du formulaire
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    // Préparer les données pour l'envoi
    let formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    // Cacher la réponse précédente
    let responseDiv = document.getElementById('response');
    responseDiv.style.display = 'none';
    
    // Envoi de la requête 
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // La réponse du serveur
    .then(data => {
        // Afficher la réponse du serveur dans le div #response
        responseDiv.innerHTML = data;
        responseDiv.style.display = 'block'; // Afficher le message

        // Appliquer le style de succès ou d'erreur
        if (data.includes('succès')) {
            responseDiv.className = 'success';
        } else {
            responseDiv.className = 'error';
        }
    })
    .catch(error => {
        // Gérer les erreurs 
        responseDiv.innerHTML = 'Une erreur est survenue!';
        responseDiv.style.display = 'block';
        responseDiv.className = 'error';
    });
});
