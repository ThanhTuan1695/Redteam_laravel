<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MessagesApiTest extends TestCase
{
    use MakeMessagesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMessages()
    {
        $messages = $this->fakeMessagesData();
        $this->json('POST', '/api/v1/messages', $messages);

        $this->assertApiResponse($messages);
    }

    /**
     * @test
     */
    public function testReadMessages()
    {
        $messages = $this->makeMessages();
        $this->json('GET', '/api/v1/messages/'.$messages->id);

        $this->assertApiResponse($messages->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMessages()
    {
        $messages = $this->makeMessages();
        $editedMessages = $this->fakeMessagesData();

        $this->json('PUT', '/api/v1/messages/'.$messages->id, $editedMessages);

        $this->assertApiResponse($editedMessages);
    }

    /**
     * @test
     */
    public function testDeleteMessages()
    {
        $messages = $this->makeMessages();
        $this->json('DELETE', '/api/v1/messages/'.$messages->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/messages/'.$messages->id);

        $this->assertResponseStatus(404);
    }
}
