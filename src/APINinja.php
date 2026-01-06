<?php

namespace BataBoom\APINinja;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Config;

class APINinja {

	protected string $baseUrl;
    protected array $defaultHeaders;
    protected int $timeout;
    
    public function __construct() 
    {
        $this->baseUrl = rtrim('https://api.api-ninjas.com/v1', '/');
        $this->defaultHeaders = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Api-Key' => Config::get('apininja.api_key'),
        ];
        $this->timeout = 20;
    }

    /**
     * Make a GET request
     *	@param $endpoint
     *  @param $query
     */
    public function get(?string $endpoint = 'nutrition', ?array $query = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders)
                //->get($this->baseUrl, $query);
                ->get("{$this->baseUrl}/{$endpoint}", $query);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Make a POST request
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders)
                ->post("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Make a PUT request
     */
    public function put(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders)
                ->put("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Make a PATCH request
     */
    public function patch(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders)
                ->patch("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Make a DELETE request
     */
    public function delete(string $endpoint, array $data = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders)
                ->delete("{$this->baseUrl}/{$endpoint}", $data);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

    /**
     * Handle and validate the response
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        }

        // Handle client errors (4xx)
        if ($response->clientError()) {
            throw new Exception(
                "Client error: {$response->body()}",
                $response->status()
            );
        }

        // Handle server errors (5xx)
        if ($response->serverError()) {
            throw new Exception(
                "Server error: {$response->body()}",
                $response->status()
            );
        }

        throw new Exception(
            "Unexpected response status: {$response->status()}",
            $response->status()
        );
    }

    /**
     * Make a custom request with full control
     */
    public function request(string $method, string $endpoint, array $options = []): array
    {
        try {
            $http = Http::timeout($this->timeout)
                ->withHeaders($this->defaultHeaders);

            // Apply any additional options
            if (isset($options['headers'])) {
                $http->withHeaders($options['headers']);
            }

            if (isset($options['query'])) {
                $http->withQueryParameters($options['query']);
            }

            $response = $http->send($method, "{$this->baseUrl}/{$endpoint}", $options['data'] ?? []);

            return $this->handleResponse($response);
        } catch (ConnectionException $e) {
            throw new Exception("Connection failed: {$e->getMessage()}", 0, $e);
        } catch (RequestException $e) {
            throw new Exception("Request failed: {$e->getMessage()}", $e->response->status(), $e);
        } catch (Exception $e) {
            throw new Exception("API request error: {$e->getMessage()}", 0, $e);
        }
    }

}
