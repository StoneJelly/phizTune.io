<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FYPDFT50114</title>

        
        <link rel="stylesheet" href="home.css">

    </head>
    <body>
        <!-- <div class="splash-screen"> <div class="splash-content"> <object
        data="welcome.html" type="text/html"></object> </div> </div> <script
        src="script.js"></script> -->

        <input type="checkbox" id="check">

        <label for="check">
            <img src="images/menubar.png" id="btn" style="height: 30px; height: 30px;">
            <img src="images/cancel.png" id="cancel" style="height: 30px; height: 30px;">
        </label>

        <div class="sidebar">
            <header>phizTune<img src="images/logoIcon.png" style="height: 50px; width: 50px;"></header>
            

            <ul>
                <li>
                    <a href="home.html"><img src="images/homeicon.png" style="height: 2opx; width: 20px;">HOME</a>
                </li>

                <li>
                    <a href="musicworld.php"><img src="images/musiicon.png" style="height: 2opx; width: 20px;">MUSIC WORLD</a>
                </li>
                <li>
                    <a href="musicplaylist.php"><img src="images/playlisticon.png" style="height: 2opx; width: 20px;">MUSIC PLAYLIST</a>
                </li>
                <li>
                    <a href="myinfo.php"><img src="images/infoicon.png" style="height: 2opx; width: 20px;">MY INFO</a>
                </li>
                <li>
                    <a href="aboutus.html"><img src="images/aboutusicon.png" style="height: 2opx; width: 20px;">ABOUT US</a>
                </li>
                
            </ul>

        </div>

        <section>

            <div class="logo">

                <img
                    src="images/logoIcon.png"
                    style="width: 80px; height: 80px; border-radius: 20px; padding-top: 2px;">
                <div class="button-container">

                   <img src="images/user_icon.png" alt="" style="height: 50px; width: 50px;" id="user" onclick="toggleMenu()">
                   
                   <div class="sub-menu-wrap" id="subMenu">
                    <div class="sub-menu">
                    <div class="user-info">
                        <h2><?php echo $_SESSION['email']; ?></h2><br>
                        
                    </div>
                    <div class="user_age">
                    <h2>Age : <?php echo $_SESSION['age']; ?></h2><br>
                    </div>
                        <hr>
                        <a href="#" class="sub-menu-link" onclick="logout()">
                            <img src="images/logout_icon.png" style="height: 30px; width: 30px;">
                            <button type="button" >Logout</button>
                            <span></span>
                        </a>

                    </div>
                   </div>
                   <!-- <script src="homescript.js"></script> -->

 
                </div>
            </div>

        </section>
        <div class="maincontent">

            <div class="mainImage">
                <img src="images/bg.jpg" style="width: 400px; height: 450px;">
                <div class="content">

                    <h1>phizTune Platform</h1><br>
                    <p>Music is a powerful universal language that evokes emotions, connects people,
                        and enhances well-being. Enjoying songs provides personal and subjective
                        experiences, allowing us to relax, express ourselves, and find solace. It has
                        physical benefits, reduces stress, and improves cognitive function. Music is a
                        joyful journey of self-discovery.</p><br><br>

                    <h2>
                        Songs are the soul's melody.</h2><br><br><br>

                    <button class="glow-button" id="next-page-button">GET STARTED</button>
                    <!-- <script src="homescript.js"></script> -->

                </div>

            </div>

        </div>
        <div class="maincontent2">
            <div class="container">
                <div class="box">
                    <img src="images/listenmusic1.jpg" alt="Car 1">
                    <div class="description">
                        <h3>The Power Of Music?</h3>
                        <p>Music is a universal language that has the ability to touch our hearts,
                            inspire emotions, and connect people from different backgrounds. It plays a
                            significant role in our lives, offering various benefits and enhancing our
                            overall well-being.</p>
                    </div>
                </div>
                <div class="box">
                    <img src="images/listenmusic2.jpg" alt="Car 2">
                    <div class="description">
                        <h3>The Evolution Of Music Genres</h3>
                        <p>Music genres have evolved over time, reflecting societal changes,
                            technological advancements, and cultural shifts. Each genre carries its unique
                            characteristics, influences, and impact on listeners, shaping popular culture
                            and leaving a lasting musical legacy</p>
                    </div>
                </div>
                <div class="box">
                    <img src="images/listenmusic3.jpg" alt="Car 3">
                    <div class="description">
                        <h3>The Roles of Music
                        </h3>
                        <p>Music has a profound impact on personal development, fostering creativity,
                            enhancing cognitive abilities, and promoting self-expression. It serves as an
                            outlet for emotions, a source of inspiration, and a tool for personal growth and
                            exploration.</p>
                    </div>
                </div>

            </div>


 
 <script>
    // Retrieve session values from PHP
    var nextPageButton = document.getElementById('next-page-button');
    nextPageButton.addEventListener('click', function() {
    // Redirect to the login page
    window.location.href = 'musicworld.html';
    });

    var nextPageButton = document.getElementById('button-login');
    nextPageButton.addEventListener('click', function() {
    // Redirect to the login page
    window.location.href = 'login.html';
    });

    const logoutButton = document.getElementById("button-logout");
    logoutButton.addEventListener("click", logout);


    function toggleMenu() {
        console.log("Toggle menu function called");
        var subMenu = document.getElementById("subMenu");
        subMenu.classList.toggle("open-menu");
    }

    function logout() {
        // Use AJAX to call the logout.php script to destroy the session and redirect
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Redirect to login.html after the session is destroyed
                window.location.replace("index.html");
            }
        };
        xhttp.open("GET", "logout.php", true);
        xhttp.send();
    }
  </script>
 </body>
    
</html>

<script>
    // Retrieve session values from PHP
    var email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>";
    var age = "<?php echo isset($_SESSION['age']) ? $_SESSION['age'] : '' ?>";
    var genre = "<?php echo isset($_SESSION['genre']) ? $_SESSION['genre'] : '' ?>";
    var date = "<?php echo isset($_SESSION['login_date']) ? $_SESSION['login_date'] : '' ?>";
    var name = "<?php echo isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '' ?>";
    
    // Display session values in an alert box
    alert("Email: " + email +  "\nAge: " + age + "\nGenre: " + genre + "\nDate: " + date  + "\nName: " + name);
</script>

