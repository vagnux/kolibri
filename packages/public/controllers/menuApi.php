<?php

class menuApi extends controller
{

    function index()
    {
        $m = new menuGen();
        page::addBody($m->getJsonMenu());
        page::renderAjax();
    }
}

