<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MediasApiTest extends TestCase
{
    use MakeMediasTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMedias()
    {
        $medias = $this->fakeMediasData();
        $this->json('POST', '/api/v1/medias', $medias);

        $this->assertApiResponse($medias);
    }

    /**
     * @test
     */
    public function testReadMedias()
    {
        $medias = $this->makeMedias();
        $this->json('GET', '/api/v1/medias/'.$medias->id);

        $this->assertApiResponse($medias->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMedias()
    {
        $medias = $this->makeMedias();
        $editedMedias = $this->fakeMediasData();

        $this->json('PUT', '/api/v1/medias/'.$medias->id, $editedMedias);

        $this->assertApiResponse($editedMedias);
    }

    /**
     * @test
     */
    public function testDeleteMedias()
    {
        $medias = $this->makeMedias();
        $this->json('DELETE', '/api/v1/medias/'.$medias->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/medias/'.$medias->id);

        $this->assertResponseStatus(404);
    }
}
