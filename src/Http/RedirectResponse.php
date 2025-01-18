<?php

namespace Vrainsietech\Vrtmvc\Http;

class RedirectResponse extends Response
{
    private $targetUrl;

    function __construct($targetUrl, $statusCode = 302, array $headers = [])
    {
        parent::__construct('', $statusCode, $headers); // Empty content for redirects
        $this->targetUrl = $targetUrl;
        $this->setHeader('Location', $targetUrl);
    }

    function send()
    {
        // Prevent header already sent error if there is any output before the redirect
        if (headers_sent()) {
            echo '<script>window.location.href = "' . $this->targetUrl . '";</script>';
            exit;
        }
        parent::send();
        exit; // Important: Stop further execution after redirect
    }

    /**
     * @param string $path
     * @param array $params
     * @return $this
     */
    static function route(string $path, array $params = []): static
    {
        $url = $path;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return new static($url);
    }
}