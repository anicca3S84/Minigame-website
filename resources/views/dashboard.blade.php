<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Trang Demo</title>


</head>



<body>
    <div class="page-wrapper">

        <!-- HEADER -->
        @include('partials.header')

        <!-- MAIN CONTENT -->
        <main>
            <div class="game-grid">
                @foreach ($games as $game)
                    <div class="game-card">
                        @if ($game->gameType == 1)
                        <a href="{{ route('game.show', ['gameSlug' => $game->url, 'levelSlug' => 1]) }}">
                        @else
                        <a href="{{ route('game.show', ['gameSlug' => $game->url, 'levelSlug' => 0]) }}">
                        @endif
                            <img src="{{ asset($game->imageUrl) }}" alt="Game Image" class="game-card__image">
                        </a>
                        <div class="game-card__content">
                            <h3 class="game-card__title">{{ $game->name }}</h3>
                            <p class="game-card__creator">By Admin</p>  {{-- Nếu có creator thì lấy ra sau --}}
                            <div class="game-card__actions">
                                <div>
                                    <i class="fas fa-heart"></i>
                                    <span>100</span>
                                </div>
                                <div>
                                    <i class="fas fa-comment"></i>
                                    <span>10K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
        

        <!-- FOOTER -->


        <!-- FOOTER -->
        @include('partials.footer')

    </div>

    <script src="{{ asset('js/header.js') }}"></script>
</body>

</html>
