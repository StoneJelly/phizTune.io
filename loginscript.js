const wrapper = document.querySelector('.wrapper');
            const loginLink = document.querySelector('.login-link');
            const registerLink = document.querySelector('.register-link');
    
            registerLink.addEventListener('click', (event) => {
                event.preventDefault();
                wrapper.classList.add('active');
            });
    
            loginLink.addEventListener('click', (event) => {
                event.preventDefault();
                wrapper.classList.remove('active');
            });

            function updatePreferredSongs(value) {
                document.getElementById('preferred-songs-input').value = value;
            }
            document.getElementById('calendar-icon').addEventListener('click', function() {
                var dateInput = document.getElementById('date-input');
                dateInput.click();
            });