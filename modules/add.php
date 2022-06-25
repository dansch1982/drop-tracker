<?php
$add = function ($res) {
    if (isset($res->url["query"]->first) && isset($res->url["query"]->second)) {
        $res->status(200)->text($res->url["query"]->first + $res->url["query"]->second);
    } else {
        $res->status(200)->text("error");
    }
    /* try {
        $res->status(200)->text($res->params->first + $res->params->second);
    } catch (\Throwable $th) {
        $res->status(500)->text($th);
    } */
};
?>