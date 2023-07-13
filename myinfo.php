<?php
session_start();
require("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Info</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="myinfo.css">


    <header>
        <h2 class="title" style="color: white;">
            <img src="images/logoIcon.png" style="height: 80px; width: 100px; margin-right: 10px;">phiz<span class="spanny">Tune</span>
            <h1 style="color: white;">MY INFO</h1>
        </h2>
        <nav class="navigation">
            <a href="home.php"><img src="images/homeicon.png" style="height: 2opx; width: 20px;">HOME</a>
            <a href="musicworld.php"><img src="images/loginicon.png" style="height: 2opx; width: 20px;">MUSIC WORLD</a>
            <a href="musicplaylist.php"><img src="images/musiicon.png" style="height: 2opx; width: 20px;">MUSIC PLAYLIST</a>
            <a href="myinfo.php"><img src="images/musiicon.png" style="height: 2opx; width: 20px;">MY INFO</a>
            <a href="aboutus.html"><img src="images/aboutusicon.png" style="height: 2opx; width: 20px;">ABOUT US</a>
        </nav>
    </header>
    
 
</head>
<body>
    <div class="table-container">

    <?php
    
    $email = $_SESSION['email'];
    
    // Table 1: Emotion Counts
    $emotions = array("Happy", "Sad", "Angry", "Tear", "Surprised", "Disgust");
    $emotionSql = "SELECT emotion, COUNT(*) as count FROM emotions WHERE email = '$email' AND emotion IN ('" . implode("','", $emotions) . "') GROUP BY emotion";
    $emotionResult = $conn->query($emotionSql);
  
    if ($emotionResult->num_rows > 0) {
        echo "<table class='emotion-table'>";
        echo "<tr><th>Emotion</th><th>Count</th></tr>";

        $dominantEmotion = '';
        $highestCount = 0;
        
        while ($emotionRow = $emotionResult->fetch_assoc()) {
            $emotion = $emotionRow["emotion"];
            $count = $emotionRow["count"];
            echo "<tr>";
            echo "<td>" . $emotion . "</td>";
            echo "<td>" . $count . "</td>";
            echo "</tr>";

            if ($count > $highestCount) {
                $highestCount = $count;
                $dominantEmotion = $emotion;
            }
        }
        echo "</table>";

        // Display message for the dominant emotion
        if ($dominantEmotion != '') {
            echo "<p class='message'>Your dominant emotion is: " . $dominantEmotion . "</p>";
            
            // Display specific message based on the dominant emotion
            if ($dominantEmotion == "Happy") {
                echo "<p class='message'>Your mental health is great!</p>";
            } elseif ($dominantEmotion == "Sad") {
                echo "<p class='message'>You should consider visiting a psychologist.</p>";
            } elseif ($dominantEmotion == "Angry") {
                echo "<p class='message'>You should find ways to calm down in life.</p>";
            } elseif ($dominantEmotion == "Disgust") {
                echo "<p class='message'>You should find ways to calm down in life.</p>";
            } elseif ($dominantEmotion == "Surprised") {
                echo "<p class='message'>You should find ways to calm down in life.</p>";
            } elseif ($dominantEmotion == "Tear") {
                echo "<p class='message'>You should find ways to calm down in life.</p>";
            } elseif ($dominantEmotion == "Neutral") {
                echo "<p class='message'>You should find ways to calm down in life.</p>";
            }
        }
    } else {
        echo "No data found for the email: $email";
    }
  
    $emotionSql = "SELECT emotion, COUNT(*) as count FROM emotions WHERE email = '$email' AND emotion IN ('" . implode("','", $emotions) . "') GROUP BY emotion";
    $emotionResult = $conn->query($emotionSql);
  
    if ($emotionResult->num_rows > 0) {
        while ($emotionRow = $emotionResult->fetch_assoc()) {
            $emotion = $emotionRow["emotion"];
            $count = $emotionRow["count"];
            $total = $emotionResult->num_rows;
            $percentage = ($count / $total) * 100;
            $overall = ($count / $total) * 100;
  
            echo "<div class='emotion-container'>";
            echo "<h4>Emotion: " . $emotion . "</h4>";
            echo "<p>Percentage: " . $overall . "%</p>";
            echo "<div class='progress-bar-container'>";
            echo "<div class='progress-bar' style='width: " . $percentage . "%;' value='" . $count . "' max='100'></div>";
            echo "</div>";
            echo "</div>";
        }
    }
    else {
        foreach ($emotions as $emotion) {
            echo "<div class='emotion-container'>";
            echo "<h4>Emotion: " . $emotion . "</h4>";
            echo "<p>Percentage: 0%</p>";
            echo "<div class='progress-bar-container'>";
            echo "<div class='progress-bar' style='width: 0%;'></div>";
            echo "</div>";
            echo "</div>";
        }
    }
  
    //Table 2: User Info
    $infoSql = "SELECT * FROM emotions WHERE email = '$email' LIMIT 1";
    $infoResult = $conn->query($infoSql);

    if ($infoResult->num_rows > 0) {
        echo "<table class='info-table'>";
        echo "<tr><th>Email</th><th>Age</th></tr>";

        $infoRow = $infoResult->fetch_assoc();
        echo "<tr>";
        echo "<td>" . $infoRow["email"] . "</td>";
        echo "<td>" . $infoRow["age"] . "</td>";
        echo "</tr>";

        echo "</table>";
    } else {
        echo "No data found for the email: $email";
    }


    
    $infoSql = "SELECT * FROM emotions WHERE email = '$email'";
    $infoResult = $conn->query($infoSql);
    
    if ($infoResult->num_rows > 0) {
        echo "<table class='info-table'>";
        echo "<tr><th>Emotion</th><th>Date</th></tr>";
        
        while ($infoRow = $infoResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $infoRow["emotion"] . "</td>";
            echo "<td>" . $infoRow["date"] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No data found for the email: $email";
    }
    $conn->close();
    ?>
    </div>
    

    <script>
   window.addEventListener('load', () => {
  const progressBarContainers = document.querySelectorAll('.progress-bar-container');

  progressBarContainers.forEach(container => {
    const progressBar = container.querySelector('.progress-bar');
    const countElement = container.previousElementSibling.lastChild;
    const totalElement = container.previousElementSibling.previousElementSibling.lastChild;
    const count = parseInt(countElement.textContent);
    const total = parseInt(totalElement.textContent);
    const percentage = (count / total) * 100;

    progressBar.style.width = percentage + '%';

    setTimeout(() => {
      progressBar.style.animation = `progress-animation 3s forwards`;
    }, 10);

    progressBar.addEventListener('animationend', () => {
      progressBar.style.animation = `progress-animation-reverse 3s forwards`;
    }, { once: true });
  });
});
</script>   
</body>
</html>
