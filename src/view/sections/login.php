<?php require_once "head.php"; ?>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('../../../assets/images/gratisography-augmented-reality-1170x780.jpg');">
    <div class="relative z-10 w-full max-w-md p-8 bg-white/10 border border-white/50 rounded-lg backdrop-blur-md">
        <form class="space-y-6">
            <h2 class="text-2xl font-bold text-white">Login</h2>
            <div class="relative border-b-2 border-gray-300">
                <input type="text" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label class="absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Enter your email
                </label>
            </div>
            <div class="relative border-b-2 border-gray-300">
                <input type="password" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label class="absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Enter your password
                </label>
            </div>
            <div class="flex items-center justify-between text-white">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" class="accent-white" />
                    <span>Remember me</span>
                </label>
                <a href="#" class="hover:underline">Forgot password?</a>
            </div>
            <button type="submit" class="button relative flex items-center justify-center w-full h-12 bg-gray-100 border-4 border-gray-500 rounded cursor-pointer">
                <div class="button__content relative grid w-full h-full rounded">
                    <p class="button__text text-center text-lg bg-gray-500">Log In</p>
                </div>
            </button>
            <button type="submit" class="button relative flex items-center justify-center w-full h-12 bg-gray-100 border-4 border-gray-500 rounded cursor-pointer">
              <div class="button__content relative grid w-full h-full rounded">
                  <p class="button__text text-center text-lg bg-gray-500">Continue as a Guest!</p>
              </div>
          </button>
            <div class="text-center text-white">
                <p>Don't have an account? <a href="register.php" class="underline hover:no-underline">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>