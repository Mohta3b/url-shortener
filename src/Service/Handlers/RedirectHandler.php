<?php

namespace Service\Handlers;

use UrlShortener\Http\App;
use UrlShortener\Service\Database;

class RedirectHandler
{

    public function getOriginalUrl($shortUrl)
    {
        $db = App::resolve(Database::class);

        // check if short url exists in db and return long url if exists
        if ($url_query_result = $this->urlQueryResult($shortUrl, $db)) {
            // update number of visits
            $this->incrementNumberofVisits($shortUrl, $db);

            // return the url
            return $url_query_result['url'];
        }

        return null;
    }

    protected function urlQueryResult($url, $database)
    {

        $query_result = $database->query("SELECT * FROM urls WHERE shortUrl = :shortUrl", [
            "shortUrl" => $url
        ])->findOrFail();

        return $query_result;
    }

    protected function incrementNumberOfVisits($url, $database)
    {
        return $database->query("UPDATE urls SET hits = hits + 1 WHERE shortUrl = :url", ['url' => $url]);
    }
}