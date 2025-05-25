let score = 1000;
let scoreInterval;
let scoreSaved = false;
let total = 0;
let pointPerQuestion = 0;
let questions = [];
let currentQuestionIndex = 0;

function showTopicScreen() {
    document.getElementById('startScreen').classList.add('hidden');
    document.getElementById('topicScreen').classList.remove('hidden');
}

function startCountDown() {
    score = 1000; //Reset điểm về 1000 cho mỗi câu hỏi mới khi bắt đầu đếm ngược.
    const scoreBar = document.getElementById('scoreBar');
    const scoreText = document.getElementById('scoreText');

    clearInterval(scoreInterval);

    scoreInterval = setInterval(() => {
        score -= 10;
        if (score < 0) score = 0;

        scoreText.textContent = "Score: " + score;
        scoreBar.style.width = (score / 1000) * 100 + '%';

        if (score == 0) {
            clearInterval(scoreInterval);
            // Hiển thị đáp án khi hết thời gian
            document.getElementById('failedMessage').classList.remove('hidden');
            document.getElementById('failedMessage').textContent = "Answer: " + questions[currentQuestionIndex].answer;
            document.getElementById('failedMessage').style.color = 'red';

            setTimeout(() => {
                currentQuestionIndex++;
                loadQuestion(currentQuestionIndex);
            }, 1000); 
        }
    }, 100);
}





function startGame(gameSlug, topicSlug) {
    document.getElementById('topicScreen').classList.add('hidden');
    document.getElementById('gameScreen').classList.remove('hidden');
    console.log("Chọn chủ đề:", topicSlug);
    console.log("Game slug:", gameSlug);

    fetch(`/game/${gameSlug}/topic/${topicSlug}/questions`)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error ${response.status}`);
            return response.json();
        })
        .then(data => {
            questions = data;
            console.log('Fetched questions:', questions);
            currentQuestionIndex = 0;
            total = 0;
            loadQuestion(currentQuestionIndex);
        })
        .catch(error => {
            console.error('Error fetching questions:', error);
        });
}

function loadQuestion(index) {
    if (index >= questions.length) {
        document.getElementById('endScreen').classList.remove('hidden');
        document.getElementById('finalScore').textContent = total;
        document.getElementById('gameScreen').classList.add('hidden');
        return;
    }

    const currentQuestion = questions[index];
    const letters = currentQuestion.letters.split('');
    const lettersContainer = document.getElementById('letters');
    lettersContainer.innerHTML = '';

    letters.forEach(letter => {
        const letterDiv = document.createElement('div');
        letterDiv.classList.add('letter');
        letterDiv.textContent = letter;
        lettersContainer.appendChild(letterDiv);
    });

    document.getElementById('questionText').textContent = `Question ${index + 1}`;

    // Cập nhật audio
    const audio = document.getElementById('questionAudio');
    audio.src = currentQuestion.audio_url;
    audio.load(); // đảm bảo reset và sẵn sàng phát khi click

    document.getElementById('answerInput').value = '';
    document.getElementById('failedMessage').classList.add('hidden');
    document.getElementById('successMessage').classList.add('hidden');
    document.getElementById('checkAnswerBtn').textContent = 'Try';

    startCountDown();
}




function checkAnswer() {
    const input = document.getElementById("answerInput").value.trim().toUpperCase();
    const correctAnswer = questions[currentQuestionIndex].answer;
    if (input === "") return;
    if (input === correctAnswer) {
        document.getElementById("successMessage").classList.remove("hidden");
        document.getElementById("failedMessage").classList.add("hidden");
        clearInterval(scoreInterval);

        if (!scoreSaved) {
            scoreSaved = true;
            pointPerQuestion = score;
            total += pointPerQuestion;
        }

        setTimeout(() => {
            currentQuestionIndex++;
            scoreSaved = false;
            loadQuestion(currentQuestionIndex);
        }, 1000);
    } else {
        document.getElementById("failedMessage").textContent = "Incorrect!";
        document.getElementById('failedMessage').style.color = 'red';
        document.getElementById("failedMessage").classList.remove("hidden");
        document.getElementById("checkAnswerBtn").textContent = "Try Again";
    }
}

document.getElementById('playAudio').addEventListener('click', function () {
    const audio = document.getElementById('questionAudio');
    audio.play().catch(err => {
        console.error("Không thể phát audio:", err);
    });
});


document.getElementById("answerInput").addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();  // Ngừng hành động mặc định (ví dụ, gửi form)
        checkAnswer();
    }
});

