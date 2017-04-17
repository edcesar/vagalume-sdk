<?php

namespace GiorgioLucca\VagalumeSdk\Tests;

use GiorgioLucca\VagalumeSdk\Enum\TypeEnum;
use GiorgioLucca\VagalumeSdk\Vagalume;

class VagalumeTest extends \PHPUnit_Framework_TestCase
{
    private $apiKey = '660a4395f992ff67786584e238f501aa';
    private $sdk;

    public function setUp()
    {
        $this->sdk = new Vagalume($this->apiKey);
    }

    /**
     * @expectedException GiorgioLucca\VagalumeSdk\Exception\VagalumeSdkNullOrEmptyException
     */
    public function testGetArtistWithoutName()
    {
        $this->getSdk()->getArtist('');
    }

    /**
     * @expectedException GiorgioLucca\VagalumeSdk\Exception\VagalumeSdkNotFoundException
     */
    public function testGetArtistNotFound()
    {
        $this->getSdk()->getArtist('Lorem ipsum dat amet');
    }

    public function testGetArtistHasKey()
    {
        $response = json_decode($this->getSdk()->getArtist('u2'), true);

        $this->assertArrayHasKey('artist', $response);
    }

    public function testGetArtist()
    {
        $response = json_decode($this->getSdk()->getArtist('u2'), true);
        $artist = $response['artist'];

        $this->assertEquals($artist['id'], '3ade68b2g3b86eda3');
    }

    public function testGetDiscographyHasKey()
    {
        $response = json_decode($this->getSdk()->getDiscography('u2'), true);

        $this->assertArrayHasKey('discography', $response);
    }

    public function testGetHotspotsHasKey()
    {
        $response = json_decode($this->getSdk()->getHotspots(), true);

        $this->assertArrayHasKey('hotspots', $response);
    }

    public function testGetNewsHasKey()
    {
        $response = json_decode($this->getSdk()->getNews(), true);

        $this->assertArrayHasKey('news', $response);
    }

    /**
     * @expectedException GiorgioLucca\VagalumeSdk\Exception\VagalumeSdkInvalidTypeException
     */
    public function testGetRadiosWithInvalidType()
    {
        $this->getSdk()->getRadios(['hello'], '98fm');
    }

    public function testGetRadios()
    {
        $types = [ TypeEnum::ARTIST ];
        $radioName = 'coca-cola-fm';

        $response = json_decode($this->getSdk()->getRadios($types, $radioName), true);

        $this->assertTrue(! empty($response['art']) && $response['status'] === 'success');
    }

    public function testGetArtistImage()
    {
        $artistId = '3ade68b3gdb86eda3';
        $limit = 10;
        $response = json_decode($this->getSdk()->getArtistImage($artistId, $limit), true);

        $this->assertArrayHasKey('images', $response);
    }

    public function testSearchAlbum()
    {
        $name = 'U218 Singles&limit=5';
        $limit = 5;
        $response = json_decode($this->getSdk()->searchAlbum($name, $limit), true);

        $this->assertArrayHasKey('response', $response);
    }

    public function testSearchArtist()
    {
        $name = 'Skank';
        $limit = 5;
        $response = json_decode($this->getSdk()->searchArtist($name, $limit), true);

        $this->assertArrayHasKey('response', $response);
    }

    public function testMusicExcerpt()
    {
        $excerpt = 'Skank Vamos Fugir';
        $limit = 5;
        $response = json_decode($this->getSdk()->searchMusicExcerpt($excerpt, $limit), true);

        $this->assertArrayHasKey('response', $response);
    }

    public function testArtistMusic()
    {
        $artistName = 'Skank';
        $musicName = 'Vamos Fugir';
        $limit = 5;
        $response = json_decode($this->getSdk()->searchArtistMusic($artistName, $musicName, $limit), true);

        $this->assertArrayHasKey('response', $response);
    }

    public function testSearchMusicById()
    {
        $artistId = '3ade68b3g1f86eda3';
        $id = '3ade68b6g4946fda3';
        $response = json_decode($this->getSdk()->searchMusicById($id), true);

        $this->assertTrue($response['type'] === "exact" && $response['art']['id'] === $artistId);
    }

    /**
     * @return Vagalume
     */
    private function getSdk()
    {
        return $this->sdk;
    }
}