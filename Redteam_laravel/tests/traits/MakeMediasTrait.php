<?php

use Faker\Factory as Faker;
use App\Models\Medias;
use App\Repositories\MediasRepository;

trait MakeMediasTrait
{
    /**
     * Create fake instance of Medias and save it in database
     *
     * @param array $mediasFields
     * @return Medias
     */
    public function makeMedias($mediasFields = [])
    {
        /** @var MediasRepository $mediasRepo */
        $mediasRepo = App::make(MediasRepository::class);
        $theme = $this->fakeMediasData($mediasFields);
        return $mediasRepo->create($theme);
    }

    /**
     * Get fake instance of Medias
     *
     * @param array $mediasFields
     * @return Medias
     */
    public function fakeMedias($mediasFields = [])
    {
        return new Medias($this->fakeMediasData($mediasFields));
    }

    /**
     * Get fake data of Medias
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMediasData($mediasFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'url' => $fake->word,
            'id_msg' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $mediasFields);
    }
}
