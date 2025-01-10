<?php require_once "sections/head.php"; ?>

<?php
$projectId = $_GET['id'] ?? null;
$projectName = $_GET['name'] ?? null;
?>
            <div class="ml-10">
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=home">Projects</a>
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=dashboard">Dashboard</a>
                <?php if(isset($_SESSION["user_id"]) && ($_SESSION["user_id"] == $project["manager_id"] || $_SESSION["user_role"] === "Admin")):?>
                    <a href="?action=TagsAndCategories&project_id=<?= $_GET['id'] ?>&name=<?= $_GET["name"]?>" class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700">Tags & Categories</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex gap-4 items-center">
            <a href="?action=logout">
                <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
            </a>
            <buton class="flex items-center justify-center w-8 h-8 ml-auto border-2 border-red-300 overflow-hidden rounded-full cursor-pointer">
                <img src="../assets/images/26911540_m.jpg" alt="">
            </buton>
        </div>
    </div>
    <div class="px-10 mt-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Team Project Board || <?= htmlspecialchars($project["name"]) ?></h1>
        <a href="?action=home"><h1 class="italic underline hover:text-indigo-500 text-xl">← Go back</h1></a>
    </div>

    <div class="flex flex-grow px-10 mt-4 justify-evenly overflow-auto">
        <?php $statuses = ["TODO", "DOING", "REVIEW", "DONE"]; foreach ($statuses as $status): ?>
        <div class="flex flex-col flex-shrink-0 w-72">
            <div class="flex items-center flex-shrink-0 h-10 px-2">
                <span class="block text-sm font-semibold"><?= ucfirst(strtolower($status)) ?></span>
                <span class="flex items-center justify-center w-5 h-5 ml-2 text-sm font-semibold text-indigo-900 bg-white rounded bg-opacity-30">
                    <?= count(array_filter($tasks, fn($task) => $task["status"] === $status)) ?>
                </span>
                <?php if (isset($_SESSION["user_role"]) && ($_SESSION["user_role"] === "Project Manager" || $_SESSION["user_role"] === "Admin")): ?>
                <button onclick="openTaskModal()" class="flex items-center justify-center w-6 h-6 ml-auto text-indigo-500 rounded hover:bg-indigo-500 hover:text-indigo-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            <?php else: ?>
                <button class="flex items-center justify-center w-6 h-6 ml-auto text-gray-400 bg-gray-200 cursor-not-allowed rounded">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            <?php endif; ?>

            </div>

            <div class="flex flex-col pb-2 overflow-auto">
                <?php $filteredTasks = array_filter($tasks, fn($task) => $task["status"] === $status); ?>

                <?php if (!empty($filteredTasks)): ?>
                    <?php foreach ($filteredTasks as $displaying): ?>
                        <?php
                            $projectOwnerId = $project["manager_id"];
                            $isOwner = (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $projectOwnerId);
                            $isAssigned = isset($_SESSION["user_name"]) && in_array($_SESSION["user_name"], $displaying["assigned_users"]);
                            $isAllowed = ($isOwner || $isAssigned || $_SESSION["user_role"] === "Admin");
                        ?>

                        <div 
                            class="relative text-gray-500 flex flex-col items-start p-4 mt-3 bg-white rounded bg-opacity-90 hover:bg-opacity-100"
                            draggable="true"
                        >
                            <?php if ($isAllowed): ?>
                                <span class="absolute inset-0 rounded border-[3px] border-rose-700 animate-pulse pointer-events-none"></span>
                            <?php endif; ?>

                            <?php if ($isAllowed): ?>
                                <details class="absolute top-0 right-0 mt-3 mr-2">
                                    <summary class="flex items-center justify-center w-5 h-5 text-gray-500 rounded hover:bg-gray-200 hover:text-gray-700 focus:outline-none cursor-pointer">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </summary>

                                    <div class="absolute right-0 z-20 mt-1 w-28 bg-white border border-gray-200 rounded shadow-lg">
                                        <form
                                            method="POST" 
                                            action="?action=updateTaskStatus&id=<?= urlencode($_GET['id'] ?? '') ?>"
                                        >
                                            <input type="hidden" name="task_id" value="<?= $displaying['id'] ?>" />
                                            
                                            <button 
                                                type="submit" 
                                                name="new_status" 
                                                value="TODO"
                                                class="block w-full px-3 py-2 text-left hover:bg-gray-100 text-sm"
                                            >
                                                TODO
                                            </button>
                                            <button 
                                                type="submit" 
                                                name="new_status" 
                                                value="DOING"
                                                class="block w-full px-3 py-2 text-left hover:bg-gray-100 text-sm"
                                            >
                                                DOING
                                            </button>
                                            <button 
                                                type="submit" 
                                                name="new_status" 
                                                value="REVIEW"
                                                class="block w-full px-3 py-2 text-left hover:bg-gray-100 text-sm"
                                            >
                                                REVIEW
                                            </button>
                                            <button 
                                                type="submit" 
                                                name="new_status" 
                                                value="DONE"
                                                class="block w-full px-3 py-2 text-left hover:bg-gray-100 text-sm"
                                            >
                                                DONE
                                            </button>
                                        </form>
                                    </div>
                                </details>
                            <?php else: ?>
                                <div 
                                    class="absolute top-0 right-0 mt-3 mr-2 flex items-center justify-center w-5 h-5 text-gray-400 rounded cursor-not-allowed"
                                    title="You are not allowed to change the status"
                                >
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-around w-full mb-2">
                                <span class="flex items-center h-6 px-3 text-xs font-semibold text-green-500 bg-green-100 rounded-full self-start">
                                    <?= htmlspecialchars($displaying["category_name"]) ?>
                                </span>
                                <span class="flex items-center h-6 px-3 text-xs font-semibold text-indigo-500 bg-indigo-100 rounded-full">
                                    #<?= htmlspecialchars($displaying["tag_name"] ?? "General") ?>
                                </span>
                            </div>

                            <h4 class="mt-3 font-bold text-indigo-600 tracking-wider">
                                <?= htmlspecialchars($displaying["title"]) ?>
                            </h4>

                            <p class="mt-1 text-sm text-gray-700">
                                <?= nl2br(htmlspecialchars($displaying["description"])) ?>
                            </p>

                            <div class="flex items-center w-full mt-3 overflow-x-auto space-x-3 no-scrollbar">
                                <?php foreach ($displaying["assigned_users"] as $user): ?>
                                    <span class="whitespace-nowrap px-3 py-1 text-sm bg-gray-300 rounded-full">
                                        <?= htmlspecialchars($user) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tasks available.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="taskModalOverlay" class="fixed inset-0 hidden bg-black bg-opacity-50 justify-center items-center z-50">
    <div class="bg-white text-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-xl font-bold mb-4">Add New Task</h2>

        <form id="taskForm" method="POST" action="?action=addTask&id=<?=$_GET["id"]?>&name=<?=$_GET["name"]?>">
            <input type="hidden" name="project_id" value="<?= htmlspecialchars($_GET['id']) ?>">
            <input type="hidden" name="csrf_token" value="<?= \Utilities\CSRF::getToken("addTask") ?>">

            <label class="block mb-4">
                <span class="text-gray-600">Title</span>
                <input type="text" name="title" class="mt-1 block w-full border border-gray-300 p-2 rounded" required>
            </label>

            <label class="block mb-4">
                <span class="text-gray-600">Description</span>
                <textarea name="description" class="mt-1 block w-full border border-gray-300 p-2 rounded"></textarea>
            </label>

            <label class="block mb-4">
                <span class="text-gray-600">Category</span>
                <select name="category_id" class="mt-1 block w-full border border-gray-300 p-2 rounded" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="block mb-4">
                <span class="text-gray-600">Tag</span>
                <select name="tag_id" class="mt-1 block w-full border border-gray-300 p-2 rounded">
                    <option value="">No Tag</option>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= htmlspecialchars($tag['id']) ?>">
                            <?= htmlspecialchars($tag['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="block mb-4">
                <span class="text-gray-600">Assign Users</span>
                <select required name="assigned_users[]" class="chosen-select mt-1 block w-full border p-2 rounded" multiple>
                    <?php 
                    if (!empty($availableUsers)) {
                        foreach ($availableUsers as $user): ?>
                            <option value="<?= htmlspecialchars($user['person_id']) ?>">
                                <?= htmlspecialchars($user['user_name']) ?>
                            </option>
                        <?php endforeach;
                    } else {
                        echo "<option value=''>No users available</option>";
                    }
                    ?>
                </select>
            </label>

            <div class="flex justify-end">
                <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded mr-2" onclick="closeTaskModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add Task</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.absolute.top-0.right-0')) {
            document.querySelectorAll('.absolute.right-0.mt-2').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    $(function() {
        $(".chosen-select").chosen({ width: "100%" });
    });

    function openTaskModal() {
        document.getElementById('taskModalOverlay').classList.remove('hidden');
        document.getElementById('taskModalOverlay').classList.add('flex');
    }

    function closeTaskModal() {
        document.getElementById('taskModalOverlay').classList.add('hidden');
        document.getElementById('taskModalOverlay').classList.remove('flex');
    }
</script>


</body>
</html>
