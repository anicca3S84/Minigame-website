<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Spelling Word Scramble</title>
    <link rel="stylesheet" href="{{ asset('css/spelling-word.css') }}">
</head>

<body>

    <div class="game-wrapper">
        <div class="start-screen" id="startScreen">
            <h1>Spelling Word Scramble!</h1>
            <button onclick="showTopicScreen()">Start Game</button>
        </div>

        <div class="hidden" id="topicScreen">
            <h2>Select a Topic</h2>
            <div class="topics">
                @foreach ($topics as $topic)
                    <div class="topic-card" onclick="startGame('{{ $game->url }}', '{{ $topic->slug }}')
">
                        <img src="{{ asset($topic->imgUrl) }}" alt="{{ $topic->title }}">
                        <h3>{{ $topic->title }}</h3>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hidden" id="gameScreen">
            <h1>Spelling Word Scramble</h1>
            <div class="instruction">Use the letters to spell the word.</div>

            <div class="instruction question-header">
                <span id="questionText">Question 1</span>
                <button id="playAudio" class="hint-button" title="Hear the word">💡</button>
            </div>

            <div class="letters" id="letters"></div>

            <div class="blanks" id="blanks">
                <input type="text" id="answerInput" maxlength="20" placeholder="Type your answer here">
            </div>

            <div class="incorrect hidden" id="failedMessage">Incorrect!</div>

            <button onclick="checkAnswer()" id="checkAnswerBtn" class="try-button">Try</button>

            <div class="success hidden" id="successMessage">🎉 Correct!</div>

            <div class="score-bar-container">
                <div class="score-bar" id="scoreBar"></div>
            </div>
            <div class="score-text" id="scoreText">Score: 1000</div>
            <audio id="questionAudio" hidden></audio>


        </div>

        <div id="endScreen" class="hidden">
            <h2>Chúc mừng! Bạn đã hoàn thành.</h2>
            <p>Tổng điểm: <span id="finalScore">0</span></p>
            <button onclick="window.location.href='{{ route('game.showGame', [$game->url]) }}'">Play again</button>
            <button onclick="window.location.href='{{ route('dashboard') }}'">Get out</button>


        </div>

    </div>

    <script src="{{ asset('js/spelling-word.js') }}"></script>
</body>

</html>
