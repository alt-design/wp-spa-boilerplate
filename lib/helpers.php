<?php

class Helpers
{

    /* ----------------------------------------------------
     * Replaces pesky ' with html entity
     *
     * @param $data
     * @return mixed
     * ---------------------------------------------------- */
    static function alt_json_encode($data)
    {
        return str_replace("'", "&#39;", json_encode($data));
    }

    /* ----------------------------------------------------
     * Dumps the passed variable in a nicely styled <pre></pre>
     * ---------------------------------------------------- */
    static function pre($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}
