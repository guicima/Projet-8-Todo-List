<?php

namespace Tests\App\Controller;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class TaskControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected $client;

    protected $testUser;

    protected $doctrine;

    protected $userRepository;
    
    protected $taskRepository;

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
        $this->taskRepository = $this->doctrine->getRepository(Task::class);
    }

    public function loginUser() {
        $this->testUser = $this->userRepository->findOneByEmail('email@email.com');
        $this->client->loginUser($this->testUser);
    }

    public function testActionsUnauthentified()
    {
        $this->client->request('GET', '/tasks');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/tasks/create');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/tasks/1/edit');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/tasks/1/toggle');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');

        $this->client->request('GET', '/tasks/1/delete');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', 'Se connecter');
    }

    public function testListAction()
    {   
        $this->loginUser();
        $this->client->request('GET', '/tasks');
        $this->assertResponseIsSuccessful();
    }

    public function testCreateAction()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Task test';
        $form['task[content]'] = 'Content test';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a été bien été ajoutée.');

        $task = $this->taskRepository->findOneByTitle('Task test');
        $this->assertNotNull($task);
        $this->assertSame('Content test', $task->getContent());
    }

    public function testEditAction()
    {
        $this->loginUser();
        $userTask = $this->testUser->getTask()->first();
        $crawler = $this->client->request('GET', '/tasks/'.$userTask->getId().'/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Task modify test';
        $form['task[content]'] = 'Content modify test';
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a bien été modifiée.');

        $task = $this->taskRepository->findOneByTitle('Task modify test');
        $this->assertNotNull($task);
        $this->assertSame('Content modify test', $task->getContent());
    }

    public function testToggleAction()
    {
        $this->loginUser();
        $userTask = $this->testUser->getTask()->first();
        $userTaskIsDone = $userTask->isDone();
        $crawler = $this->client->request('POST', '/tasks/'.$userTask->getId().'/toggle');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-success', 'Superbe ! La tâche Task 1 a bien été marquée comme faite.');
        $this->assertNotSame($userTaskIsDone, $userTask->isDone());
    }


    public function testDeleteAction()
    {
        $this->loginUser();
        $userTask = $this->testUser->getTask()->first();
        $crawler = $this->client->request('POST', '/tasks/'.$userTask->getId().'/delete');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-success', 'La tâche a bien été supprimée.');
        $task = $this->taskRepository->findOneById($userTask->getId());
        $this->assertNull($task);
    }

    public function testModifyActionUnauthorized()
    {
        $adminUser = $this->userRepository->findOneByEmail('admin@email.com');
        $this->loginUser();
        $adminTask = $adminUser->getTask()->first();
        $crawler = $this->client->request('GET', '/tasks/'.$adminTask->getId().'/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Task modify test';
        $form['task[content]'] = 'Content modify test';
        $this->client->submit($form);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Oops ! Vous n\'avez pas les droits pour modifier cette tâche.');
    }

    public function testDeleteActionUnauthorized()
    {
        $adminUser = $this->userRepository->findOneByEmail('admin@email.com');
        $this->loginUser();
        $adminTask = $adminUser->getTask()->first();
        $this->client->request('POST', '/tasks/'.$adminTask->getId().'/delete');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Oops ! Vous n\'avez pas les droits pour supprimer cette tâche.');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

}
