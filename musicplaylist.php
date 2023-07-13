<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MusicPlaylist</title>
        <link rel="stylesheet" href="muiscplaylist.css">
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <header>
            <h2 class="title" style="color: white;">
                <img
                    src="images/logoIcon.png"
                    style="height: 80px; width: 100px; margin-right: 10px;">phiz<span class="spanny">Tune</span>
                <h1 style="color: white;">MUSIC PLAYLIST</h1>
            </h2>
            <nav class="navigation">
                <a href="home.php"><img src="images/homeicon.png" style="height: 2opx; width: 20px;">HOME</a>
                <a href="musicworld.php"><img src="images/loginicon.png" style="height: 2opx; width: 20px;">MUSIC WORLD</a>
                <a href="musicplaylist.php"><img src="images/musiicon.png" style="height: 2opx; width: 20px;">MUSIC PLAYLIST</a>
                <a href="myinfo.html"><img src="images/musiicon.png" style="height: 2opx; width: 20px;">MY INFO</a>
                <a href="aboutus.html"><img src="images/aboutusicon.png" style="height: 2opx; width: 20px;">ABOUT US</a>
            </nav>
        </header>
    </head>
    <body>
        <div class="content1">
            <video
                class="background-video"
                src="videos/bgvideo.mp4"
                autoplay="autoplay"
                muted="muted"
                loop="loop"></video>
            <div class="firstcontainer">
                <div class="search-label">Search Music Here</div>
                <div class="search-container">
                    <form method="GET" action="">
                        <input type="text" name="search" id="search-input" placeholder="Search...">
                        <button type="submit" id="search-button">Search</button>
                    </form>
                </div>
            </div>
        </div>
 
        <div class="song-container">
    <?php
    $folder = 'uploads'; // Replace 'uploads' with the path to your audio files folder
    $files = scandir($folder);

    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

    // Loop through audio files and display matching songs
    foreach ($files as $file) {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (in_array($extension, ['mp3', 'wav', 'ogg'])) {
            $filePath = $folder . '/' . $file;
            $fileName = pathinfo($file, PATHINFO_FILENAME);

            // Perform a case-insensitive search based on the song title
            if (stripos(strtolower($fileName), strtolower($searchQuery)) !== false || empty($searchQuery)) {
                // Generate the HTML audio element with controls and song title
                echo '<div class="song-item">';
                echo "<p class=\"song-title-white\">Song Title: $fileName</p>";
                echo "<img src=\"$folder/$fileName.jpg\" alt=\"$fileName\" width=\"100\" height=\"100\">";
                echo '<audio controls>';
                echo "<source src=\"$filePath\" type=\"audio/$extension\">";
                echo 'Your browser does not support the audio element.';
                echo '</audio>';
                echo '</div>';
            }
        }
    }
    ?>
</div>


        <div class="card-container">
            <div class="card">
                <img src="images/hiphop.jpg" alt="Image 1">
                <div class="card-content">
                    <h3>Hip-Hop/Rap</h3>
                    <p>Hip-hop songs are characterized
                        <br>by their rhythmic beats<br>, lyrical prowess, and
                        <br>expressive delivery,<br>
                        making them a cornerstone
                        <br>of the genre.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/countrymusic.jpg" alt="Image 2">
                <div class="card-content">
                    <h3>Country</h3>
                    <p>Country songs are<br>
                        known for their heartfelt
                        <br>storytelling, capturing the<br>
                        essence of rural life
                        <br>and exploring the simple<br>
                        pleasures of everyday<br>
                        existence.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/jazzmuisc.jpg" alt="Image 3">
                <div class="card-content">
                    <h3>Jazz</h3>
                    <p>Jazz is a genre of
                        <br>music characterized by<br>
                        its improvisational nature,
                        <br>syncopated rhythms, and<br>
                        expressive melodies, often<br>
                        featuring intricate harmonies<br>
                        and virtuosic performances.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/classicalmusic.jpg" alt="Image 3">
                <div class="card-content">
                    <h3>Classical</h3>
                    <p>Classical music is a<br>
                        genre that encompasses a<br>
                        rich heritage of compositions<br>
                        characterized by refined
                        <br>melodies, intricate harmonies,
                        <br>and the use of orchestral<br>
                        instruments.</p>
                </div>
            </div>
            <div class="card">
                <img src="images/r&bmusic.jpg" alt="Image 3">
                <div class="card-content">
                    <h3>R&B/Soul</h3>
                    <p>R&B (Rhythm and Blues) is<br>
                        a genre of music known
                        <br>for its soulful vocals,
                        <br>emotive performances, and
                        <br>a blend of elements from<br>
                        gospel, jazz, and<br>
                        blues, creating a smooth<br>
                        and heartfelt sound that
                        <br>resonates with listeners.</p>
                </div>
            </div>
        </div>

        <script src="musiclistscript.js"></script>
        <script src="musicplaylist.js"></script>
        <script src="https://apis.google.com/js/api.js"></script>
    </body>
</html>