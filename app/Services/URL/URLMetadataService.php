<?php

namespace App\Services\URL;

use Embed\Embed;

class URLMetadataService
{
  private $embed;

  /**
   * Creates a new instance of the URLMetadataService with the given Embed object.
   * @param Embed $embed The Embed object to use for fetching metadata.
   */
  public function __construct(Embed $embed)
  {
    $this->embed = $embed;
  }

  /**
   * Given a URL, this method fetches metadata about the job listing and its
   * provider using the Embed library. The returned array contains the page
   * title, company name, job listing URL, company URL, and image URL.
   * @param string $url The URL of the job listing to fetch metadata for.
   * @return array An associative array with the metadata for the job listing.
   */
  public function getMetaData(string $url): array
  {
    $embedData = $this->embed->get($url);

    return [
      'page_title' => $embedData->title ?? "Page Title Placeholder",
      'company_name' => $embedData->providerName,
      'listing_url' => $embedData->url,
      'company_url' => $embedData->providerUrl,
      'img_url' => $embedData->icon ?? $embedData->favicon,
    ];
  }

  /**
   * Given a URL, this method fetches the HTML document of the job listing page
   * and returns it as a string using the Embed library. The returned string is
   * a representation of the HTML document of the job listing page.
   * @param string $url The URL of the job listing to fetch the HTML document for.
   * @return string The HTML document of the job listing page as a string.
   */
  public function getHTMLStringDocument(string $url): string
  {
    $document = $this->embed->get($url)->getDocument();
    $htmlString = (string) $document;

    return $htmlString;
  }
}
