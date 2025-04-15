let gameMode = null;
// Biến lưu độ khó cho AI (easy, medium hoặc hard)
let aiDifficulty = null;
// Biến lưu biểu tượng người chơi và AI
let playerSymbol = "X";
let aiSymbol = "O";

let boxes = document.querySelectorAll(".box");
let turn = "X";
let isGameOver = false;

// Sự kiện chọn chế độ chơi
document.getElementById("one-player").addEventListener("click", () => {
  gameMode = "1";
  document.getElementById("mode-selection").style.display = "none";
  document.getElementById("difficulty-selection").style.display = "block";
});

document.getElementById("two-player").addEventListener("click", () => {
  gameMode = "2";
  document.getElementById("mode-selection").style.display = "none";
  document.getElementById("symbol-selection").style.display = "block";
});

// Sự kiện chọn độ khó (chỉ cho chế độ 1 người)
document.getElementById("easy-mode").addEventListener("click", () => selectDifficulty("easy"));
document.getElementById("medium-mode").addEventListener("click", () => selectDifficulty("medium"));
document.getElementById("hard-mode").addEventListener("click", () => selectDifficulty("hard"));

function selectDifficulty(level) {
  aiDifficulty = level;
  document.getElementById("difficulty-selection").style.display = "none";
  document.getElementById("symbol-selection").style.display = "block";
}

// Sự kiện chọn biểu tượng
document.getElementById("choose-x").addEventListener("click", () => selectSymbol("X"));
document.getElementById("choose-o").addEventListener("click", () => selectSymbol("O"));

function selectSymbol(sym) {
  playerSymbol = sym;
  aiSymbol = (sym === "X" ? "O" : "X");
  document.getElementById("symbol-selection").style.display = "none";
  startGame();
  // Nếu chơi 1 người và người chọn O thì AI đi trước
  if (gameMode === "1" && playerSymbol === "O") {
    turn = aiSymbol;
    setTimeout(() => aiMove(aiDifficulty), 500);
  }
}

function startGame() {
  document.getElementById("game-container").style.display = "block";
  resetGame();
}

function resetGame() {
  isGameOver = false;
  // Xác định lượt đầu theo playerSymbol
  turn = playerSymbol;
  document.querySelector(".bg").style.left = (turn === "X" ? "0" : "85px");
  document.querySelector("#results").innerHTML = "";
  document.querySelector("#play-again").style.display = "none";
  document.querySelector("#back-to-mode").style.display = "none";
  boxes.forEach(e => {
    e.innerHTML = "";
    e.style.removeProperty("background-color");
    e.style.color = "#fff";
  });
}

boxes.forEach(e => {
  e.addEventListener("click", () => {
    if (!isGameOver && e.innerHTML === "") {
      e.innerHTML = turn;
      checkWin();
      checkDraw();
      changeTurn();

      if (gameMode === "1" && turn === aiSymbol && !isGameOver) {
        setTimeout(() => aiMove(aiDifficulty), 500);
      }
    }
  });
});

function changeTurn() {
  turn = (turn === "X" ? "O" : "X");
  document.querySelector(".bg").style.left = (turn === "X" ? "0" : "85px");
}

function checkWin() {
  const winConditions = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];
  for (let cond of winConditions) {
    const [a,b,c] = cond;
    const v0 = boxes[a].innerHTML;
    if (v0 !== "" && v0 === boxes[b].innerHTML && v0 === boxes[c].innerHTML) {
      isGameOver = true;
      document.querySelector("#results").innerHTML = turn + " win";
      document.querySelector("#play-again").style.display = "inline";
      document.querySelector("#back-to-mode").style.display = "inline";
      cond.forEach(i => {
        boxes[i].style.backgroundColor = "#08D9D6";
        boxes[i].style.color = "#000";
      });
      return;
    }
  }
}

function checkDraw() {
  if (!isGameOver && getEmptyBoxes().length === 0) {
    isGameOver = true;
    document.querySelector("#results").innerHTML = "Draw";
    document.querySelector("#play-again").style.display = "inline";
    document.querySelector("#back-to-mode").style.display = "inline";
  }
}

// AI moves
function aiMove(difficulty) {
  let bestMove;
  const empty = getEmptyBoxes();

  if (difficulty === "easy") {
    bestMove = randomMove();
  } else if (difficulty === "medium") {
    bestMove = mediumMove();
  } else { 
    // Nếu là nước đi đầu, chọn ô giữa
    if (empty.length === 9) {
      bestMove = { index: 4 };
    } else {
      bestMove = minimax(0, true, -Infinity, Infinity);
    }
  }

  boxes[bestMove.index].innerHTML = aiSymbol;
  checkWin();
  checkDraw();
  changeTurn();
}

function randomMove() {
  const empty = getEmptyBoxes();
  const idx = empty[Math.floor(Math.random() * empty.length)];
  return { index: idx };
}

function mediumMove() {
  const empty = getEmptyBoxes();
  // Thử nước thắng
  for (let i of empty) {
    boxes[i].innerHTML = aiSymbol;
    if (checkWinCondition(aiSymbol)) { boxes[i].innerHTML = ""; return { index: i }; }
    boxes[i].innerHTML = "";
  }
  // Chặn nước thắng của người chơi
  for (let i of empty) {
    boxes[i].innerHTML = playerSymbol;
    if (checkWinCondition(playerSymbol)) { boxes[i].innerHTML = ""; return { index: i }; }
    boxes[i].innerHTML = "";
  }
  // Random
  return randomMove();
}

function minimax(depth, isMaximizing, alpha, beta) {
  if (checkWinCondition(playerSymbol)) return { score: -10 };
  if (checkWinCondition(aiSymbol)) return { score:  10 };
  const empty = getEmptyBoxes();
  if (empty.length === 0) return { score: 0 };

  let bestMove = { score: isMaximizing ? -Infinity : Infinity };

  for (let i of empty) {
    boxes[i].innerHTML = isMaximizing ? aiSymbol : playerSymbol;
    const result = minimax(depth + 1, !isMaximizing, alpha, beta);
    boxes[i].innerHTML = "";

    if (isMaximizing) {
      if (result.score > bestMove.score) {
        bestMove = { index: i, score: result.score };
      }
      alpha = Math.max(alpha, result.score);
    } else {
      if (result.score < bestMove.score) {
        bestMove = { index: i, score: result.score };
      }
      beta = Math.min(beta, result.score);
    }
    if (beta <= alpha) break; // prune
  }
  return bestMove;
}

function getEmptyBoxes() {
  const empty = [];
  boxes.forEach((b,i) => { if (b.innerHTML === "") empty.push(i); });
  return empty;
}

function checkWinCondition(player) {
  const winConditions = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];
  return winConditions.some(cond => cond.every(i => boxes[i].innerHTML === player));
}

// Nút Play Again
document.querySelector("#play-again").addEventListener("click", () => resetGame());
// Nút Quay Lại Chế Độ
document.querySelector("#back-to-mode").addEventListener("click", () => {
  resetGame();
  document.getElementById("game-container").style.display = "none";
  document.getElementById("mode-selection").style.display = "block";
});