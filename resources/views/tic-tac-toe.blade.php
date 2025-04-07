<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tic Tac Toe</title>
  
  <!-- Import CSS -->
  <link rel="stylesheet" href="{{ asset('css/tic-tac-toe.css') }}">
</head>
<body>
  <!-- Modal chọn chế độ chính -->
  <div id="mode-selection">
    <h2>Chọn chế độ chơi</h2>
    <button class="mode-btn" id="one-player">Chơi 1 Người</button>
    <button class="mode-btn" id="two-player">Chơi 2 Người</button>
  </div>

  <!-- Modal chọn độ khó (chỉ xuất hiện khi chơi 1 người) -->
  <div id="difficulty-selection" style="display: none;">
    <h2>Chọn độ khó</h2>
    <button class="mode-btn" id="easy-mode">Easy</button>
    <button class="mode-btn" id="medium-mode">Medium</button>
    <button class="mode-btn" id="hard-mode">Hard</button>
  </div>


  <div id="symbol-selection" class="modal" style="display: none;">
    <h2>Chọn X hoặc O</h2>
    <button class="mode-btn" id="choose-x">X</button>
    <button class="mode-btn" id="choose-o">O</button>
  </div>

  <!-- Giao diện game -->
  <div id="game-container">
    <div class="turn-container">
      <h3>Turn For</h3>
      <div class="turn-box align">X</div>
      <div class="turn-box align">O</div>
      <div class="bg"></div>
    </div>
    <div class="main-grid">
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
      <div class="box align"></div>
    </div>
    <h2 id="results"></h2>

    <!-- Nút điều khiển -->
    <div id="controls">
      <button id="play-again">Chơi Lại</button>
      <button id="back-to-mode">Quay Lại</button>
    </div>
  </div>

  <!-- Import JavaScript -->
  <script src="{{ asset('js/tic-tac-toe.js') }}"></script>
</body>
</html>
