<?php

use Faker\Factory as Faker;
use App\Models\Messages;
use App\Repositories\MessagesRepository;

trait MakeMessagesTrait
{
    /**
     * Create fake instance of Messages and save it in database
     *
     * @param array $messagesFields
     * @return Messages
     */
    public function makeMessages($messagesFields = [])
    {
        /** @var MessagesRepository $messagesRepo */
        $messagesRepo = App::make(MessagesRepository::class);
        $theme = $this->fakeMessagesData($messagesFields);
        return $messagesRepo->create($theme);
    }

    /**
     * Get fake instance of Messages
     *
     * @param array $messagesFields
     * @return Messages
     */
    public function fakeMessages($messagesFields = [])
    {
        return new Messages($this->fakeMessagesData($messagesFields));
    }

    /**
     * Get fake data of Messages
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMessagesData($messagesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'content' => $fake->word,
            'user_id' => $fake->randomDigitNotNull,
            'room_id' => $fake->randomDigitNotNull,
            'single_id' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $messagesFields);
    }
}
