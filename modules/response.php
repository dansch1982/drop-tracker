<?php

/**
 * TODO
 */
class Response
{
    private int
        $statusCode = 200;
    private string
        $statusMessage = "";
    public string
        $body = "",
        $method = "";
    public array
        $url;
    private array
        $headers = [],
        $defaultHeaders = [];
    public function __construct(array $defaultHeaders = [])
    {
        foreach ($defaultHeaders as &$header) {
            array_push($this->defaultHeaders, $header);
        }
        if (isset($_SERVER['REDIRECT_URL'])) {
            $this->parts = array_filter(explode("/", $_SERVER['REDIRECT_URL']));
        }
        $this->body = file_get_contents('php://input');
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = parse_url("$_SERVER[REQUEST_SCHEME]://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]");
        if (!empty($this->url["query"])) {
            $this->url["query"] = $this->createQueryObject($this->url["query"]);
        }
    }
    private function path_join(...$parts)
    {
        $partsArray = [];
        foreach ($parts as &$string) {
            if (is_array($string)) {
                $string = join(DIRECTORY_SEPARATOR, $string);
            }
            $string = str_replace(["\\", "/"], DIRECTORY_SEPARATOR, $string);
            $string = trim($string, DIRECTORY_SEPARATOR);
            array_push($partsArray, $string);
        }
        $path = implode(DIRECTORY_SEPARATOR, array_filter($partsArray));
        return $path;
    }
    private function createQueryObject(string $query)
    {
        $object = new stdClass();
        $array = explode("&", $query);
        foreach ($array as &$string) {
            [$key, $value] = [...explode("=", $string), null];
            $object->{$key} = $value;
        }
        return $object;
    }
    public function status(int $code = 200)
    {
        $this->statusCode = $code;
        return $this;
    }
    public function message(string $message = "")
    {
        $this->statusMessage = $message;
        return $this;
    }
    public function json($json = null)
    {
        try {
            $this->end(json_encode($json), "application/json");
        } catch (\Throwable $th) {
            $this->status(500)->message("")->text("Something went wrong");
        }
    }
    public function text(string $text = "")
    {
        $this->end($text, "text/plain");
    }
    public function getMimeType(string $ext = "")
    {

        $array = [
            "png" => "image/png",
            "json" => "applicaiton/json",
            "htm" => "text/html",
            "html" => "text/html",
            "css" => "text/css",
            "txt" => "text/plain",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "png" => "image/png",
            "svg" => "image/svg+xml",
            "gif" => "image/gif",
            "ico" => "image/vnd.microsoft.icon",
            "js" => "text/javascript",
        ];
        return !empty($array[strtolower($ext)]) ? $array[strtolower($ext)] : "application/octet-stream";
    }
    public function file(...$file)
    {
        foreach ($file as &$string) {
            $string = str_replace(["\\", "/"], DIRECTORY_SEPARATOR, $string);
            $string = trim($string, DIRECTORY_SEPARATOR);
        }
        $path = $this->path_join($file);
        $file = pathinfo($path);
        if (file_exists($path)) {
            header('Content-Type: ' . $this->getMimeType($file["extension"]));
            header('Content-Length: ' . filesize($path));
            readfile($path);
        } else {
            $this->status(404)->message("")->text("404");
        }
    }
    public function html(string $html = "")
    {
        $this->end($html, "text/html");
    }
    public function end($data = null, string $mimeType = null)
    {
        if (isset($mimeType)) {
            header("Content-type: $mimeType");
        } else {
            header("Content-type: application/octet-stream");
        }
        $this->configRes();
        echo $data;
    }
    private function configRes()
    {
        header("HTTP/1.1 $this->statusCode $this->statusMessage");
        foreach ([...$this->defaultHeaders, ...$this->headers] as &$header) {
            [$key, $value] = $header;
            header("$key:$value");
        }
    }
    public function setHeader(string $key = "", string $value = "")
    {
        if (!empty($key) && !empty($value)) {
            array_push($this->headers, [$key, $value]);
        }
        return $this;
    }
}
