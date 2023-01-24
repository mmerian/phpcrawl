<?php
/**
 * Describes an HTTP response-header within the phpcrawl-system.
 *
 * @package phpcrawl
 */
class PHPCrawlerResponseHeader
{
  /**
   * Initiates an new PHPCrawlerResponseHeader.
   *
   * @param string $header_string A complete response-header as it was sent by the server
   * @param string $source_url    The URL of the website the header was received from.
   * @internal
   */
  public function __construct($header_string, $source_url)
  {
    $this->header_raw = $header_string;
    $this->source_url = $source_url;
    if(is_null($header_string)) {
      error_log("header_string is null", 3, __DIR__ . "/error_log.txt");
    } else {
      error_log($header_string, 3, __DIR__ . "/error_log.txt");
    }
    
    $this->http_status_code = PHPCrawlerUtils::getHTTPStatusCode($header_string);
    $this->content_type = !is_null(PHPCrawlerUtils::getHeaderValue($header_string, "content-type")) ? strtolower(PHPCrawlerUtils::getHeaderValue($header_string, "content-type")) : "null";
    $this->content_length = !is_null(PHPCrawlerUtils::getHeaderValue($header_string, "content-length")) ? strtolower(PHPCrawlerUtils::getHeaderValue($header_string, "content-length")) : "null";
    $this->cookies = PHPCrawlerUtils::getCookiesFromHeader($header_string, $source_url);
    $this->transfer_encoding = !is_null(PHPCrawlerUtils::getHeaderValue($header_string, "transfer-encoding")) ? strtolower(PHPCrawlerUtils::getHeaderValue($header_string, "transfer-encoding")) :"null";
    $this->content_encoding = !is_null(PHPCrawlerUtils::getHeaderValue($header_string, "content-encoding")) ? strtolower(PHPCrawlerUtils::getHeaderValue($header_string, "content-encoding")) :"null";
  }
  
  /**
   * The raw HTTP-header as it was send by the server
   *
   * @var string
   */
  public $header_raw;
  
  /**
   * The HTTP-statuscode
   *
   * @var int
   */
  public $http_status_code;
  
  /**
   * The content-type
   *
   * @var string
   */
  public $content_type;
  
  /**
   * The content-length as stated in the header.
   *
   * @var int
   */
  public $content_length;
  
  /**
   * The content-encoding as stated in the header.
   *
   * @var string
   */
  public $content_encoding;
  
  /**
   * The transfer-encoding as stated in the header.
   *
   * @var string
   */
  public $transfer_encoding;
  
  /**
   * All cookies found in the header
   *
   * @var array Numeric array containing all cookies as {@link PHPCrawlerCookieDescriptor}-objects
   */
  public $cookies  = [];
  
  /**
   * The URL of the website the header was recevied from.
   *
   * @var string
   */
  public $source_url;
}
