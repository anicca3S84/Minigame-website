<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Đăng nhập</title>
</head>
<body>
    <div class="relative w-screen h-screen bg-amber-200">
        <img class="absolute inset-0 w-full h-full object-cover" src="https://images7.alphacoders.com/133/1330226.jpeg" alt="background">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-auto h-auto bg-white px-16 py-8 rounded-2xl shadow-2xl">
            <div>
                <p class="text-4xl font-bold mb-4">Đăng nhập</p>
            </div>
            <hr class="w-12 mb-12 border-3 rounded-4xl">

            {{-- Hiển thị lỗi nếu có --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600 font-semibold">
                    {{ $errors->first() }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <p class=" text-xl font-bold mb-2">Tên đăng nhập</p>
                <input class=" border-2 w-96 h-12 mb-4 rounded-2xl px-4" type="text" name="username" maxlength="20" value="{{ old('username') }}">
            
                <p class=" text-xl font-bold mb-2">Mật khẩu</p>
                <div class=" relative w-96">
                    <input id="passwordInput" class=" border-2 w-full h-12 mb-4 rounded-2xl px-4" type="password" name="password" maxlength="20">
                    <button 
                        id="toggleBtn"
                        type="button"
                        onclick="togglePassword()"
                        class=" absolute right-4 top-3 hover:underline hover:cursor-pointer font-bold"
                    >
                        Hiện
                    </button>
                </div>
            
                <!-- Hiển thị lỗi -->
                @if ($errors->any())
                    <div class=" text-red-700 font-bold text-center mb-4">
                        @foreach ($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                @endif
            
                <p class=" flex justify-center">
                    Nếu quên mật khẩu, bạn có thể&nbsp;
                    <a href="https://google.com.vn" class=" text-blue-800 hover:underline hover:text-blue-950 font-bold">cài lại</a>
                </p>
                <p class=" flex justify-center mb-8">
                    Nếu chưa có tài khoản bạn có thể đăng ký&nbsp;
                    <a class=" text-blue-800 hover:underline hover:text-blue-950 font-bold" href="/register">tại đây</a>
                </p>
                <div class=" flex justify-center">
                    <button class=" w-fit border-2 bg-blue-800 hover:bg-blue-950 hover:cursor-pointer text-white px-8 py-2 rounded-2xl font-bold" type="submit">Đăng nhập</button>
                </div>
                <a class=" hover:underline hover:text-blue-950" href="/dashboard"> < Quay lại</a>
            </form>
            
        </div>
    </div>
</body>
</html>

<script>
    function togglePassword() {
        const input = document.getElementById("passwordInput");
        const button = document.getElementById("toggleBtn");
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        button.innerHTML = isPassword ? "Ẩn" : "Hiện";
    }
</script>
