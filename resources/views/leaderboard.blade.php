<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <div>
        <div class=" relative w-full h-screen ">
            <img class="absolute inset-0 w-full h-full object-cover z-0" src="{{ asset('/images/leaderboard/bg-leaderboard.jpg') }}" alt="background">
            <div class="absolute top-0 left-0 m-4 bg-white px-4 py-2 rounded-xl shadow-lg hover:cursor-pointer z-20"
                onclick="window.location.href='{{ route('dashboard') }}'">
                Quay lại trang chủ
            </div>
            <div class="flex flex-col items-center h-full w-full py-8 relative z-10">
                <div class=" w-2/3 pb-2 inset-10">
                    <input id="search" type="text" placeholder="Nhập tên game" class=" w-1/3 border-2 px-2 py-1 bg-white rounded-xl">
                </div>
                <div class=" w-2/3 bg-white h-full rounded-xl px-4 py-2">
                    <div class=" text-center text-4xl">
                        LEADERBOARD
                    </div>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="border-2 w-1/10">Ranking</th>
                                <th class="border-2 w-3/10">Name</th>
                                <th class="border-2 w-2/10">Score</th>
                                <th class="border-2 w-4/10">Record At</th>
                        </thead>
                        <tbody id="leaderboardBody">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</body>
</html>
<script>
    const searchUrlBase = "{{ url('/game/search') }}";
    const topScoresUrlBase = "{{ url('/game/top-score') }}";
    document.getElementById('search').addEventListener('keydown', function(e) {
        if(e.key == 'Enter') {
            const name = e.target.value.trim();
            console.log(name);
            if(name.length === 0 ) return;
            fetch(`${searchUrlBase}/${encodeURIComponent(name)}`)
            .then(res => res.json())
            .then(data => {
                if(data.id) {
                    fetch(`${topScoresUrlBase}/${data.id}`)
                    .then(response => response.json())
                    .then(data => {
                        const leaderboardBody = document.getElementById('leaderboardBody');
                        leaderboardBody.innerHTML = "";
                        data.forEach((entry, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class=" w-1/10 text-center py-2 font-bold">${index +1}</td>
                                <td class=" w-3/10 text-center py-2 font-bold">${entry.user_name}</td>
                                <td class=" w-2/10 text-center py-2 font-bold">${entry.score}</td>
                                <td class=" w-4/10 text-center py-2 font-bold">${entry.recordAt}</td>  
                            `
                            leaderboardBody.appendChild(row);
                        });
                    })
                }
            })

        }
    })

</script>