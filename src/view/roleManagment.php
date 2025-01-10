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

    <div class="flex">
    <!-- Main Content -->
    <div class="flex-1 px-4 py-8">
    <form action="<?= isset($_GET['id']) ? '?action=updateRole&id=' . htmlspecialchars($_GET['id']) : '?action=createRole' ?>" method="POST" id="roleForm" class="max-w-3xl mx-auto bg-card p-6">
    <div class="mb-8">
        <label for="roleName" class="block text-body font-medium mb-2">Role Name</label>
        <input type="text" id="roleName" name="roleName" value="<?= htmlspecialchars($roleName) ?>" placeholder="Enter Role" required class="w-full px-4 py-2 border border-input text-teal-700 rounded focus:outline-none focus:ring-2 focus:ring-ring">
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
                <!-- PROJECT Permissions -->
                <tr>
                    <td class="border p-3 font-medium">PROJECT</td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_create" 
                            <?= in_array($permissionIds['PROJECT CREATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_read" 
                            <?= in_array($permissionIds['PROJECT READ'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_update" 
                            <?= in_array($permissionIds['PROJECT UPDATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="project_delete" 
                            <?= in_array($permissionIds['PROJECT DELETE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>

                <!-- TASK Permissions -->
                <tr>
                    <td class="border p-3 font-medium">TASK</td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_create" 
                            <?= in_array($permissionIds['TASK CREATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_read" 
                            <?= in_array($permissionIds['TASK READ'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_update" 
                            <?= in_array($permissionIds['TASK UPDATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="task_delete" 
                            <?= in_array($permissionIds['TASK DELETE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>

                <!-- USER Permissions -->
                <tr>
                    <td class="border p-3 font-medium">USER</td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_create" 
                            <?= in_array($permissionIds['USER CREATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_read" 
                            <?= in_array($permissionIds['USER READ'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-green-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_update" 
                            <?= in_array($permissionIds['USER UPDATE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-yellow-500">
                    </td>
                    <td class="border p-3">
                        <input type="checkbox" name="user_delete" 
                            <?= in_array($permissionIds['USER DELETE'], $rolePermissions, true) ? 'checked' : '' ?> 
                            class="w-5 h-5 rounded border-input accent-red-500">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <button type="submit" class="border-2 text-teal-700 px-6 py-2 bg-white bg-opacity-75 hover:opacity-90 transition-opacity font-medium">
            <?= isset($_GET['id']) ? 'Update Role' : 'Create Role' ?>
        </button>
    </div>
</form>

    </div>

    <!-- Right Sidebar for Roles -->
    <div class="w-1/4 bg-gray-100 text-black border-l-2 p-6 overflow-y-auto h-screen">
        <h2 class="text-xl font-semibold mb-4">Roles List</h2>
        <ul id="rolesList" class="space-y-4">
            <?php if (!empty($roles)): ?>
                <?php foreach ($roles as $role): ?>
                    <li class='flex justify-between items-center bg-white shadow rounded-lg p-4 hover:bg-indigo-50 cursor-pointer' onclick='populateForm("<?= $role['id'] ?>", "<?= $role['name'] ?>")'>
                        <span><?= htmlspecialchars($role['name']) ?></span>
                        <form action='?action=deleteRole&id=<?= $role['id'] ?>' method='POST' onsubmit='return confirm("Are you sure you want to delete this role?")'>
                            <button type='submit' class='text-red-500 hover:text-red-700'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                                </svg>
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class='text-gray-500'>No roles available</li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
    function populateForm(roleId, roleName) {
        document.getElementById('roleName').value = roleName;
        document.getElementById('roleForm').action = '?action=updateRole&id=' + roleId;
    }
</script>


</body>
</html>