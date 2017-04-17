# VAGALUME SDK

[![Build Status][travis-image]][travis-url] [![License][license-url]][packagist-url] [![Packagist](https://img.shields.io/packagist/v/giorgiolucca/vagalume-sdk.svg)][packagist-url] [![Latest Stable Version](https://poser.pugx.org/giorgiolucca/vagalume-sdk/v/stable)][packagist-url]

SDK não oficial da API do vagalume desenvolvida em PHP (https://api.vagalume.com.br/)

# Como utilizar

## Instalação

```sh
    $ composer require giorgiolucca/vagalume-sdk
```

## Exemplos

```sh
  use GiorgioLucca\VagalumeSdk\Enum\TypeEnum;
  use GiorgioLucca\VagalumeSdk\Vagalume; 
   
  $apiKey = 'j8a9dt8a07a7';
  $sdk = new Vagalume($apiKey);
  
  // Buscando um artista específico
  $artist = $sdk->getArtist('u2');
  
  // Buscando a discografia de um artista
  $discography = $sdk->getDiscography('u2');
  
  // Buscando hotspots
  $hotspots = $sdk->getHotspots();
  
  // Buscando notícias
  $news = $sdk->getNews();
  
  // Buscando rádios
  $radios = $sdk->getRadios(TypeEnum::ARTIST, 'coca-cola-fm');
  
  // Buscando imagem do artista
  $artistId = '3ade68b3gdb86eda3';  
  $artistImage = $sdk->getArtistImage($artistId);
  
  // Realizando uma pesquisa pelo nome do álbum
  $album = $sdk->searchAlbum('U218 Singles');
  
  // Realizando uma pesquisa pelo nome do artista
  $artist = $sdk->searchArtist('Skank');
  
  // Realizando uma pesquisa pelo trecho de uma música
  $music = $sdk->searchMusicExcerpt('Skank vamos fugir');
```

[license-url]: https://poser.pugx.org/giorgiolucca/vagalume-sdk/license
[packagist-url]: https://packagist.org/packages/giorgiolucca/vagalume-sdk
[travis-image]: https://travis-ci.org/giorgiolucca/vagalume-sdk.svg?branch=master
[travis-url]: https://travis-ci.org/giorgiolucca/vagalume-sdk