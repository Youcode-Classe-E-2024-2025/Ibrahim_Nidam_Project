<?php
namespace Controller;

use Model\StatModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StatController extends MainController {
    private $statModel;

    public function __construct() {
        $this->statModel = new StatModel();
    }

    // Fetch stats for the user
    public function getUserData($userId) {
        $tasks = $this->statModel->getUserTasks($userId); // Fetch all tasks
        $projects = $this->statModel->getUserProjects($userId); // Fetch all projects
    
        $userData = [
            'tasks' => $tasks,
            'projects' => $projects
        ];
    
        echo json_encode($userData);
        exit;
    }
    
    

    // Export stats as Excel file
    public function exportUserStats($userId) {
        // Get tasks and projects
        $tasks = $this->statModel->getUserTasks($userId);
        $projects = $this->statModel->getUserProjects($userId);
    
        $spreadsheet = new Spreadsheet();
    
        // Sheet 1: Projects
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Projects');
        $sheet->setCellValue('A1', 'Project Name');
        $sheet->setCellValue('B1', 'Description');
        $sheet->setCellValue('C1', 'Role');
    
        $row = 2;
        foreach ($projects as $project) {
            $sheet->setCellValue('A' . $row, $project['name']);
            $sheet->setCellValue('B' . $row, $project['description']);
            $sheet->setCellValue('C' . $row, $project['role']);
            $row++;
        }
    
        // Create new sheet for tasks
        $taskSheet = $spreadsheet->createSheet();
        $taskSheet->setTitle('Tasks');
        $taskSheet->setCellValue('A1', 'Task Title');
        $taskSheet->setCellValue('B1', 'Description');
        $taskSheet->setCellValue('C1', 'Status');
        $taskSheet->setCellValue('D1', 'Project Name');
    
        $taskRow = 2;
        foreach ($tasks as $task) {
            $taskSheet->setCellValue('A' . $taskRow, $task['title']);
            $taskSheet->setCellValue('B' . $taskRow, $task['description']);
            $taskSheet->setCellValue('C' . $taskRow, $task['status']);
            $taskSheet->setCellValue('D' . $taskRow, $task['project_name']);
            $taskRow++;
        }
    
        // Set active sheet to "Projects" before download
        $spreadsheet->setActiveSheetIndex(0);
    
        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $fileName = "user_performance_stats.xlsx";
    
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
    
        // Send file to output
        $writer->save('php://output');
        exit;
    }
    
}
