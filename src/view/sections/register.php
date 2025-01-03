<?php require_once "head.php"; ?>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('https://gratisography.com/wp-content/uploads/2024/11/gratisography-augmented-reality-1170x780.jpg');">
    <div class="relative z-10 w-full max-w-md p-8 bg-white/10 border border-white/50 rounded-lg backdrop-blur-md">
        <form method="POST" action="?action=signup" class="space-y-6">
        <?php $csrf_token = \Utilities\CSRF::getToken("signupForm"); ?>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token) ?>">
            <h2 class="text-2xl font-bold text-white">Register</h2>
            <div class="relative border-b-2 border-gray-300">
                <input id="signup-name" type="text" name="full-name" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label for="signup-name" class="input-label absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Full Name
                </label>
                <span class="error-span text-red-500 text-sm hidden"></span>
            </div>
            <div class="relative border-b-2 border-gray-300">
                <input id="signup-email" name="email" type="email" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label for="signup-email" class="input-label absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Email Address
                </label>
                    <span class="error-span text-red-500 text-sm hidden"></span>
            </div>
            <div class="relative border-b-2 border-gray-300">
                <input id="signup-password" name="password" type="password" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label for="signup-password" class="input-label absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Password
                </label>
                    <span class="error-span text-red-500 text-sm hidden"></span>
            </div>
            <div class="relative border-b-2 border-gray-300">
                <input id="password-confirmed" name="password-confirmed" type="password" required class="w-full h-10 bg-transparent border-none outline-none text-white placeholder-transparent peer" />
                <label for="password-confirmed" class="input-label absolute top-1/2 left-0 text-white text-base transform -translate-y-1/2 peer-placeholder-shown:translate-y-1/2 peer-placeholder-shown:text-base peer-focus:translate-y-[-120%] peer-focus:text-sm transition-all">
                    Confirm Password
                </label>
                <span class="error-span text-red-500 text-sm hidden"></span>
            </div>
            <div class="flex items-center text-white">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" required class="accent-white" />
                    <span>I agree to the <a href="#" class="underline hover:no-underline">Terms & Conditions</a></span>
                </label>
            </div>
            <button type="submit" class="button relative flex items-center justify-center w-full h-12 bg-gray-100 border-4 border-gray-500 rounded cursor-pointer">
                <div class="button__content relative grid w-full h-full rounded">
                    <p class="button__text text-center text-lg bg-gray-500">Register</p>
                </div>
            </button>
            <div class="text-center text-white">
                <p>Already have an account? <a href="?action=login" class="underline hover:no-underline">Login</a></p>
            </div>
        </form>
    </div>

    <script src="../assets/js/app.js"></script>
</body>
</html>