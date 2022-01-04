<?php

function dd($param)
{
    echo '<pre style="background-color: rgb(41 37 36); color: rgb(132 204 22); line-height: 20px; position: absolute; top: 0; left: 0; margin: 0; padding: 20px; width: 100%;">';
    exit(var_dump($param));
    echo '</pre>';
}
