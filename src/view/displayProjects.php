<?php $displayProjects = array(); foreach ($projects as $project) { $displayProjects[] = $project; } ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-10 mt-8 py-4">
        <?php foreach ($displayProjects as $displaying): ?>
            <?php
                $currentUserId = $_SESSION["user_id"] ?? null; // If not set, default to null
                $isOwner = ($currentUserId !== null && $currentUserId == $displaying["manager_id"]);
                $isAssigned = ($currentUserId !== null && in_array($currentUserId, $displaying["assigned_users"] ?? []));
                $isAllowed = ($isOwner || $isAssigned || (isset($_SESSION["user_role"]) && $_SESSION["user_role"] === "Admin"));
            ?>
            <div data-project-id="<?= htmlspecialchars($displaying["id"]) ?>" class="bg-white cursor-pointer bg-opacity-90 rounded p-5 text-gray-800 shadow-md hover:bg-opacity-100 transition-colors relative group">
                <?php if ($isAllowed): ?>
                    <span class="absolute inset-0 rounded border-[3px] border-rose-700 animate-pulse pointer-events-none"></span>
                <?php endif; ?>

                <form method="POST" action="?action=toggleVisibility" class="absolute top-3 right-3">
                    <input type="hidden" name="project_id" value="<?= htmlspecialchars($displaying["id"]) ?>">
                    <input type="hidden" name="isPublic" value="<?= $displaying["isPublic"] ? 0 : 1 ?>">
                    <button type="submit" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <?= $displaying["isPublic"] == 1
                                ? '<path d="M17 8V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1zm-6-1c0-1.654 1.346-3 3-3s3 1.346 3 3v1H11V7z"/>'
                                : '<path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm7 14H8v-6h8v6z"/>'; ?>
                        </svg>
                    </button>
                </form>

                <a href="?action=kanban&id=<?= htmlspecialchars($displaying["id"]) ?>&name=<?= htmlspecialchars($displaying["name"]) ?>" class="block">
                    <h2 class="text-lg font-bold text-gray-800 mb-2"><?= htmlspecialchars($displaying["name"]) ?></h2>
                    <div class="text-sm text-gray-600 mb-3">Completion: <?= htmlspecialchars($displaying["completion_percentage"]) ?>%</div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                        <div class="<?= htmlspecialchars($displaying["completion_percentage"]) < 40 ? "bg-red-500" : (htmlspecialchars($displaying["completion_percentage"]) < 80 ? "bg-yellow-500" : "bg-green-500"); ?> h-2 rounded-full" style="width: <?= $displaying["completion_percentage"] ?>%;"></div>
                    </div>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($displaying["description"]) ?>.</p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>