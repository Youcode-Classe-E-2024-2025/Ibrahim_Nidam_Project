<!-- Pending Requests Section -->
<div id="pendingSection" class="tab-content hidden mb-8 px-10 mt-6">
        <h1 class="text-2xl font-bold mb-4">Pending Requests</h1>
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <ul class="divide-y divide-gray-200">
                <?php if (isset($pendingRequests["pendingRequests"]) && !empty($pendingRequests["pendingRequests"])): ?>
                    <?php foreach ($pendingRequests["pendingRequests"] as $request): ?>

                        <li class="py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($request["user_name"]) ?>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Requesting to join: <?= htmlspecialchars($request["project_name"]) ?>
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="?action=approveRequest" class="inline">
                                        <input type="hidden" name="project_id" value="<?= htmlspecialchars($request["project_id"]) ?>">
                                        <input type="hidden" name="person_id" value="<?= htmlspecialchars($request["person_id"]) ?>">
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600 transition">
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="?action=disapproveRequest" class="inline">
                                        <input type="hidden" name="project_id" value="<?= htmlspecialchars($request["project_id"]) ?>">
                                        <input type="hidden" name="person_id" value="<?= htmlspecialchars($request["person_id"]) ?>">
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md text-sm hover:bg-red-600 transition">
                                            Disapprove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="py-4 text-gray-500">No pending requests at the moment.</li>
                <?php endif; ?>
            </ul>
        </div>

        <h1 class="text-2xl font-bold mb-4">Assigned Users</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (isset($pendingRequests["getProjectsAssignedUsers"]) && !empty($pendingRequests["getProjectsAssignedUsers"])): ?>
                            <?php foreach ($pendingRequests["getProjectsAssignedUsers"] as $user): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($user["user_name"]) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?= htmlspecialchars($user["project_name"]) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <?= htmlspecialchars($user["role"]) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="POST" action="?action=removeUserFromProject" class="inline">
                                            <input type="hidden" name="project_id" value="<?= htmlspecialchars($user["project_id"]) ?>">
                                            <input type="hidden" name="person_id" value="<?= htmlspecialchars($user["person_id"]) ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No users assigned to your projects.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>