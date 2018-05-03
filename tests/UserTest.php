<?php

class UserTest extends \PHPUnit\Framework\TestCase

{
    protected $user;

    public function setup()
    {
        $this->user = new \App\Models\User;

    }

    public function testThatWeCanGetTheFirstName()
    {
        
        $this->user->setFirstName('John');
        $this->assertEquals($this->user->getFirstName(), 'John');
    }

    public function testThatWeCanGetTheLastName()
    {

        $this->user->setLastName('Doe');
        $this->assertEquals($this->user->getLastName(), 'Doe');
    }

    public function testFirstNameAndLastNameAreTrimmed()

    {
    	$user = new \App\Models\User;
    	$user->setFirstName('John   ');
    	$user->setLastName('   Doe');

    	$this->assertEquals($user->getFirstName(),'John');
    	$this->assertEquals($user->getLastName(),'Doe');
    }

    public function testEmailAddressCanBeSet()

    {
    	$user = new \App\Models\User;
    	$user->setEmail('john.doe@example.com');

    	$this->assertEquals($user->getEmail(),'john.doe@example.com');
    }

    public function testEmailVariablesContainCorrectValues()
    {
    	$user = new \App\Models\User;
    	$user->setFirstName('John');
    	$user->setLastName('Doe');
    	$user->setEmail('john.doe@example.com');

    	$emailVariables = $user->getEmailVariables();

    	$this->assertArrayHasKey('full_name', $emailVariables);
    	$this->assertArrayHasKey('email',$emailVariables);

    	$this->assertEquals($emailVariables['full_name'],'John Doe');
    	$this->assertEquals($emailVariables['email'],'john.doe@example.com');
    }


}