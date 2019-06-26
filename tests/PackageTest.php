<?php

namespace Halpdesk\LaravelMinimumPackage\Tests;

use Halpdesk\LaravelMinimumPackage\Facades\PackageServiceFacade;
use Halpdesk\LaravelMinimumPackage\PackageService;
use Halpdesk\LaravelMinimumPackage\Contracts\User as UserContract;
use Halpdesk\LaravelMinimumPackage\Models\User;

class PackageTest extends TestCase
{

    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * @group package-test
     */
    public function testpackageServiceFacade()
    {
        $packageService = get_class(new PackageService);
        $packageServiceFacadeRoot = get_class(PackageServiceFacade::getFacadeRoot());
        $this->assertEquals($packageService, $packageServiceFacadeRoot);
    }

    /**
     * @group package-test
     */
    public function testConcreteBindingResolutions()
    {
        $user = get_class(new User);
        $userConcreteResolved = get_class(app(UserContract::class));
        $this->assertEquals($user, $userConcreteResolved);
    }

    /**
     * @group package-test
     */
    public function testDatabaseMigrationsWithFactories()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name
        ]);
    }


}
