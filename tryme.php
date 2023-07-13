<?php
session_start();
$currentDate = date("d-m-Y");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Face Emotion Detector</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clmtrackr/1.1.0/clmtrackr.min.js"></script>
    <link rel="stylesheet" href="musicworld.css">
    <style>
        #emotions-container {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            flex-direction: column;
        }
        .emotion {
            padding: 5px;
            margin-bottom: 5px;
            background-color: white;
        }
        .highlight {
            background-color: yellow;
        }
        #canvas {
            display: block;
            margin: 0 auto;
        }
        #video {
            display: block;
            margin: 0 auto;
        }
        #final-emotion {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <video id="video" width="640" height="480" autoplay></video>
    <canvas id="canvas"></canvas>
    <div id="emotions-container">
        <div class="emotion" id="happy-emotion">Happy</div>
        <div class="emotion" id="sad-emotion">Sad</div>
        <div class="emotion" id="angry-emotion">Angry</div>
        <div class="emotion" id="tear-emotion">Tear</div>
        <div class="emotion" id="surprised-emotion">Surprised</div>
        <div class="emotion" id="disgust-emotion">Disgust</div>
        <div class="emotion" id="neutral-emotion">Neutral</div>
        <div id="final-emotion">Final Emotion: <span id="final-emotion-value"></span></div>
    </div>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required>
        <br>
        <label for="finalemotion">Final Emotion:</label>
        <input type="text" name="finalEmotion" id="final-emotion-input" value="">
        <input type="submit" value="Submit">
    </form>

    <script>
        // Check if the code has already been run by the user
        if (!localStorage.getItem('codeExecuted')) {
            // Set the flag indicating that the code has been executed
            localStorage.setItem('codeExecuted', 'true');

            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            const emotions = {
                happy: document.getElementById('happy-emotion'),
                sad: document.getElementById('sad-emotion'),
                angry: document.getElementById('angry-emotion'),
                tear: document.getElementById('tear-emotion'),
                surprised: document.getElementById('surprised-emotion'),
                disgust: document.getElementById('disgust-emotion'),
                neutral: document.getElementById('neutral-emotion')
            };
            const finalEmotionValue = document.getElementById('final-emotion-value');
            const finalEmotionInput = document.getElementById('final-emotion-input');
            let tracker;
            let timer;

            const timerDuration = 7000; // Timer duration in milliseconds (30 seconds)

            function startTimer() {
                timer = setTimeout(() => {
                    stopCamera();
                    highlightFinalEmotion();
                }, timerDuration);
            }

            function stopCamera() {
                clearTimeout(timer);
                tracker.stop();
                video.srcObject.getTracks()[0].stop();
                canvas.style.display = 'none'; // Hide the canvas element
            }

            function loop() {
                requestAnimationFrame(loop);

                context.clearRect(0, 0, canvas.width, canvas.height);
                tracker.draw(canvas);

                const positions = tracker.getCurrentPosition();
                if (positions) {
                    const emotion = getEmotion(positions);
                    displayEmotion(emotion);
                    finalEmotionInput.value = emotion; // Set the final emotion value in the hidden input field
                }
            }

            function getEmotion(positions) {
                // Emotion detection logic
                const mouthOpen = positions[57][1] - positions[60][1] > 5;
                const browRaised = positions[18][1] - positions[15][1] < -2;
                const browDown = positions[29][1] - positions[33][1] < -4;
                const noseWrinkled = positions[33][1] - positions[62][1] < 3;
                const lipCornerPulled = positions[44][0] - positions[46][0] > 1;

                if (mouthOpen && browRaised) {
                    return 'Surprised';
                } else if (mouthOpen) {
                    return 'Happy';
                } else if (browDown) {
                    return 'Angry';
                } else if (noseWrinkled && lipCornerPulled) {
                    return 'Disgust';
                } else if (noseWrinkled) {
                    return 'Sad';
                } else if (lipCornerPulled) {
                    return 'Tear';
                } else {
                    return 'Neutral';
                }
            }

            function highlightFinalEmotion() {
                // Final emotion highlighting logic
                const lastEmotion = getEmotion(tracker.getCurrentPosition());
                finalEmotionValue.textContent = lastEmotion;
                finalEmotionValue.classList.add('highlight');

                Object.values(emotions).forEach(emotionEl => {
                    emotionEl.classList.remove('highlight');
                });
                emotions[lastEmotion.toLowerCase()].classList.add('highlight');
                document.getElementById('final-emotion').style.display = 'block'; // Show the final emotion element
                document.getElementById('final-emotion').textContent = 'Final Emotion: ' + lastEmotion;
            }

            function displayEmotion(emotion) {
                // Emotion display logic
                Object.values(emotions).forEach(emotionEl => {
                    emotionEl.classList.remove('highlight');
                });

                emotions[emotion.toLowerCase()].classList.add('highlight');
            }

            function initializeCamera() {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(stream => {
                            video.srcObject = stream;
                            tracker = new clm.tracker();
                            tracker.init();
                            tracker.start(video);
                            startTimer();
                            loop();
                        })
                        .catch(error => {
                            console.log('Error accessing webcam: ', error);
                            // Fallback to navigator.getUserMedia
                            initializeFallbackCamera();
                        });
                } else {
                    // Fallback to navigator.getUserMedia
                    initializeFallbackCamera();
                }
            }

            function initializeFallbackCamera() {
                navigator.getUserMedia = navigator.getUserMedia ||
                                         navigator.webkitGetUserMedia ||
                                         navigator.mozGetUserMedia ||
                                         navigator.msGetUserMedia;

                if (navigator.getUserMedia) {
                    navigator.getUserMedia({ video: true },
                        stream => {
                            video.srcObject = stream;
                            tracker = new clm.tracker();
                            tracker.init();
                            tracker.start(video);
                            startTimer();
                            loop();
                        },
                        error => {
                            console.log('Error accessing webcam: ', error);
                        });
                } else {
                    console.log('getUserMedia is not supported in this browser.');
                }
            }

            // Check for browser compatibility
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                // Initialize the camera using navigator.mediaDevices.getUserMedia
                initializeCamera();
            } else {
                // Fallback to navigator.getUserMedia
                initializeFallbackCamera();
            }
        } else {
            // Show a confirmation dialog before redirecting the user
            const confirmed = confirm('You have already used this page. Please login to proceed again!');
            if (confirmed) {
                localStorage.removeItem('codeExecuted');
                window.location.href = 'login.html';
            } else {
                window.location.href = 'login.html';
        }
    }
    </script>
