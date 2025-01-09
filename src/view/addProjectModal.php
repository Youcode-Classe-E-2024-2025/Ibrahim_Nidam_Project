<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white text-gray-800 p-8 border border-gray-300 shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Add New Project</h2>
        <form method="POST" action="?action=addProject">
        <?php $csrf_token = \Utilities\CSRF::getToken("addProjectForm"); ?>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token) ?>">
            <label class="block mb-4">
                <span class="text-gray-600">Project Name</span>
                <input
                type="text"
                name="project_name"
                class="mt-1 block w-full border border-gray-300 focus:ring focus:border-blue-500 p-2"
                />
            </label>
        
        <label class="block mb-4">
            <span class="text-gray-600">Description</span>
            <textarea
            name="project_description"
            class="mt-1 block w-full border border-gray-300 focus:ring focus:border-blue-500 p-2"
            ></textarea>
        </label>

        <label class="block mb-4">
            <span class="text-gray-600 mr-4">Visibility : </span>
            <div id="publicPrivateToggle" class="inline-flex mt-2 select-none">
                <button
                id="privateBtn"
                type="button"
                class="px-4 py-2 text-white bg-gradient-to-tr from-[#2a464e] via-[#243b42] to-[#1d2b31]"
                onclick="togglePublicPrivate(false)"
                >
                Private
                </button>
                <button
                id="publicBtn"
                type="button"
                class="px-4 py-2 bg-gray-200 text-gray-800"
                onclick="togglePublicPrivate(true)"
                >
                Public
                </button>
            </div>
            <input type="hidden" name="isPublic" id="isPublicInput" value="0" />
        </label>

        <label class="block mb-4">
            <span class="text-gray-600">Add Collaborators</span>
            <select
                class="chosen-select mt-1 w-full"
                name="project_users[]"
                multiple
                data-placeholder="Select members...">
                <?php if(!empty($users)): ?>
                    <?php foreach($users as $user): ?>
                        <option value="<?= $user["id"] ?>"><?= $user["name"] ?></option>
                    <?php endforeach; ?>
                <?php else : ?>
                    <option value=""><?= "No Users" ?></option>    
                <?php endif; ?>
            </select>
        </label>

        <div class="flex justify-end">
            <button
            type="button"
            class="px-4 py-2 mr-2 border border-gray-300 text-gray-800 hover:bg-gray-200 transition"
            onclick="closeModal()"
            >
            Cancel
            </button>
            <button
            type="submit"
            class="px-4 py-2 border bg-indigo-600 text-white hover:bg-indigo-700 transition"
            >
            Create
            </button>
        </div>
        <input type="hidden" name="manager_id" value="<?= $_SESSION["user_id"] ?>">
        </form>
    </div>
    </div>