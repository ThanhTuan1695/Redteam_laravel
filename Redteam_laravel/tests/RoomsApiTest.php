<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomsApiTest extends TestCase
{
    use MakeRoomsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRooms()
    {
        $rooms = $this->fakeRoomsData();
        $this->json('POST', '/api/v1/rooms', $rooms);

        $this->assertApiResponse($rooms);
    }

    /**
     * @test
     */
    public function testReadRooms()
    {
        $rooms = $this->makeRooms();
        $this->json('GET', '/api/v1/rooms/'.$rooms->id);

        $this->assertApiResponse($rooms->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRooms()
    {
        $rooms = $this->makeRooms();
        $editedRooms = $this->fakeRoomsData();

        $this->json('PUT', '/api/v1/rooms/'.$rooms->id, $editedRooms);

        $this->assertApiResponse($editedRooms);
    }

    /**
     * @test
     */
    public function testDeleteRooms()
    {
        $rooms = $this->makeRooms();
        $this->json('DELETE', '/api/v1/rooms/'.$rooms->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/rooms/'.$rooms->id);

        $this->assertResponseStatus(404);
    }
}
