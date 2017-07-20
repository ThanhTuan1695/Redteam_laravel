<?php

use App\Models\Rooms;
use App\Repositories\RoomsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomsRepositoryTest extends TestCase
{
    use MakeRoomsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RoomsRepository
     */
    protected $roomsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->roomsRepo = App::make(RoomsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRooms()
    {
        $rooms = $this->fakeRoomsData();
        $createdRooms = $this->roomsRepo->create($rooms);
        $createdRooms = $createdRooms->toArray();
        $this->assertArrayHasKey('id', $createdRooms);
        $this->assertNotNull($createdRooms['id'], 'Created Rooms must have id specified');
        $this->assertNotNull(Rooms::find($createdRooms['id']), 'Rooms with given id must be in DB');
        $this->assertModelData($rooms, $createdRooms);
    }

    /**
     * @test read
     */
    public function testReadRooms()
    {
        $rooms = $this->makeRooms();
        $dbRooms = $this->roomsRepo->find($rooms->id);
        $dbRooms = $dbRooms->toArray();
        $this->assertModelData($rooms->toArray(), $dbRooms);
    }

    /**
     * @test update
     */
    public function testUpdateRooms()
    {
        $rooms = $this->makeRooms();
        $fakeRooms = $this->fakeRoomsData();
        $updatedRooms = $this->roomsRepo->update($fakeRooms, $rooms->id);
        $this->assertModelData($fakeRooms, $updatedRooms->toArray());
        $dbRooms = $this->roomsRepo->find($rooms->id);
        $this->assertModelData($fakeRooms, $dbRooms->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRooms()
    {
        $rooms = $this->makeRooms();
        $resp = $this->roomsRepo->delete($rooms->id);
        $this->assertTrue($resp);
        $this->assertNull(Rooms::find($rooms->id), 'Rooms should not exist in DB');
    }
}
