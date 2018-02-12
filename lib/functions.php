<?php

/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */
function getPackageName($target)
{
    if ($target) {
        $ctrl = getcwd() . "/packages/";
        // echo $ctrl;
        // debug::log ( "Opening dir $ctrl" );
        $fl = opendir($ctrl);
        while (false !== ($folder = readdir($fl))) {
            if (! ($folder == ".") xor ($folder == "..")) {
                
                if (is_dir($ctrl . "/" . $folder)) {
                    // echo "Abrindo " . $ctrl . $folder . "/controllers/<br>";
                    // debug::log ( "Openning " . $ctrl . $folder . "/controllers/" );
                    if (is_dir($ctrl . $folder . "/controllers/")) {
                        $pkg = opendir($ctrl . $folder . "/controllers/");
                        while (false !== ($folderSub = readdir($pkg))) {
                            // debug::log ( "finding " . $ctrl . $folder . "/controllers/$target" );
                            if (! ($folderSub == ".") xor ($folderSub == "..")) {
                                list ($file, $type) = explode('.', $folderSub);
                                if ($file == $target) {
                                    // debug::log ( "$target found in $folder" );
                                    $package = $folder;
                                }
                            }
                        }
                    } else {
                        mkdir($ctrl . $folder . "/controllers/", 0700);
                        mkdir($ctrl . $folder . "/models/", 0700);
                        mkdir($ctrl . $folder . "/views/", 0700);
                    }
                }
            }
        }
    }
    return $package;
}

function __autoload($class)
{
    // echo "<br>Chamando $class</br>";
    global $pkg;
    if (file_exists("packages/$pkg/models/$class" . ".php")) {
        // echo "classe $class carregada<br>";
        require_once ("packages/$pkg/models/$class" . ".php");
    }
    if (file_exists("packages/$pkg/views/$class" . ".php")) {
        require_once ("packages/$pkg/views/$class" . ".php");
        // echo "classe $class carregada<br>";
    }
    if (file_exists("plugins/$class/$class" . ".php")) {
        require_once ("plugins/$class/$class" . ".php");
        // echo "classe $class carregada<br>";
    }
}

function is_https()
{
    if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 1) {
        return TRUE;
    } elseif (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
        return TRUE;
    } else {
        return FALSE;
    }
}

function getUrlTarget($url)
{
    $urlend = explode('index.php',$url);
    $dataUrl = explode("/", $urlend[1]);
    $size = count($dataUrl);
    
    for ($x = $size; $x > 0; $x --) {
        if (! (strpos($dataUrl[$x], '?')) and ! (strpos($dataUrl[$x], '.php')) and ! (strpos($dataUrl[$x], 'http')) and ! (strpos($dataUrl[$x], $_SERVER['HTTP_HOST'])) and (strlen($dataUrl[$x]) > 0)) {
            $aux[] = $dataUrl[$x];
        }
    }
    
    $urlSite = explode("index.php", $url);
    
    $out['siteRoot'] = $urlSite[0];
    
    if ($aux[0]) {
        $out['method'] = $aux[0];
    } else {
        $out['method'] = config::defaultMethod();
    }
    if ($aux[1]) {
        $out['controller'] = $aux[1];
    } else {
        $out['controller'] = config::defaultController();
    }
    
    debug::log(print_r($out,true));
    
    return $out;
}