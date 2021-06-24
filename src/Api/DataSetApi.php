<?php
declare(strict_types=1);

/**
 * DataSetApi.
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  DocuSign\Monitor
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Monitor API
 *
 * Use the DocuSign Monitor API to receive a data feed containing atypical security events within your DocuSign account. This data goes directly to an integrated application or website.
 *
 * OpenAPI spec version: v2.0
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.13-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\Monitor\Api\DataSetApi;


class GetStreamOptions
{
    /**
      * $cursor The cursor value to continue querying the data with. For an intial call, use empty string
      * @var ?string
      */
    protected ?string $cursor = null;

    /**
     * Gets cursor
     * @return ?string
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Sets cursor
     * @param ?string $cursor The cursor value to continue querying the data with. For an intial call, use empty string
     * @return self
     */
    public function setCursor(?string $cursor): self
    {
        $this->cursor = $cursor;
        return $this;
    }
    /**
      * $limit The maximum number of records to return, minimum of 1, maximum of 2000. Defaults to 1000 if no value is provided
      * @var ?int
      */
    protected ?int $limit = null;

    /**
     * Gets limit
     * @return ?int
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Sets limit
     * @param ?int $limit The maximum number of records to return, minimum of 1, maximum of 2000. Defaults to 1000 if no value is provided
     * @return self
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
}



namespace DocuSign\Monitor\Api;

use DocuSign\Monitor\Client\ApiClient;
use DocuSign\Monitor\Client\ApiException;
use DocuSign\Monitor\Configuration;
use DocuSign\Monitor\ObjectSerializer;

/**
 * DataSetApi Class Doc Comment
 *
 * @category Class
 * @package  DocuSign\Monitor
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class DataSetApi
{
    /**
     * API Client
     *
     * @var ApiClient instance of the ApiClient
     */
    protected ApiClient $apiClient;

    /**
     * Constructor
     *
     * @param ApiClient|null $apiClient The api client to use
     * @return void
     */
    public function __construct(ApiClient $apiClient = null)
    {
        $this->apiClient = $apiClient ?? new ApiClient();
    }

    /**
     * Get API client
     *
     * @return ApiClient get the API client
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param ApiClient $apiClient set the API client
     *
     * @return self
     */
    public function setApiClient(ApiClient $apiClient): self
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
    * Update $resourcePath with $
    *
    * @param string $resourcePath
    * @param string $baseName
    * @param string $paramName
    *
    * @return string
    */
    public function updateResourcePath(string $resourcePath, string $baseName, string $paramName): string
    {
        return str_replace(
            "{" . $baseName . "}",
            $this->apiClient->getSerializer()->toPathValue($paramName),
            $resourcePath
        );
    }


    /**
     * Operation getStream
     *
     * 
     *
     * @param ?string $data_set_name The name of the dataset to stream
     * @param ?string $version The requested API version
     * @param  \DocuSign\Monitor\Api\DataSetApi\GetStreamOptions for modifying the behavior of the function. (optional)
     * @throws ApiException on non-2xx response
     * @return \DocuSign\Monitor\Model\CursoredResult
     */
    public function getStream($data_set_name, $version, \DocuSign\Monitor\Api\DataSetApi\GetStreamOptions $options = null): \DocuSign\Monitor\Model\CursoredResult
    {
        list($response) = $this->getStreamWithHttpInfo($data_set_name, $version, $options);
        return $response;
    }

    /**
     * Operation getStreamWithHttpInfo
     *
     * 
     *
     * @param ?string $data_set_name The name of the dataset to stream
     * @param ?string $version The requested API version
     * @param  \DocuSign\Monitor\Api\DataSetApi\GetStreamOptions for modifying the behavior of the function. (optional)
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\Monitor\Model\CursoredResult, HTTP status code, HTTP response headers (array of strings)
     */
    public function getStreamWithHttpInfo($data_set_name, $version, \DocuSign\Monitor\Api\DataSetApi\GetStreamOptions $options = null): array
    {
        // verify the required parameter 'data_set_name' is set
        if ($data_set_name === null) {
            throw new \InvalidArgumentException('Missing the required parameter $data_set_name when calling getStream');
        }
        // verify the required parameter 'version' is set
        if ($version === null) {
            throw new \InvalidArgumentException('Missing the required parameter $version when calling getStream');
        }
        // parse inputs
        $resourcePath = "/api/v{version}/datasets/{dataSetName}/stream";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json']);

        if ($options != null)
        {
            // query params
            if ($options->getCursor() != 'null') {
                $queryParams['cursor'] = $this->apiClient->getSerializer()->toQueryValue($options->getCursor());
            }
            if ($options->getLimit() != 'null') {
                $queryParams['limit'] = $this->apiClient->getSerializer()->toQueryValue($options->getLimit());
            }
        }

        // path params
        if ($data_set_name !== null) {
            $resourcePath = self::updateResourcePath($resourcePath, "dataSetName", $data_set_name);
        }
        // path params
        if ($version !== null) {
            $resourcePath = self::updateResourcePath($resourcePath, "version", $version);
        }

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\Monitor\Model\CursoredResult',
                '/api/v{version}/datasets/{dataSetName}/stream'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\Monitor\Model\CursoredResult', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Monitor\Model\CursoredResult', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }
}
