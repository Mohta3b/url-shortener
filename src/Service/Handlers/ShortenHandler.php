<?php

namespace Service\Handlers;

use Exception;
use UrlShortener\Http\App;
use UrlShortener\Service\Database;


class ShortenHandler
{
    public function urlShortener($url)
    {
        // validate given url
        if (!$this->urlIsValid($url)) {
            // throw exception
            throw new Exception("Invalid URL", 400);
        }

        // short the given url
        if (!$shortenUrl = $this->createNewShortUrl($url)) {
            throw new Exception("Unable to create new shortened url");
        }
        $creationDate = (new \DateTime())->format('Y-m-d H:i:s');

        // map short url to original url and save it
        if (!$this->saveNewUrl($url, $shortenUrl, $creationDate)) {
            throw new Exception("Unable to save new shortened url");
        }

        return $shortenUrl;
    }

    protected function urlIsValid($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        // check if it's not already shortened url
        return true;
    }

    protected function createNewShortUrl($url)
    {
        // hash
        $url_hash = password_hash($url, PASSWORD_BCRYPT);
        // string to decimal
        $decimal_url = intval(ascii_to_dec($url_hash, 12, 18));
        // convert to base code 62 for compaction
        return to_base($decimal_url, 62);
    }


    protected function saveNewUrl($url, $shortenUrl, $creationDate)
    {
        // save url, shortUrl, creationDate, numberOfVisits in db
        $db = App::resolve(Database::class);
//        dd("hi");
        $short_url = $db->query("SELECT id FROM urls WHERE shortUrl = :shortUrl", [
            "shortUrl" => $shortenUrl
        ])->find();

        if ($short_url) {
            $this->urlShortener($url);
            exit();
        } else {
            $db->query("INSERT INTO urls (shortUrl, url, creationDate) VALUES (:shortUrl, :url, :creationDate)", [
                "shortUrl" => $shortenUrl,
                "url" => $url,
                "creationDate" => $creationDate
            ]);

            return $shortenUrl;
        }
    }

}