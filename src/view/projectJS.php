<script>

        function showTab(tabId) {
            const mainSection = document.getElementById('mainSection');
            const selectedSection = document.getElementById(tabId + 'Section');

            const projectsLink = document.getElementById('projectsLink');
            const pendingLink = document.getElementById('pendingLink');

            if (!selectedSection.classList.contains('hidden')) {
                selectedSection.classList.add('hidden');
                if (tabId === 'pending') {
                    mainSection.classList.remove('hidden');
                    pendingLink.classList.remove('text-indigo-700');
                    pendingLink.classList.add('text-gray-600', 'hover:text-indigo-700');
                    projectsLink.classList.remove('text-gray-600');
                    projectsLink.classList.add('text-indigo-700');
                }
            } else {
                document.querySelectorAll('.tab-content').forEach((section) => {
                    section.classList.add('hidden');
                });
                selectedSection.classList.remove('hidden');

                if (tabId === 'pending') {
                    pendingLink.classList.add('text-indigo-700');
                    pendingLink.classList.remove('text-gray-600', 'hover:text-indigo-700');
                    projectsLink.classList.add('text-gray-600');
                    projectsLink.classList.remove('text-indigo-700');
                } else {
                    projectsLink.classList.add('text-indigo-700');
                    projectsLink.classList.remove('text-gray-600');
                    pendingLink.classList.remove('text-indigo-700');
                    pendingLink.classList.add('text-gray-600', 'hover:text-indigo-700');
                }
            }
        }



        function toggleLock(event, btn) {
            // event.stopPropagation();
            
        const isLocked = (btn.getAttribute('data-locked') === 'true');
        const svg = btn.querySelector('.lock-icon');

        if (isLocked) {
            svg.innerHTML = `
            <path d="M17 8V7c0-2.757-2.243-5-5-5S7 4.243 
                7 7v1H6c-1.103 0-2 .897-2 
                2v8c0 1.103.897 2 2 
                2h12c1.103 0 2-.897 
                2-2v-8c0-1.103-.897-2-2-2h-1zm-6-1c0-1.654 
                1.346-3 3-3s3 1.346 3 3v1H11V7z"/>
            `;
            btn.setAttribute('data-locked', 'false');
        } else {
            svg.innerHTML = `
            <path d="M12 2C9.243 2 7 4.243 7 7v3H6c-1.103 
                0-2 .897-2 2v8c0 1.103.897 2 2 
                2h12c1.103 0 2-.897 
                2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zM9
                7c0-1.654 1.346-3 3-3s3 1.346 3 3v3H9V7zm7 14H8v-6h8v6z"/>
            `;
            btn.setAttribute('data-locked', 'true');
        }

        }

        $(function() {
            $(".chosen-select").chosen({ width: "100%" });
        });

        function togglePublicPrivate(isPublic) {
            const privateBtn = document.getElementById('privateBtn');
            const publicBtn = document.getElementById('publicBtn');
            const isPublicInput = document.getElementById('isPublicInput');

            if (isPublic) {
                publicBtn.className = 'px-4 py-2 text-white bg-gradient-to-tr from-[#2a464e] via-[#243b42] to-[#1d2b31]';
                privateBtn.className = 'px-4 py-2 bg-gray-200 text-gray-800';
                isPublicInput.value = '1';
                } else {
                privateBtn.className = 'px-4 py-2 text-white bg-gradient-to-tr from-[#2a464e] via-[#243b42] to-[#1d2b31]';
                publicBtn.className = 'px-4 py-2 bg-gray-200 text-gray-800';
                isPublicInput.value = '0';
            }
        }

        function openModal() {
            document.getElementById('modalOverlay').classList.remove('hidden');
            document.getElementById('modalOverlay').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.add('hidden');
            document.getElementById('modalOverlay').classList.remove('flex');
        }

        function showNoPermissionMessage(event) {
            // event.preventDefault();

            const buttonElement = document.getElementById('disabledAddProjectButton');
            const messageElement = document.getElementById('permissionMessage');

            buttonElement.classList.add('hidden');
            messageElement.classList.remove('hidden');

            setTimeout(() => {
                messageElement.classList.add('hidden');
                buttonElement.classList.remove('hidden');
            }, 2000);
        }
    </script>