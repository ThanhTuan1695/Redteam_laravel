<?php

use Faker\Factory as Faker;
use App\Models\Rooms;
use App\Repositories\RoomsRepository;

trait MakeRoomsTrait
{
    /**
     * Create fake instance of Rooms and save it in database
     *
     * @param array $roomsFields
     * @return Rooms
     */
    public function makeRooms($roomsFields = [])
    {
        /** @var RoomsRepository $roomsRepo */
        $roomsRepo = App::make(RoomsRepository::class);
        $theme = $this->fakeRoomsData($roomsFields);
        return $roomsRepo->create($theme);
    }

    /**
     * Get fake instance of Rooms
     *
     * @param array $roomsFields
     * @return Rooms
     */
    public function fakeRooms($roomsFields = [])
    {
        return new Rooms($this->fakeRoomsData($roomsFields));
    }

    /**
     * Get fake data of Rooms
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRoomsData($roomsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'id_user' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $roomsFields);
    }
}
