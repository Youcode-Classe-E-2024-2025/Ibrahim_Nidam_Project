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


    <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">User Performance Dashboard</h1>

    <a href="?action=exportStats" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
        Export to Excel
    </a>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <div class="shadow-lg rounded-lg bg-white p-4 flex justify-center items-center">
            <canvas id="projectsChart" style="max-width: 400px; max-height: 400px;"></canvas>
        </div>

        <div class="shadow-lg rounded-lg bg-white p-4 flex justify-center items-center">
            <canvas id="tasksChart" style="max-width: 400px; max-height: 400px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetch('?action=userData')
            .then(response => response.json())
            .then(data => {
                const { projects, tasks } = data;

                const creatorProjects = projects.filter(p => p.role === 'Creator').length;
                const memberProjects = projects.filter(p => p.role === 'Member').length;

                const taskStatusCounts = {
                    TODO: 0,
                    DOING: 0,
                    REVIEW: 0,
                    DONE: 0
                };

                tasks.forEach(task => {
                    taskStatusCounts[task.status]++;
                });

                new Chart(document.getElementById('projectsChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Projects Created', 'Projects Joined as Member'],
                        datasets: [{
                            data: [creatorProjects, memberProjects],
                            backgroundColor: ['#4F46E5', '#6366F1']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });

                new Chart(document.getElementById('tasksChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['TODO', 'DOING', 'REVIEW', 'DONE'],
                        datasets: [{
                            label: 'Task Status Breakdown',
                            data: [
                                taskStatusCounts.TODO,
                                taskStatusCounts.DOING,
                                taskStatusCounts.REVIEW,
                                taskStatusCounts.DONE
                            ],
                            backgroundColor: ['#FBBF24', '#3B82F6', '#F87171', '#10B981']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    });
</script>



</body>
</html>
