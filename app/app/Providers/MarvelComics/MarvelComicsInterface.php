<?php
namespace App\Providers\MarvelComics;

interface MarvelComicsInterface
{
  public function getCreators($filters = []);
  public function getAuthors($filters = []);
}
