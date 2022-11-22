<?php

namespace Tests\AppBundle\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class UserControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected $client;

    protected $testUser;

    protected $doctrine;

    protected $userRepository;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures(array(
            'App\DataFixtures\UserFixtures',
            'App\DataFixtures\TaskFixtures'
        ));
        $this->doctrine = static::getContainer()->get('doctrine');
        $this->userRepository = $this->doctrine->getRepository(User::class);
    }

    public function loginUser(string $email) 
    {
        $this->testUser = $this->userRepository->findOneByEmail($email);
        $this->client->loginUser($this->testUser);
    }

    public function testListAction()
    {
        $this->loginUser('admin@email.com');
        $this->client->request('GET', '/users');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateAction()
    {
        $this->loginUser('admin@email.com');
        $crawler = $this->client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'usernameTest';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'test@mail.com';
        $form['user[roles]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testEditAction()
    {
        $this->loginUser('admin@email.com');
        $crawler = $this->client->request('GET', '/users/1/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'usernameTest2';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'test2@email.com';
        $form['user[roles]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
    }

    public function testActionsUnauthorized()
    {
        $this->loginUser('email@email.com');
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
        
        $this->client->request('GET', '/users/create');
        $this->assertResponseStatusCodeSame(403);

        $this->client->request('GET', '/users/1/edit');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testActionsUnauthentified()
    {
        $this->client->request('GET', '/users');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/users/create');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/users/1/edit');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

}
