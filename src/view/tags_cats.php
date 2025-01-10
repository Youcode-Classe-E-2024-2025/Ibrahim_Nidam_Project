<?php require_once "sections/head.php"; ?>

            <div class="ml-10">
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=home">Projects</a>
                <a class="mx-2 text-sm font-semibold text-gray-600 hover:text-indigo-700" href="?action=dashboard">Dashboard</a>
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
    
    <div class="px-10 mt-6">
        <div class="px-10 mt-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Manage Categories and Tags : <span class="underline"><?= htmlspecialchars($_GET["name"]) ?></span></h1>
            <a href="?action=kanban&id=<?=$_GET["project_id"]?>&name=<?=$_GET["name"]?>"><h1 class="italic underline hover:text-indigo-500 text-xl">← Go back</h1></a>
        </div>
    <div class="flex justify-evenly mt-6">
        <!-- Categories Table -->
        <div class="w-1/2 px-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Category</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="?action=addTagOrCategory&project_id=<?= $_GET['project_id'] ?>&name=<?= urlencode($_GET['name']) ?>" method="post">
                                <input type="text" name="category" placeholder="New Category" class="w-full text-black px-2 py-1 border border-gray-300">
                        </td>
                        <td class="border border-gray-300 px-4 text-center py-2">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 hover:bg-blue-600">Add</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $categories = array_filter($tagsAndCategs, fn($item) => $item['category_id']);
                    if (empty($categories)): ?>
                        <tr>
                            <td colspan="2" class="border border-gray-300 px-4 py-2 text-center">No categories available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $row): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['category_name']) ?></td>
                                <td class="border text-center border-gray-300 px-4 py-2">
                                <div class="flex gap-3 justify-center text-sm">
                                    <a href="?action=editTag&id=<?= $tag['id'] ?>" 
                                        class="text-indigo-600 hover:text-indigo-400 transition-colors">Edit</a>
                                    <a href="?action=deleteTag&id=<?= $tag['id'] ?>" 
                                        class="text-red-600 hover:text-red-400 transition-colors">Delete</a>
                                </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tags Table -->
        <div class="w-1/2 px-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Tag</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="?action=addTagOrCategory&project_id=<?= $_GET['project_id'] ?>&name=<?= urlencode($_GET['name']) ?>" method="post">
                                <input type="text" name="tag" placeholder="New Tag" class="w-full text-black px-2 py-1 border border-gray-300">
                        </td>
                        <td class="border text-center border-gray-300 px-4 py-2">
                            <button type="submit" class="bg-blue-500 text-white px-3 py-1 hover:bg-blue-600">Add</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $tags = array_filter($tagsAndCategs, fn($item) => $item['tag_id']); // Filter tags
                    if (empty($tags)): ?>
                        <tr>
                            <td colspan="2" class="border border-gray-300 px-4 py-2 text-center">No tags available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tags as $row): ?>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['tag_name']) ?></td>
                                <td class="border text-center border-gray-300 px-4 py-2">
                                <div class="flex gap-3 justify-center text-sm">
                                    <a href="?action=editTag&id=<?= $tag['id'] ?>" 
                                        class="text-indigo-600 hover:text-indigo-400 transition-colors">Edit</a>
                                    <a href="?action=deleteTag&id=<?= $tag['id'] ?>" 
                                        class="text-red-600 hover:text-red-400 transition-colors">Delete</a>
                                </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


</body>
</html>
