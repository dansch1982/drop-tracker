<?php
/**
 * TODO
 */
class Server
{
    private string
        $staticFolder = "";
    private array
        $GET = [],
        $POST = [],
        $default = [],
        $headers = [];
    public function __construct(array $setup = [])
    {
        foreach ($setup as $key => $value) {
            $this->$key = $value;
        }
    }

    public function listen(callable $callback = null)
    {
        $res = new Response($this->headers);

        if (isset($callback)) {
            $callback($res);
        }

        $file = pathinfo($res->url['path']);
        if (!empty($file['extension'])) {
            return $res->file($this->staticFolder, $file["dirname"], $file["basename"]);
        }

        $this->run($res);

    }
    private function run($res) {
        $method = $res->method;
        $uri = isset($res->parts) ? reset($res->parts) : "/";

        try {
            if (isset($this->$method[$uri])) {
                $this->$method[$uri]($res);
            } else if (isset($this->default[$method])) {
                $this->default[$method]($res);
            } else {
                $res->status(404)->message("")->text("404");
            }
        } catch (\Throwable $th) {
            $res->status(500)->message("")->text("Something went wrong");
        }
        exit;
    }
    private function addURI($method, array $func)
    {
        $this->$method = [...$this->$method, ...$func];
    }
    public function get(string $uri, callable $callback, mixed ...$args)
    {
        $this->addURI("GET", [$uri => function ($res) use ($callback, $args) {
            call_user_func($callback, $res, $args);
        }]);
    }
    public function post(string $uri, callable $callback, mixed ...$args)
    {
        $this->addURI("POST", [$uri => function ($res) use ($callback, $args) {
            call_user_func($callback, $res, $args);
        }]);
    }
    public function default(string $method, callable $callback, mixed ...$args)
    {
        $func = [$method => function ($res) use ($callback, $args) {
            call_user_func($callback, $res, $args);
        }];
        $this->default = [...$this->default, ...$func];
    }
    public function static(string $static = "") {
        $this->staticFolder = $static;
    }
};
?>