<?php require_once "sections/head.php"; ?>



            <div class="ml-10">
                <?php if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "Admin"): ?><a id="projectsLink" class="mx-2 text-sm font-semibold text-indigo-700" href="?action=roleManagment">Role Managment</a><?php endif; ?>
                <a id="projectsLink" class="mx-2 text-sm font-semibold text-indigo-700" href="?action=home">Projects</a>
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=dashboard">Dashboard</a>
                <a id="pendingLink" class="mx-2 text-sm font-semibold text-gray-600 cursor-pointer" onclick="showTab('pending')">Pending Requests</a>
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

<div id="mainSection" class="tab-content">
    <div class="px-10 mt-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Projects</h1>
            <?php if (isset($_SESSION["user_role"]) && ($_SESSION["user_role"] === "Project Manager" || $_SESSION["user_role"] === "Admin")): ?>
                <a href="#"
                    id="addProjectButton"
                    class="flex items-center gap-2 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition-colors"
                    onclick="openModal()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Project
                </a>
            <?php else: ?>
                <div class="flex flex-col">
                    <a href="#"
                        id="disabledAddProjectButton"
                        class="flex items-center gap-2 py-2 px-4 bg-gray-500 cursor-not-allowed text-white font-semibold transition-colors"
                        onclick="showNoPermissionMessage(event)"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Project
                    </a>
                    <p id="permissionMessage" class="text-sm text-red-500 hidden mt-2">You do not have permission to create projects.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once "displayProjects.php" ?>
    <?php require_once "addProjectModal.php" ?>
    <?php require_once "pending.php" ?>
    <?php require_once "projectJS.php" ?>


</body>
</html>