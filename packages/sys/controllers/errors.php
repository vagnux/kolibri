<?php
/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */

class errors extends  controller{
	function closed() {
		page::addBody("This shit is closed !");
		page::render();
	}
	function notFound(){
		page::addBody("ERRO 404");
		page::render();
		
	}
	function dataError() {
	    page::addBody("ERRO 405");
	    page::render();
	}
}