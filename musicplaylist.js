document.getElementById("search-btn").addEventListener("click", function() {
    var searchTerm = document.getElementById("search").value;
    searchMusic(searchTerm);
  });
  
  function searchMusic(searchTerm) {
    // Clear previous search results
    document.getElementById("results").innerHTML = "";
  
    // Make an AJAX request to search YouTube for songs
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?term=" + searchTerm, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var results = JSON.parse(xhr.responseText);
        displayResults(results);
      }
    };
    xhr.send();
  }
  
  function displayResults(results) {
    var container = document.getElementById("results");
    for (var i = 0; i < results.length; i++) {
      var card = createCard(results[i]);
      container.appendChild(card);
    }
  }
  
  function createCard(result) {
    var card = document.createElement("div");
    card.className = "card";
  
    var image = document.createElement("img");
    image.src = result.thumbnail;
    card.appendChild(image);
  
    var title = document.createElement("h2");
    title.textContent = result.title;
    card.appendChild(title);
  
    var playBtn = document.createElement("button");
    playBtn.className = "play-btn";
    playBtn.textContent = "Play";
    playBtn.addEventListener("click", function() {
      playSong(result.videoId);
    });
    card.appendChild(playBtn);
  
    return card;
  }
  
  function playSong(videoId) {
    // Implement your logic to play the song based on the video ID
    console.log("Playing song with video ID: " + videoId);
  }
  
  