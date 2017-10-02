<?php

class Helpers
{

    /**
     * Replaces pesky ' with html entity
     *
     * @param $data
     *
     * @return mixed
     */
    static function altJsonEncode($data)
    {
        return str_replace("'", "&#39;", json_encode($data));
    }
}
