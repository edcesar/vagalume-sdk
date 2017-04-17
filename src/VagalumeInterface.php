<?php

namespace GiorgioLucca\VagalumeSdk;

use GiorgioLucca\VagalumeSdk\Exception\VagalumeSdkInvalidTypeException;
use GiorgioLucca\VagalumeSdk\Exception\VagalumeSdkNullOrEmptyException;

interface VagalumeInterface
{
    /**
     * @param string $name
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getArtist($name = null);

    /**
     * @param string $artistName
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getDiscography($artistName = null);

    /**
     * @return string
     */
    public function getHotspots();

    /**
     * @return string
     */
    public function getNews();

    /**
     * @param array $types
     * @param string $radioName
     * @return string
     * @throws VagalumeSdkInvalidTypeException
     */
    public function getRadios(array $types, $radioName);

    /**
     * @param string $artistId
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function getArtistImage($artistId = null, $limit = 5);

    /**
     * @param string $name
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function searchAlbum($name = null, $limit = 5);


    /**
     * @param string $name
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function searchArtist($name = null, $limit = 5);

    /**
     * @param string $excerpt
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function searchMusicExcerpt($excerpt = null, $limit = 5);

    /**
     * @param string $artistName
     * @param string $musicName
     * @param int $limit
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function searchArtistMusic($artistName = null, $musicName = null, $limit = 5);

    /**
     * @param string $id
     * @return string
     * @throws VagalumeSdkNullOrEmptyException
     */
    public function searchMusicById($id = null);
}