
gapi.load('client', initYouTubeAPI);

// Initialize the YouTube API client library
function initYouTubeAPI() {
    gapi.client.init({
        apiKey: 'AIzaSyAeHqeZ4Su0q8JmlzUphGdwoI6H6tqRbMo',
        discoveryDocs: ['https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest'],
    }).then(function () {
        console.log('YouTube API initialized');
        const searchButton = document.getElementById('search-button');
        searchButton.addEventListener('click', search);
    }, function (error) {
        console.error('Error loading YouTube API:', error);
    });
}

// Perform the search and display results
function search() {
    const searchInput = document.getElementById('search-input');
    const query = searchInput.value.trim();

    if (query === '') {
        alert('Please enter a search query.');
        return;
    }

    // Make a request to the YouTube API
    gapi.client.youtube.search.list({
        part: 'snippet',
        q: query,
        type: 'video',
        maxResults: 10
    }).then(function (response) {
        console.log('YouTube API response:', response);
        const searchResults = document.getElementById('search-results');

        // Clear previous search results
        searchResults.innerHTML = '';

        // Process the API response and display results
        const items = response.result.items;
        items.forEach(item => {
            const videoId = item.id.videoId;
            const title = item.snippet.title;
            const thumbnailUrl = item.snippet.thumbnails.default.url;

            // Create a card for each search result
            const card = document.createElement('div');
            card.classList.add('card');

            const thumbnail = document.createElement('img');
            thumbnail.src = thumbnailUrl;

            const cardTitle = document.createElement('h3');
            cardTitle.textContent = title;

            const playButton = document.createElement('button');
            playButton.textContent = 'Play';
            playButton.addEventListener('click', function () {
                playSong(videoId);
            });

            card.appendChild(thumbnail);
            card.appendChild(cardTitle);
            card.appendChild(playButton);

            searchResults.appendChild(card);
        });
    }, function (error) {
        console.error('Error searching YouTube:', error);
    });
}

// Play the selected song
function playSong(videoId) {
    const audio = document.createElement('audio');
    audio.src = 'https://www.youtube.com/watch?v=' + videoId;
    audio.controls = true;

    const musicContainer = document.querySelector('.music-container');
    musicContainer.innerHTML = '';
    musicContainer.appendChild(audio);
}