</body>
</html>

<?php
// Retrieve the form data
require("conn.php");
// Get the session variables

$email = $_POST['email'];
$age = $_POST['age'];
$finalEmotion = $_POST['finalEmotion'];

// Connect to the MySQL database

$sql = "INSERT INTO emotions (`email`, `age`, `emotion`, `date`) VALUES ('$email','$age','$finalEmotion','$currentDate')";
if ($conn->query($sql) === TRUE) {
    echo 'Data inserted successfully.' . "<br>";
} else {
    echo 'Error inserting data: ' . $conn->error;
}

$conn->close();

// Display contents from different tables based on the final emotion and age
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$table = '';

if ($finalEmotion === 'Happy') {
    if ($age >=20) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } elseif ($age >=13 && $age <19) {
        $table = 'enghappy12,malayhappy12,tamilhappy12,chinhappy12';
    }else{
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Sad') {
    if ($age >=20) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } elseif ($age >=13 && $age <19) {
        $table = 'enghappy12,malayhappy12,tamilhappy12,chinhappy12';
    }else{
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Angry') {
    if ($age >=20) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } elseif ($age >=13 && $age <19) {
        $table = 'enghappy12,malayhappy12,tamilhappy12,chinhappy12';
    }else{
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Surprised') {
    if ($age >=20) {
        $table = 'engrock18,malayrock18,tamilrock18,chinrock18';
    } elseif ($age >=13 && $age <19) {
        $table = 'engrock12,malayrock12,tamilrock12,chinrock12';
    }else{
        $table = 'engrock,malayrock,tamilrock,chinrock';
    }
} elseif ($finalEmotion === 'Disgust') {
    if ($age >=20) {
        $table = 'engmelody18,malaymelody18,tamilmelody18,chinmelody18';
    } elseif ($age >=13 && $age <19) {
        $table = 'engmelody12,malaymelody12,tamilmelody12,chinmelody12';
    }else{
        $table = 'engmelody,malaymelody,tamilmelody,chinmelody';
    }
} elseif ($finalEmotion === 'Tear') {
    if ($age >=20) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } elseif ($age >=13 && $age <19) {
        $table = 'enghappy12,malayhappy12,tamilhappy12,chinhappy12';
    }else{
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
} elseif ($finalEmotion === 'Neutral') {
    if ($age >=20) {
        $table = 'enghappy18,malayhappy18,tamilhappy18,chinhappy18';
    } elseif ($age >=13 && $age <19) {
        $table = 'enghappy12,malayhappy12,tamilhappy12,chinhappy12';
    }else{
        $table = 'enghappy,malayhappy,tamilhappy,chinhappy';
    }
}

$tables = explode(",", $table);

foreach ($tables as $tableName) {
    $sql = "SELECT * FROM `$tableName`";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Display song from table
                echo '<a href="' . $row["song1"] . '">' . $row["song1"] . '</a><br>';
            }
        } else {
            echo "No song found.";
        }
    } else {
        echo "Error retrieving data: " . $conn->error;
    }
}

$conn->close();
?>

