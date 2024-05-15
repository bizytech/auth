<?php

namespace BizyTech\Auth\Tests\AuthBackend;


use Illuminate\Foundation\Auth\AuthorizeUserTrait;
use Illuminate\Support\Facades\App;
use BizyTech\Auth\Services\AuthorizationService;
use Nisimpo\Auth\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthorizeUserTest extends TestCase
{
    use AuthorizeUserTrait;

    protected  AuthorizationService $authorizationService;
    function setUp(): void
    {
        parent::setUp();
        $this->authorizationService = App::make(AuthorizationService::class);
    }
    #[Test]
    public function can_assign_role_to_user(){
        $this->assertFalse($this->testUser->hasRole('testRole'));

        $this->testUser->assignRoleToUser('testRole');

        $this->assertTrue($this->testUser->hasRole('testRole'));

        $this->testUser->removeRole('testRole');

        $this->assertFalse($this->testUser->hasRole('testRole'));
    }

    #[Test]
    public function it_can_assign_and_remove_a_role_on_a_permission()
    {
        $this->testUserPermission->assignRole('testRole');

        $this->assertTrue($this->testUserPermission->hasRole('testRole'));

        $this->testUserPermission->removeRole('testRole');

        $this->assertFalse($this->testUserPermission->hasRole('testRole'));
    }

    #[Test]
    public function it_can_assign_a_role_using_an_object()
    {
        $this->testUser->assignRoleToUser($this->testUserRole);

        $this->assertTrue($this->testUser->hasRole($this->testUserRole));
    }
}
