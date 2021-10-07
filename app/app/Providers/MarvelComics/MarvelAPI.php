<?php
namespace App\Providers\MarvelComics;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

class Client implements MarvelComicsInterface
{
    const BASE_URL = 'https://gateway.marvel.com/v1/public';
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getCreators($filters = [])
    {
        $result = $this->sendRequest('creators', $filters) ?: [];

        // TODO: PROCESS RESULT

        return $result;
    }

    public function getCreatorComics(
        $creatorId,
        $filters = []
    ) {
        $result = $this->sendRequest(
            spintf('creators/%s/comics', $creatorId),
            $filters
        ) ?: [];

        // TODO: PROCESS RESULT

        return $result;
    }

    protected function sendRequest(
        $url,
        $params = []
    ) {
        $result = false;
        try {
            $timestamp = time();
            $hash = md5($timestamp . config('MARVEL_PRIVATE_KEY') . config('MARVEL_PUBLIC_KEY'));
            $response = Http::get(
                sprintf('%s/%s', static::BASE_URL, $url),
                array_merge($params, [
                    'apiKey' => config('MARVEL_PUBLIC_KEY'),
                    'hash' =>  $hash,
                    'ts' => $timestamp,
                ])
            );
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $ex) {
            $this->logger->error(
                spintf('Error in fetching from Marvel API with error: %s', $ex->getMessage()),
                [
                    'exception' => $ex,
                    'url' => $url,
                    'params' => $params
                ]
            );
            $result = false;
        }

        return $result
    }
}
