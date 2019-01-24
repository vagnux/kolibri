<?php

/*
 * Copyright (C) 2017 vagner
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
final class breadcrumb {

    public static function load($pathArray = array(),$idxActive=0) {
        
        page::addBody('<nav aria-label="breadcrumb"><ol class="breadcrumb">');
        $i=0;
        foreach ( $pathArray as $node ) {
            if ( $i < $idxActive ) {
                page::addBody('<li class="breadcrumb-item">');
            }
            elseif ( $i == $idxActive ) {
                page::addBody('<li class="breadcrumb-item active" aria-current="page">');
            }else{
                page::addBody('<li class="breadcrumb-item next');
            }
            page::addBody('<a href="#">' . $node . '</a></li>');
            $i++;
        }
        
        page::addBody(' </ol></nav>');
        
    }
    
    
    
}

