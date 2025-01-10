<?php
namespace Controller;

class PermissionController extends MainController {


    public function deleteRole($id) {
        if ($id) {
            $this->PermissionModel->delete('Role', ['id' => $id]);
            header("Location: ?action=roleManagment&deleted=true");
        }
    }
    

    public function createRole() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $roleName = $_POST["roleName"] ?? null;

            $permissions = [];
            foreach ($_POST as $key => $value) {
                if (preg_match("/_(create|read|update|delete)$/", $key)) {
                    $permissions[] = str_replace("_", " ", strtoupper($key));
                }
            }

            if ($roleName && !empty($permissions)) {
                $roleId = $this->PermissionModel->create('Role', ['name' => $roleName]);

                $permissionData = [];
                foreach ($permissions as $permissionName) {
                    $permission = $this->PermissionModel->read('Permission', ['name' => $permissionName]);
                    if (!empty($permission)) {
                        $permissionId = $permission[0]['id'];
                        $permissionData[] = ['role_id' => $roleId, 'permission_id' => $permissionId];
                    }
                }
                if (!empty($permissionData)) {
                    $this->PermissionModel->create('Role_Permission', $permissionData);
                }

                header("Location: ?action=roleManagment&success=true");
            } else {
                header("Location: ?action=roleManagment&error=empty_fields");
            }
        }
    }

    public function updateRole($id) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $roleName = $_POST["roleName"] ?? null;
            $permissions = [];
            
            foreach ($_POST as $key => $value) {
                if (preg_match("/_(create|read|update|delete)$/", $key)) {
                    $permissions[] = str_replace("_", " ", strtoupper($key));
                }
            }
    
            if ($roleName && !empty($permissions)) {
                $this->PermissionModel->update('Role', ['name' => $roleName], ['id' => $id]);
                
                $this->PermissionModel->delete('Role_Permission', ['role_id' => $id]);
                
                $permissionData = [];
                foreach ($permissions as $permissionName) {
                    $permission = $this->PermissionModel->read('Permission', ['name' => $permissionName]);
                    if (!empty($permission)) {
                        $permissionId = $permission[0]['id'];
                        $permissionData[] = ['role_id' => $id, 'permission_id' => $permissionId];
                    }
                }
                
                if (!empty($permissionData)) {
                    $this->PermissionModel->create('Role_Permission', $permissionData);
                }
                
                header("Location: ?action=roleManagment&success=true");
            } else {
                header("Location: ?action=roleManagment&error=empty_fields");
            }
        }
    }
}
