var nextPageButton = document.getElementById('next-page-button');
nextPageButton.addEventListener('click', function() {
  // Redirect to the login page
  window.location.href = 'tryme.php';
});

var nextPageButton = document.getElementById('button-login');
nextPageButton.addEventListener('click', function() {
  // Redirect to the login page
  window.location.href = 'login.html';
});


    const logoutButton = document.getElementById("button-logout");
    logoutButton.addEventListener("click", logout);

    function logout() {
      
        
        fetch("/logout", {
            method: "POST",
            credentials: "same-origin" 
        })
        .then(response => {
            if (response.ok) {
                
                window.location.href = "login.html";
            } else {
                
                console.error("Logout failed.");
            }
        })
        .catch(error => {
            
            console.error("Logout failed.", error);
        });
    }




    