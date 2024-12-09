<?php

namespace App\Services\URL;

use Embed\Embed;

class URLMetadataService
{
  private $embed;

  public function __construct(Embed $embed)
  {
    $this->embed = $embed;
  }

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

  public function getHTMLStringDocument(string $url): string
  {
    $document = $this->embed->get($url)->getDocument();
    $htmlString = (string) $document;

    return $htmlString;
  }
}
