<?php

namespace Illuminate\Foundation\Auth;

use Bizytech\Auth\Facades\AuthorizationService;

trait AuthorizeUserTrait
{
    public function createRoles(...$roles){
        return AuthorizationService::createRole($roles);
    }

    public function createPermissions(...$permissions){
        return AuthorizationService::createPermissions($permissions);
    }

    public function assignRoleToUser($role): void
    {
        AuthorizationService::assignRoleToUser($this,$role);
    }

    public function giveUserDirectPermissions(...$permissions){
        AuthorizationService::assignDirectPermissionToUser($this, $permissions);
    }

    public function givePermissionToRole($role, array $permissions){
        AuthorizationService::givePermissionsToRole($role, $permissions);
    }

    public function grantAllPermissionsToUser(){
        AuthorizationService::grantAllPermissionToUser($this);
    }

    public function revokeAllPermissionToUser(){
        AuthorizationService::revokeAllPermissionToUser($this);
    }

    public function findAllRoles(){
        return AuthorizationService::findAllRoles();
    }

    public function findAllPermissions(){
        return AuthorizationService::findAllPermissions();
    }

    public function findAllUsers(){}
}
