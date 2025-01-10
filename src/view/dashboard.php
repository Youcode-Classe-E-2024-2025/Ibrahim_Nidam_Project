<?php require_once "sections/head.php"; ?>

<div class="ml-10">
                <?php if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "Admin"): ?><a id="projectsLink" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=roleManagment">Role Managment</a><?php endif; ?>
                <a id="projectsLink" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=home">Projects</a>
                <a class="mx-2 text-sm font-semibold text-indigo-700" href="?action=dashboard">Dashboard</a>
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <a href="?action=logout">
                    <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
            </a>
            <button class="flex items-center justify-center w-8 h-8 ml-auto border-2 border-red-300 overflow-hidden rounded-full cursor-pointer">
                <img src="../assets/images/26911540_m.jpg" alt="">
            </button>
        </div>
        </div>
    </div>

    <?php require_once "projectJS.php" ?>


</body>
</html>
