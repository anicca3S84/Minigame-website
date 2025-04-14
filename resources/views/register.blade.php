<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body>
    <div class=" relative w-screen h-screen bg-amber-200">
        <img class=" absolute inset-0 w-full h-full" src="https://images7.alphacoders.com/133/1330226.jpeg">
        <div class=" absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-auto h-auto bg-white px-16 py-8 rounded-2xl shadow-2xl ">
            <div>
                <p class=" text-4xl font-bold mb-4">Đăng ký</p>
            </div>
            <hr class=" w-12 mb-12 border-3 rounded-4xl">
            <form>
                <p class=" text-xl font-bold mb-2">Tên đăng nhập</p>
                <input class=" border-2 w-96 h-12 mb-4 rounded-2xl px-4" type="text" name="username" maxlength="20">
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
                <p class=" text-xl font-bold mb-2">Email</p>
                <input class=" border-2 w-96 h-12 mb-4 rounded-2xl px-4" type="text" name="email" maxlength="20">
                <p class=" flex justify-center mb-8">
                    Đã có tài khoản? Đăng nhập&nbsp;
                    <a href="/login" class=" text-blue-800 hover:underline hover:text-blue-950 font-bold">tại đây</a>
                </p>
                <div class=" flex justify-center">
                    <button class=" w-fit border-2 bg-blue-800 hover:bg-blue-950 hover:cursor-pointer text-white px-8 py-2 rounded-2xl font-bold" type="submit">Đăng ký</button>
                </div>
                <a class=" hover:underline hover:text-blue-950" href="/"> < Quay lại</a>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    function togglePassword() {
        const input = document.getElementById("passwordInput");
        const button =document.getElementById("toggleBtn");
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        button.innerHTML =isPassword ? "Ẩn" : "Hiện";
    }
</script>