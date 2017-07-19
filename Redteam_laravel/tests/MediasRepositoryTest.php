<?php

use App\Models\Medias;
use App\Repositories\MediasRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MediasRepositoryTest extends TestCase
{
    use MakeMediasTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MediasRepository
     */
    protected $mediasRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mediasRepo = App::make(MediasRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMedias()
    {
        $medias = $this->fakeMediasData();
        $createdMedias = $this->mediasRepo->create($medias);
        $createdMedias = $createdMedias->toArray();
        $this->assertArrayHasKey('id', $createdMedias);
        $this->assertNotNull($createdMedias['id'], 'Created Medias must have id specified');
        $this->assertNotNull(Medias::find($createdMedias['id']), 'Medias with given id must be in DB');
        $this->assertModelData($medias, $createdMedias);
    }

    /**
     * @test read
     */
    public function testReadMedias()
    {
        $medias = $this->makeMedias();
        $dbMedias = $this->mediasRepo->find($medias->id);
        $dbMedias = $dbMedias->toArray();
        $this->assertModelData($medias->toArray(), $dbMedias);
    }

    /**
     * @test update
     */
    public function testUpdateMedias()
    {
        $medias = $this->makeMedias();
        $fakeMedias = $this->fakeMediasData();
        $updatedMedias = $this->mediasRepo->update($fakeMedias, $medias->id);
        $this->assertModelData($fakeMedias, $updatedMedias->toArray());
        $dbMedias = $this->mediasRepo->find($medias->id);
        $this->assertModelData($fakeMedias, $dbMedias->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMedias()
    {
        $medias = $this->makeMedias();
        $resp = $this->mediasRepo->delete($medias->id);
        $this->assertTrue($resp);
        $this->assertNull(Medias::find($medias->id), 'Medias should not exist in DB');
    }
}
