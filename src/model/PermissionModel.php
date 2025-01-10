<?php
namespace Model;

class PermissionModel extends MainModel {
    protected $table = "Permission";

    public function getAllPermissions() {
        return $this->read($this->table);
    }

    public function createPermission($permissionName) {
        return $this->create($this->table, ['name' => $permissionName]);
    }

    public function deletePermission($permissionId) {
        return $this->delete($this->table, ['id' => $permissionId]);
    }

    public function updatePermission($permissionId, $newPermissionName) {
        return $this->update($this->table, ['name' => $newPermissionName], ['id' => $permissionId]);
    }
}
