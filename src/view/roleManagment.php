<?php require_once "sections/head.php" ?>

            <div class="ml-10">
                <?php if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "Admin"): ?><a id="projectsLink" class="mx-2 text-sm font-semibold text-indigo-700" href="?action=roleManagment">Role Managment</a><?php endif; ?>
                <a id="projectsLink" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=home">Projects</a>
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=dashboard">Dashboard</a>
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

    <div class="px-4 py-8">
    <form action="?action=createRole" method="POST" class="max-w-3xl mx-auto bg-card p-6">
    <div class="mb-8">
        <label for="roleName" class="block text-body font-medium mb-2">Role Name</label>
        <input type="text" id="roleName" name="roleName" placeholder="Enter Role" required class="w-full px-4 py-2 border border-input text-teal-700 rounded focus:outline-none focus:ring-2 focus:ring-ring">
    </div>

    <div class="overflow-x-auto mb-8">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border p-3 bg-secondary text-body">Permissions</th>
                    <th class="border p-3 bg-secondary text-body">C</th>
                    <th class="border p-3 bg-secondary text-body">R</th>
                    <th class="border p-3 bg-secondary text-body">U</th>
                    <th class="border p-3 bg-secondary text-body">D</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="border p-3 font-medium">PROJECT</td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_create" class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_read" class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_update" class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_delete" class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>
                <tr>
                    <td class="border p-3 font-medium">TASK</td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_create" class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_read" class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_update" class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_delete" class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>
                <tr>
                    <td class="border p-3 font-medium">USER</td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_create" class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_read" class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_update" class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_delete" class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button type="submit" class="border-2 text-teal-700 px-6 py-2 bg-white bg-opacity-75 hover:opacity-90 transition-opacity font-medium">
            Create Role
        </button>
    </div>
</form>

    </div>

</body>
</html>