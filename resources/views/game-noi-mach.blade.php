<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
<div class=" relative w-full h-screen flex justify-center items-center">
  <img src="{{ asset('/images/gamenoimach/game-noi-mach-bg.jpg') }}" class=" absolute inset-0 object-cover w-full h-full z-0">
  <div class="absolute top-0 left-0 m-4 px-4 py-2 rounded-xl shadow-lg hover:cursor-pointer bg-white"
    onclick="window.location.href='{{ route('dashboard') }}'">
    Quay lại trang chủ
  </div>
<div class=" bg-white flex flex-row z-10 py-8 px-16 scale-90 rounded-2xl">
    <div class=" flex flex-col border-2 h-[540px] justify-start items-center mr-20 mt-12">
    <div class=" flex w-full mb-30 border-b-2 pb-2 justify-center items-center">
      <p class=" text-4xl font-bold">Inventory</p>
    </div>
    <div class=" px-10">
      <div class=" flex flex-row items-center justify-center mb-10">
        <div class=" relative border-2 w-[90px] h-[90px] mr-5" id="img-container-source">
            <img class=" absolute z-20 rotate-0 transition-transform duration-300" src=" {{asset('images/no background/square_cell.png')}}" draggable="true" id="img-data">
            <img class=" absolute z-0 rotate-0 transition-transform duration-300" src=" {{ asset('images/no background/cell.png') }}" draggable="false">
        </div>
        <div class="flex items-center justify-center w-[45px] h-[45px] border-2">
          <p class=" text-3xl" id="random-number-1">1</p>
        </div>
      </div>
      <div class=" flex flex-row items-center justify-center">
        <div class=" relative border-2 w-[90px] h-[90px] mr-5" id="img-container-source-2">
            <img class=" absolute z-20 rotate-0 transition-transform duration-300" src=" {{asset('images/no background/line_cell.png')}}" draggable="true" id="img-data-2">
            <img class=" absolute z-0 rotate-0 transition-transform duration-300" src=" {{ asset('images/no background/cell.png') }}" draggable="false">
        </div>
        <div class="flex items-center justify-center w-[45px] h-[45px] border-2">
          <p class=" text-3xl" id="random-number-2">1</p>
        </div>
      </div>
    </div>

  </div>
  <div class=" ">
    <div class=" flex items-center justify-center mb-2">
      <p class=" text-4xl font-bold">Màn {{ $level->level_number }}</p>
    </div>
    <div id="timer" class=" text-xl font-bold text-red-600">
      Thời gian: 60s
    </div>
    <div class=" grid grid-cols-6 gap 2">
      @for ($i = 0; $i < 36; $i++)
        @php
          $row = floor($i / 6); // Xác định hàng (row)
          $col = $i % 6; // Xác định cột (col)
        @endphp
      <div class="relative border-2 w-[90px] h-[90px]" id="cell-{{ $row }}-{{ $col }}">
      <img class=" absolute z-0 rotate-0 transition-transform duration-300" src=" {{ asset('images/no background/cell.png') }}" draggable="false" id="bg-{{ $i }}">
      </div>
      @endfor
    </div>
  </div>
</div>


</div>

<div id="popup" class="fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50 hidden">
  <!-- Popup content -->
  <div class="bg-white rounded-2xl p-6 shadow-xl text-center max-w-sm w-full">
    <p class=" text-2xl font-semibold mb-4">Hoàn thành màn chơi!</p>
    <button onclick="nextLevel()" class="bg-green-600 hover:border-gray-400 hover:cursor-pointer border-2 text-white font-semibold px-3 py-1 mr-4 rounded-lg transition">
      Tiếp tục
    </button>
    <button onclick="closePopup()" class="bg-red-600 hover:border-gray-500 hover:cursor-pointer border-2 text-white font-semibold px-3 py-1 ml-4 rounded-lg transition">
      Thoát
    </button>
  </div>
