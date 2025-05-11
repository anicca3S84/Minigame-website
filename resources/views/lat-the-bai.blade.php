<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport"content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="relative w-full h-screen flex flex-col items-center justify-center">
            <img src="{{ asset('/images/flipcardgame/background/flip_card_game_bg.jpg') }}" class=" absolute inset-0 object-cover w-full h-full">
            <div class="absolute top-0 left-0 m-4 bg-white px-4 py-2 rounded-xl shadow-lg hover:cursor-pointer"
                onclick="window.location.href='{{ route('dashboard') }}'">
                Quay lại trang chủ
            </div>
            <div id="playTable" class="absolute flex flex-col items-center justify-center hidden">
                <div class="bg-white flex flex-col items-center justify-center px-8 rounded-2xl mb-2">
                <div id="timer" class=" text-xl font-bold text-red-600">
                    Thời gian: 60s
                </div>
                <div id="score" class=" mb-2 text-2xl text-green-600 font-bold">
                    Điểm: 0
                </div>
                </div>

                <div id="table" class=" grid grid-cols-5 gap-4">

                </div>
            </div>
            <div id="descriptionTable" class="absolute flex flex-col items-center justify-center bg-white px-8 py-4 rounded-2xl mb-2">
                <div class=" text-3xl font-bold mb-4">
                    {{ $game->name }}
                </div>
                <div class=" mb-2 text-md font-bold text-center mb-4">
                    {!! $game->description !!}
                </div>
                <div class=" border-2 rounded-xl text-white font-medium text-xl bg-green-600 px-4 py-2"
                    onclick="startGame()">
                    Bắt Đầu Chơi
                </div>
            </div>

        </div>

        <div id="popUp" class="fixed inset-0 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-6 shadow-xl flex flex-col items-center  max-w-sm w-full">
                <p id="notifyContent" class=" text-2xl font-semibold mb-4"></p>
                <button onclick="reset()" class="bg-green-600 hover:border-gray-400 hover:cursor-pointer border-2 text-white font-semibold px-3 py-1 rounded-lg transition">
                    Chơi lại
                </button>
            </div>
        </div>
    </body>
</html>
<script>
    const table =document.getElementById("table");
    const scoreDiv =document.getElementById("score");
    const array = Array.from({ length: 52}, (_, i) => i+1);
    for(let i =array.length -1; i >0; i--) {
        const j =Math.floor(Math.random()*(i+1));
        [array[i], array[j]] = [array[j], array[i]];
    }
    const random10 = array.slice(0, 10);
    const random20 = [...random10, ...random10];
    console.log(random20);
    let score = 0;
    let cell_1_id, cell_2_id;
    let flippedCells = 0;
    let canClick = true;
    let timeLeft = 60;
    const timerDisplay =document.getElementById("timer");
    const popUp =document.getElementById("popUp");
    const notifyContent =document.getElementById("notifyContent");
    const countdown=null;   
    for(i=1; i<=20; i++) {
        const newDiv = document.createElement("div");
        const newImg =document.createElement("img");
        const randomNumber =getRandomItem(random20);
        newDiv.id = i;
        newDiv.className = "border-2 rounded-xl ring-2 ring-gray-300 flex items-center justify-center bg-gradient-to-b from-green-200 to-green-50 shadow-xl w-[90px] h-[135px] select-none";
        newDiv.dataset.index = i;
        newImg.src = "{{ asset('images/flipcardgame/') }}/" + randomNumber + ".png";
        newImg.className = "hidden";
        newDiv.appendChild(newImg);
        newDiv.onclick = function() {   
            if(!canClick) {
                return;
            }
            const img = newDiv.querySelector('img');
            img.classList.remove("hidden");

            if(flippedCells ==0) {
                flippedCells++;
                cell_1_id = newDiv.id;
            } else if(flippedCells==1) {
                if(newDiv.id == cell_1_id) {

                } else {
                    canClick = false;
                    flippedCells =0;
                    cell_2_id =newDiv.id;
                    if(compare(cell_1_id, cell_2_id)) {
                        score++;
                        scoreDiv.textContent = `Điểm: ${score}`;
                        if(score ==10) {
                            clearInterval(countdown);
                            setTimeout(() =>{
                                notifyContent.textContent = "Hoàn thành trò chơi!";
                                popUp.classList.remove("hidden");
                            }, 1000);
                        }
                    };
                    console.log("canClick sau if compare: " + canClick);
                }
            }
        }
        table.appendChild(newDiv);
    }
    function getRandomItem(arr) {
        const randomIndex = Math.floor(Math.random() * arr.length);
        return arr.splice(randomIndex, 1)[0];
    }
    function startGame() {
        const div1 =document.getElementById("descriptionTable");
        const div2 =document.getElementById("playTable");
        div1.classList.add("hidden");
        div2.classList.remove("hidden");
        countdown =setInterval(() => {
        timeLeft--;
        timerDisplay.textContent = `Thời gian: ${timeLeft}s`;
        if(timeLeft <=0) {
            clearInterval(countdown);
            notifyContent.textContent = "Hết giờ!";
            popUp.classList.remove("hidden");
        }
    }, 1000);
    }
    function compare(id1, id2) {
        console.log("div1_id: " + cell_1_id);
        console.log("div2_id: " + cell_2_id);
        const div1 = document.getElementById(id1);
        const div2 =document.getElementById(id2);
        const img1 = div1.querySelector('img');
        const img2 = div2.querySelector('img');
        console.log("img1 src:" + img1.src);
        console.log("img2 src: " + img2.src);
        if(img1.src == img2.src) {
            div1.onclick = null;
            div2.onclick = null;
            canClick=true;
            return true;
        } else {
            setTimeout(() => {
                img1.classList.add("hidden");
                img2.classList.add("hidden");
                canClick = true;
            }, 1000);
            return false;
        }
    }
    function reset() {
        location.reload();
    }
</script>