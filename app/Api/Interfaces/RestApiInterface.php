<?php


namespace App\Api\Interfaces;

use Illuminate\Http\Request;

abstract class RestApiInterface implements ApiInterface
{
    private $headers = [];
    const HTTP_METHOD_POST = "POST";
    const HTTP_METHOD_GET = "GET";
    private $http_method;

    private $token = null;
    private $host = null;

    protected $request;

    protected $path;
    protected $args = [];

    public function __construct(Request $request, $method)
    {
        $this->request = $request;
        $this->http_method = $method;

        $this->buildQuery();
    }

    public function getEnv($name)
    {
        $value = env($name, null);

        if (is_null($value)) throw new \RuntimeException("$name not is NULL");

        return $value;
    }

    public function setToken($value)
    {
        $this->token = $value;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setHost($value)
    {
        $this->host = $value;

        return $this;
    }

    public function getHots(): string
    {
        return $this->host;
    }

    public function setPath($value)
    {
        $this->path = $value;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setHeader(array $headers)
    {
        $this->headers = $headers;
    }

    private function getHeaders(): array
    {
        return $this->headers;
    }

    public function request(): ?string
    {
        $url = $this->getHots() . '/' . $this->getPath() . '?' . http_build_query($this->args, '', '&');

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => $this->getHeaders(),
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        if ($this->http_method == self::HTTP_METHOD_POST) {
            curl_setopt($curl, CURLOPT_POST, true);
        }

        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        $ch_info = curl_getinfo($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//        $header = substr($output, 0, $ch_info['header_size']);
        $html = substr($output, $ch_info['header_size']);
        curl_close($curl);

        if ($http_code != 200) {
            $msg = "HTTP code: $http_code error request to $url";
            new \RuntimeException($msg);
            abort($http_code, $msg);
        }

        return $html;
    }

    private function buildQuery()
    {
        foreach ($this->filters() as $filter => $value)
            $this->args[$filter] = $value;
    }

    private function filters()
    {
        return $this->request->all();
    }
}
