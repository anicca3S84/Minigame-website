let gameMode = null;
let aiDifficulty = null;
let playerSymbol = "X";
let aiSymbol = "O";

let turn = "X";
let isGameOver = false;

// trình duyệt duyệt qua tất cả các phần tử có class "box" theo đúng thứ tự 
// chúng xuất hiện trong HTML, và document.querySelectorAll(".box") trả về
//  danh sách theo thứ tự đó.
let boxes = document.querySelectorAll(".box");

const winConditions = [
  [0,1,2],[3,4,5],[6,7,8],
  [0,3,6],[1,4,7],[2,5,8],
  [0,4,8],[2,4,6]
];

document.getElementById("one-player").addEventListener("click", () =>{
    gameMode = "1";
    document.getElementById("mode-selection").classList.add('hidden');
    document.getElementById("difficulty-selection").classList.remove('hidden');
} )

document.getElementById("two-player").addEventListener("click", () => {
    gameMode = "2";
    document.getElementById("mode-selection").classList.add('hidden');
    document.getElementById("game-screen").classList.remove('hidden');
})

document.getElementById("easy-mode").addEventListener("click", () =>{
    selectDifficulty("easy");
})

document.getElementById("medium-mode").addEventListener("click", () => {
  selectDifficulty("medium");
})

document.getElementById("hard-mode").addEventListener("click", () => {
  selectDifficulty("hard");
})

function selectDifficulty(level){
    aiDifficulty = level;
    document.getElementById("difficulty-selection").classList.add('hidden');
    document.getElementById("symbol-selection").classList.remove('hidden');
}

document.getElementById("choose-x").addEventListener("click", () =>{
    selectSymbol("X");
})

document.getElementById("choose-o").addEventListener("click", () =>{
    selectSymbol("O");
})

function selectSymbol(sym){
  playerSymbol = sym;
  aiSymbol = (sym === "X" ? "O" : "X");
  document.getElementById("symbol-selection").classList.add('hidden');
  document.getElementById("game-screen").classList.remove('hidden');
  startGame();
}

function startGame(){
  isGameOver = false;
  if(gameMode === "1" && playerSymbol === "O"){
    turn = aiSymbol;
    setTimeout(() => aiMove(aiDifficulty), 100);
  }else{
    turn = playerSymbol;
  } 
  document.querySelector(".bg").style.left = (turn === "X" ? "0" : "85px");
}

boxes.forEach(box => {
  box.addEventListener("click", () =>{
    if(!isGameOver && box.innerHTML === ""){
      box.innerHTML = turn;
      checkWin();
      checkDraw();
      changeTurn();
    }
  });
});

function changeTurn(){
  turn = (turn === "X" ? "O" : "X");
  document.querySelector(".bg").style.left = (turn === "X" ? "0" : "85px" );
  if(gameMode === "1" && turn === aiSymbol && !isGameOver){
    setTimeout(() => aiMove(aiDifficulty), 500);
  }
}

//ham tra ve cac chi so con trong trong mang 
function getEmptyBoxes() {
  const emptyBoxes = [];
  boxes.forEach((box,index) => { if (box.innerHTML === "") emptyBoxes.push(index); });
  return emptyBoxes;
}

function randomMove(){
  const emptyBoxes = getEmptyBoxes();
  const randomIndex = emptyBoxes[Math.floor(Math.random() * emptyBoxes.length)];
  return {index : randomIndex}
}

function mediumMove(){
  let move = findMediumMove(aiSymbol);
  // trả về một object có thuộc tính index, và gán giá trị của move vào
  if(move  != null) return {index : move};
  
  move = findMediumMove(playerSymbol);
  if(move != null) return {index : move};

  return randomMove();
}

function findMediumMove(symbol){
  for(let cond of winConditions){
    const [a, b, c] = cond;
    const indexes = [a, b, c];
    const values = [boxes[a].innerHTML, boxes[b].innerHTML, boxes[c].innerHTML];

    
    const symbolCount = values.filter(v => v === symbol).length;
    const emptyCount = values.filter(v => v === "").length;
    if(symbolCount === 2 && emptyCount === 1){
      return indexes[values.indexOf("")];
    }
  }
  return null;
}

function evaluate() {
  for (let cond of winConditions) {
      const [a, b, c] = cond;
      const v0 = boxes[a].innerHTML;
      if (v0 !== "" && v0 === boxes[b].innerHTML && v0 === boxes[c].innerHTML) {
          if (v0 === aiSymbol) return 1;
          if (v0 === playerSymbol) return -1;
      }
  }
  if (getEmptyBoxes().length === 0) return 0;
  return null;
}

function minimax(isMaximizing) {
  const result = evaluate();
  if (result !== null) return result;

  if (isMaximizing) {
      let bestScore = -Infinity;
      for (let index of getEmptyBoxes()) {
          boxes[index].innerHTML = aiSymbol;
          let score = minimax(false);
          boxes[index].innerHTML = "";
          bestScore = Math.max(score, bestScore);
      }
      return bestScore;
  } else {
      let bestScore = Infinity;
      for (let index of getEmptyBoxes()) {
          boxes[index].innerHTML = playerSymbol;
          let score = minimax(true);
          boxes[index].innerHTML = "";
          bestScore = Math.min(score, bestScore);
      }
      return bestScore;
  }
}

function hardMove() {
  let bestScore = -Infinity;
  let bestMove;
  for (let index of getEmptyBoxes()) {
      boxes[index].innerHTML = aiSymbol;
      let score = minimax(false);
      boxes[index].innerHTML = "";
      if (score > bestScore) {
          bestScore = score;
          bestMove = index;
      }
  }
  return { index: bestMove };
}


function aiMove(difficulty){
  let bestMove;
  if(difficulty === "easy") {
    bestMove = randomMove();
  }else if(difficulty === "medium"){
    bestMove = mediumMove();
  }else{
    bestMove = hardMove();
  }
  console.log(bestMove);
  boxes[bestMove.index].innerHTML = aiSymbol;
  checkWin();
  checkDraw();
  changeTurn();
}

function checkWin(){
    for(let cond of winConditions){
      const [a, b, c] = cond;
      //lấy nội dung của ô có index a trong trình duyệt
      //nếu người dùng chưa đánh a v0 ===  ""
      const v0 = boxes[a].innerHTML;
      if(v0 !== "" && v0 === boxes[b].innerHTML && v0 === boxes[c].innerHTML){
        isGameOver = true; 
        document.querySelector('#results').innerHTML = turn + " win"
        document.querySelector("#play-again").style.display = "inline";
        document.querySelector("#back-to-mode").style.display = "inline"; 
        cond.forEach(index => {
          boxes[index].style.backgroundColor = "#08D9D6";
          boxes[index].style.color = "#000";
        });
        return;
      }
    }
}

function checkDraw(){
  if(!isGameOver && getEmptyBoxes().length === 0){
    isGameOver = true;
    document.querySelector("#results").innerHTML = "Draw";
    document.querySelector("#play-again").style.display = "inline";
    document.querySelector("#back-to-mode").style.display = "inline"; 
  }
}