</div>
<div id="popUp" class="fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl p-6 shadow-xl flex flex-col items-center  max-w-sm w-full">
        <p id="notifyContent" class=" text-2xl font-semibold mb-4">Hết thời gian!</p>
        <button onclick="reset()" class="bg-green-600 hover:border-gray-400 hover:cursor-pointer border-2 text-white font-semibold px-3 py-1 rounded-lg transition">
            Chơi lại
        </button>
    </div>
</div>
</body>
</html>

<script>
  let timeLeft = 60;
  const timerDisplay =document.getElementById("timer");
  const popUp =document.getElementById("popUp");
  countdown =setInterval(() => {
    timeLeft--;
    timerDisplay.textContent = `Thời gian: ${timeLeft}s`;
    if(timeLeft <=0) {
        clearInterval(countdown);
        popUp.classList.remove("hidden");
    }
  }, 1000);
  function reset() {
      location.reload();
  }
  const pathMap = new Map();
  let startcellid, finishcellid;
  let blockcellsarray = [];
  let gameDataGlobal = {
    gameSlug: "{{ $game->url }}",
  }
  let levelDataGlobal ={
            level_number: "{{$level->level_number}}",
            startX: "{{ $level->start_x }}",
            startY: "{{ $level->start_y }}",
            endX: "{{ $level->end_x }}",
            endY: "{{ $level->end_y }}",
            last: "{{$level->last}}",
            item_a_count: "{{ $level->item_a_count }}",
            item_b_count: "{{ $level->item_b_count }}",
            obstacles: <?php echo $obstacles; ?>,
        };
  levelDataGlobal.obstacles.forEach(obstacle => {
      const obstacle_cell_id = 'cell-' + obstacle.x + '-' + obstacle.y;
      blockcellsarray.push(obstacle_cell_id); 
    });
  startcellid = 'cell-' + levelDataGlobal.startX + '-' + levelDataGlobal.startY;
  finishcellid = 'cell-' + levelDataGlobal.endX + '-' + levelDataGlobal.endY;
  blockcellsarray.push(startcellid);
  blockcellsarray.push(finishcellid);
  console.log(blockcellsarray);
        
  document.addEventListener("DOMContentLoaded", () => {

    const levelData = {
            startX: "{{ $level->start_x }}",
            startY: "{{ $level->start_y }}",
            endX: "{{ $level->end_x }}",
            endY: "{{ $level->end_y }}",
            item_a_count: "{{ $level->item_a_count }}",
            item_b_count: "{{ $level->item_b_count }}",
            obstacles: <?php echo $obstacles; ?>,
        };
    console.log(levelData);
    console.log("levelDataGlobal", levelDataGlobal);
    // const randomIndexes = [];
    // while (randomIndexes.length < 2) {
    //   let rand = Math.floor(Math.random() * 36); // 36 ô
    //   if (!randomIndexes.includes(rand)) {
    //     randomIndexes.push(rand);
    //   }
    // }
    const imageOptions = [
      {src: "{{ asset('images/no background/start_cell.png') }}", id: "img-start"},
      {src: "{{ asset('images/no background/end_cell_uncomplete.png') }}", id: "img-finish"},
      {src: "{{ asset('images/no background/block_cell.png') }}"},
    ]
    const targetContainer = document.getElementById(startcellid);
      if (targetContainer) {
      const img = document.createElement("img");
      img.id = imageOptions[0].id;
      img.src = imageOptions[0].src;
      img.className = "absolute z-10 rotate-0 transition-transform duration-300";
      img.setAttribute("draggable", "false");
      targetContainer.appendChild(img);
      }
    const targetContainer2 = document.getElementById(finishcellid);
    if (targetContainer) {
    const img = document.createElement("img");
    img.id = imageOptions[1].id;
    img.src = imageOptions[1].src;
    img.className = "absolute z-10 rotate-0 transition-transform duration-300";
    img.setAttribute("draggable", "false");

    targetContainer2.appendChild(img);
    }
    levelData.obstacles.forEach(obstacle => {
      const obstacle_cell_id = 'cell-' + obstacle.x + '-' + obstacle.y;
      const targetContainer = document.getElementById(obstacle_cell_id);
      if(targetContainer) {
        const img = document.createElement("img");
        img.id = 'block-cell' +obstacle.x;
        img.src = imageOptions[2].src;
        img.className = "absolute z-10";
        img.setAttribute("draggable", "false");

        targetContainer.appendChild(img);

      }

      
    });
    const randomNumber1 = document.getElementById('random-number-1');
    const randomNumber2 = document.getElementById('random-number-2');
    randomNumber1.textContent = levelDataGlobal.item_a_count;
    randomNumber2.textContent = levelDataGlobal.item_b_count;
    // randomIndexes.forEach((index, i) => {
    //   const x = Math.floor(index / 6);
    //   const y = index % 6; 
    //   const currentCellId = `cell-${x}-${y}`;
    //   if (!startcellid) {
    //     startcellid = currentCellId;
    //   } else {
    //     finishcellid = currentCellId;
    //   }
    //   const targetContainer = document.getElementById(currentCellId);
    //   if (targetContainer) {
    //   const img = document.createElement("img");
    //   img.id = imageOptions[i].id;
    //   img.src = imageOptions[i].src;
    //   img.className = "absolute z-10 rotate-0 transition-transform duration-300";
    //   img.setAttribute("draggable", "false");

    //   targetContainer.appendChild(img);
    // })
  })
  
  const container1 = document.getElementById('img-container-source');
  const container2 =document.getElementById('img-container-source-2');

  // let random1 = getRandomInt(1,5);
  // let random2 = getRandomInt(1,5);

  const rotateClasses = ["rotate-0", "rotate-90", "rotate-180", "rotate-[270deg]"];

  const allTargets = document.querySelectorAll('[id^="cell"], #img-container-source, #img-container-source-2');
  allTargets.forEach(container => {
    container.addEventListener('dragstart', (e) => {
      if(e.target.tagName === 'IMG') {
        dragged = e.target;
        e.dataTransfer.setData("text", e.target.id);
        e.dataTransfer.setData("source-container", container.id);
      }
    });
    container.addEventListener('dragover', (e) => {
      e.preventDefault();
    });
    container.addEventListener('drop', (e) => {
      e.preventDefault();
      if (e.currentTarget.id === 'img-container-source' || e.currentTarget.id === 'img-container-source-2' || blockcellsarray.includes(e.currentTarget.id)) {
        return;
      }
      const data = e.dataTransfer.getData("text/plain");
      const sourceContainerId = e.dataTransfer.getData("source-container");
      const originalImg =document.getElementById(data);
      if (sourceContainerId === 'img-container-source' || sourceContainerId === 'img-container-source-2') {
        let randomElement = null;
        if (sourceContainerId === 'img-container-source') {
          randomElement = document.getElementById('random-number-1');
        } else {
          randomElement = document.getElementById('random-number-2');
        }
        let count = parseInt(randomElement.textContent);
        if (count <= 0) {
          alert("Hết số lượng!");
          return; // Không clone nếu hết
        }
        randomElement.textContent = count - 1;
        const clonedImg = originalImg.cloneNode(true);
        const newId = data + "-clone-" + Date.now();
        clonedImg.id = newId;
        clonedImg.dataset.rotateIndex = "0";
        clonedImg.addEventListener("click", () => {
        let previousIndex = parseInt(clonedImg.dataset.rotateIndex);
        let currentIndex = parseInt(clonedImg.dataset.rotateIndex);
        clonedImg.classList.remove(...rotateClasses);
        currentIndex = (currentIndex + 1) % rotateClasses.length;
        clonedImg.classList.add(rotateClasses[currentIndex]);
        clonedImg.dataset.rotateIndex = currentIndex;
        if(clonedImg.dataset.rotateIndex !== previousIndex) {
          setTimeout(() => {
            checkPower();
          }, 1000);
        }

        });
        container.appendChild(clonedImg);
        checkPower();
      } else {
        const draggedImg = document.getElementById(data);
        if (!e.currentTarget.contains(draggedImg)) {
          e.currentTarget.appendChild(draggedImg);
          setTimeout(() => {
            checkPower();
          }, 1000);
        }
      }
    });
  });

  function checkLeftCell(x, y, a, b) {
    console.log("checkLeftCell: " +x +"," +y);
    if(x<0 || x>5 || y<0 || y>5) {
      return;
    }
    const container =document.getElementById(`cell-${x}-${y}`);
    const img = getImageFromContainer(container);
    if(img === null) {
      return;
    }
    console.log(img.src);
    addToPathMap(a, b, x, y);
    const imageOptions = [
      "{{ asset('images/no background/square_cell.png') }}",
      "{{ asset('images/no background/line_cell.png') }}",
      "{{ asset('images/no background/end_cell_uncomplete.png') }}",
    ]
    const rotateIndex = parseInt(img.dataset.rotateIndex);
    if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[0])) {
      switch(rotateIndex) {
        case 0:
          checkBottomCell(x+1, y, x, y);
          break;
        case 3:
          checkTopCell(x-1, y, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[1])) {
      switch(rotateIndex) {
        case 0:
          checkLeftCell(x, y-1, x, y);
          break;
        case 2:
          checkLeftCell(x, y-1, x, y);
          break;
        default:
          break;
      }
     } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[2])) {
      finishGame();
      }
      return;
    } 
    

  function checkRightCell(x, y, a, b) {
    if(x<0 || x>5 || y<0 || y>5) {
      return;
    }
    console.log("checkRightCell: " +x +"," +y);
    const container =document.getElementById(`cell-${x}-${y}`);
    const img = getImageFromContainer(container);
    if(img === null) {
      return;
    }
    console.log(img.src);
    addToPathMap(a, b, x, y);
    const imageOptions = [
      "{{ asset('images/no background/square_cell.png') }}",
      "{{ asset('images/no background/line_cell.png') }}",
      "{{ asset('images/no background/end_cell_uncomplete.png') }}",
    ]
    const rotateIndex = parseInt(img.dataset.rotateIndex);
    if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[0])) {
      switch(rotateIndex) {
        case 1:
          checkBottomCell(x+1, y, x, y);
          break;
        case 2:
          checkTopCell(x-1, y, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[1])) {
      switch(rotateIndex) {
        case 0:
          checkRightCell(x, y+1, x, y);
          break;
        case 2:
          checkRightCell(x, y+1, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[2])) {
      finishGame();
    }
    return;
  }

  function checkBottomCell(x, y, a, b) {
    if(x<0 || x>5 || y<0 || y>5) {
      return;
    }
    console.log("checkBottomCell: " +x +"," +y);
    const container =document.getElementById(`cell-${x}-${y}`);
    const img = getImageFromContainer(container);
    if(img === null) {
      return;
    }
    console.log(img.src);
    addToPathMap(a, b, x, y);
    const imageOptions = [
      "{{ asset('images/no background/square_cell.png') }}",
      "{{ asset('images/no background/line_cell.png') }}",
      "{{ asset('images/no background/end_cell_uncomplete.png') }}",
    ]
    const rotateIndex = parseInt(img.dataset.rotateIndex);
    if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[0])) {
      switch(rotateIndex) {
        case 2:
          checkLeftCell(x, y-1, x, y);
          break;
        case 3:
          checkRightCell(x, y+1, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[1])) {
      switch(rotateIndex) {
        case 1:
          checkBottomCell(x+1, y, x, y);
          break;
        case 3:
          checkBottomCell(x+1, y, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[2])) {
      finishGame();
    }
    return;
  }

  function checkTopCell(x, y, a, b) {
    if(x<0 || x>5 || y<0 || y>5) {
      return;
    }
    console.log("checkTopCell: " +x +"," +y);
    const container =document.getElementById(`cell-${x}-${y}`);
    const img = getImageFromContainer(container);
    if(img === null) {
      return;
    }
    console.log(img.src);
    addToPathMap(a, b, x, y);
    const imageOptions = [
      "{{ asset('images/no background/square_cell.png') }}",
      "{{ asset('images/no background/line_cell.png') }}",
      "{{ asset('images/no background/end_cell_uncomplete.png') }}",
    ]
    const rotateIndex = parseInt(img.dataset.rotateIndex);
    if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[0])) {
      switch(rotateIndex) {
        case 0:
          checkRightCell(x, y+1, x, y);
          break;
        case 1:
          checkLeftCell(x, y-1, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[1])) {
      switch(rotateIndex) {
        case 1:
          checkTopCell(x-1, y, x, y);
          break;
        case 3:
          checkTopCell(x-1, y, x, y);
          break;
        default:
          break;
      }
    } else if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[2])) {
      finishGame();
    }
    return;
  }

  function checkPower() {
    console.log("checkPower");
    const [, a, b] = startcellid.split('-').map(Number);
    checkLeftCell(a, b-1, a, b);
    checkRightCell(a, b+1, a, b);
    checkBottomCell(a+1, b, a, b);
    checkTopCell(a-1, b, a, b);
  }

  function getImageFromContainer(container) {
    return container.querySelector('img[id^="img-data-clone-"], img[id^="img-data-2-clone-"], img#img-finish, img#img-start' ) || null;
  }

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max-min+1)) + min;
  };

  function checkResult() {
    if(start == true && finish == true) {
      alert("Hoàn thành màn chơi!");
    }
  }

  function addToPathMap(a, b, x, y) {
  const key = JSON.stringify([a, b]);
  const value = [x, y];
  pathMap.set(key, value);
  console.log(pathMap);
  }

  function finishGame() {
    const [, a, b] = startcellid.split('-').map(Number);
    const [, c, d] = finishcellid.split('-').map(Number);
    const imageOptions = [
      "{{ asset('images/no background/square_cell_complete.png') }}",
      "{{ asset('images/no background/line_cell_complete.png') }}",
      "{{ asset('images/no background/end_cell_complete.png') }}",
      "{{ asset('images/no background/square_cell.png') }}",
      "{{ asset('images/no background/line_cell.png') }}",

    ]
    let container =document.getElementById(`cell-${c}-${d}`);
    let img = getImageFromContainer(container);
    img.src =imageOptions[2];
    let x, y;
    [x, y] =getKeyByValue(pathMap, [c, d]);
    while (a !== x || b !== y) {
      container =document.getElementById(`cell-${x}-${y}`);
      img = getImageFromContainer(container);
      console.log("finishGame: " +x +"," +y +"," +img.src);
      if(decodeURIComponent(img.src) === decodeURIComponent(imageOptions[3])) {
        img.src =imageOptions[0];
      } else if (decodeURIComponent(img.src) === decodeURIComponent(imageOptions[4])) {
        img.src =imageOptions[1];
      }
      [x, y] =getKeyByValue(pathMap, [x, y]);
    }
    setTimeout(() => {
            showPopup();
          }, 1000);
  }

  function getKeyByValue(map, searchValue) {
  for (const [key, value] of map.entries()) {
    if (JSON.stringify(value) === JSON.stringify(searchValue)) {
      return JSON.parse(key);
    }
  }
  return null;
}

function showPopup() {
  document.getElementById("popup").classList.remove("hidden");
}

function closePopup() {
  location.reload(); // reload sau khi đóng popup
}
function nextLevel() {
  if(levelDataGlobal.last == 1) {
      location.href = `/${gameDataGlobal.gameSlug}/1`
  } else {
    location.href = `/${gameDataGlobal.gameSlug}/${parseInt(levelDataGlobal.level_number) + 1}`
  }

}
</script>
