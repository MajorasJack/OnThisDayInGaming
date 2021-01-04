<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class MobyGamesService
{
    const CLIENT_URL = 'https://www.mobygames.com/stats/this-day';

    const INCLUDE_LIST = [
        'h2',
        'ul',
    ];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $years = [];

    /**
     * @var array
     */
    protected $data = [];

    /**
     * MobyGamesService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Crawler
     */
    public function crawl()
    {
        return $this->client->request('GET', self::CLIENT_URL);
    }

    public function parseData()
    {
        $this->crawl()->filter('.col-lg-12 > div > *')->each(function (Crawler $tag) {
            if (in_array($tag->nodeName(), self::INCLUDE_LIST)) {
                if (count($this->years) === count($this->data)) {
                    $this->years[] = $tag->html();
                } else {
                    $this->data[] = $tag;
                }
            }
        });

        return collect(array_combine($this->years, $this->data))
            ->map(function (Crawler $data) {
                if (
                    count($data->filter('li')->extract(['_text']))
                    != count($data->filter('a')->extract(['href']))
                ) {
                    return array_combine(
                        $data->filter('li')->extract(['_text']),
                        $data->filter('li')->each(function (Crawler $crawler) {
                            $dataToShift = $crawler->filter('a')->extract(['href']);
                            return array_shift($dataToShift);
                        })
                    );
                }

                return array_combine(
                    $data->filter('li')->extract(['_text']),
                    $data->filter('a')->extract(['href'])
                );
            });
    }
}
