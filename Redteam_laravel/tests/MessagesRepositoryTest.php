<?php

use App\Models\Messages;
use App\Repositories\MessagesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessagesRepositoryTest extends TestCase
{
    use MakeMessagesTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MessagesRepository
     */
    protected $messagesRepo;

    public function setUp()
    {
        parent::setUp();
        $this->messagesRepo = App::make(MessagesRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMessages()
    {
        $messages = $this->fakeMessagesData();
        $createdMessages = $this->messagesRepo->create($messages);
        $createdMessages = $createdMessages->toArray();
        $this->assertArrayHasKey('id', $createdMessages);
        $this->assertNotNull($createdMessages['id'], 'Created Messages must have id specified');
        $this->assertNotNull(Messages::find($createdMessages['id']), 'Messages with given id must be in DB');
        $this->assertModelData($messages, $createdMessages);
    }

    /**
     * @test read
     */
    public function testReadMessages()
    {
        $messages = $this->makeMessages();
        $dbMessages = $this->messagesRepo->find($messages->id);
        $dbMessages = $dbMessages->toArray();
        $this->assertModelData($messages->toArray(), $dbMessages);
    }

    /**
     * @test update
     */
    public function testUpdateMessages()
    {
        $messages = $this->makeMessages();
        $fakeMessages = $this->fakeMessagesData();
        $updatedMessages = $this->messagesRepo->update($fakeMessages, $messages->id);
        $this->assertModelData($fakeMessages, $updatedMessages->toArray());
        $dbMessages = $this->messagesRepo->find($messages->id);
        $this->assertModelData($fakeMessages, $dbMessages->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMessages()
    {
        $messages = $this->makeMessages();
        $resp = $this->messagesRepo->delete($messages->id);
        $this->assertTrue($resp);
        $this->assertNull(Messages::find($messages->id), 'Messages should not exist in DB');
    }
}
