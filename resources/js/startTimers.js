  function startTimers() {
        const timers = document.querySelectorAll('.timer');

        timers.forEach(timer => {
            let timeLeft = 3 * 3600 + 7 * 60 + 31; // 03:07:31

            const interval = setInterval(() => {
                timeLeft--;

                let hours = Math.floor(timeLeft / 3600);
                let minutes = Math.floor((timeLeft % 3600) / 60);
                let seconds = timeLeft % 60;

                timer.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    clearInterval(interval);
                    timer.textContent = "00:00:00";
                }
            }, 1000);
        });
    }

    // Auto start timer jab page load ho
    window.onload = startTimers;

