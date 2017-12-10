<?php

require_once __DIR__ . "/../debug/DebugBar/HttpDriverInterface.php";
require_once __DIR__ . "/../debug/DebugBar/RequestIdGeneratorInterface.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/DataCollectorInterface.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/MessagesAggregateInterface.php";
require_once __DIR__ . "/../debug/DebugBar/Storage/StorageInterface.php";
require_once __DIR__ . "/../debug/DebugBar/DataFormatter/DataFormatterInterface.php";

require_once __DIR__ . "/../debug/DebugBar/DebugBar.php";
require_once __DIR__ . "/../debug/DebugBar/PhpHttpDriver.php";
require_once __DIR__ . "/../debug/DebugBar/JavascriptRenderer.php";
require_once __DIR__ . "/../debug/DebugBar/StandardDebugBar.php";

require_once __DIR__ . "/../debug/DebugBar/OpenHandler.php";
require_once __DIR__ . "/../debug/DebugBar/DebugBarException.php";
require_once __DIR__ . "/../debug/DebugBar/RequestIdGenerator.php";



require_once __DIR__ . "/../debug/DebugBar/DataCollector/DataCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/Renderable.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/MessagesCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/PDO/TraceablePDO.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/PDO/TracedStatement.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/PDO/PDOCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/PDO/TraceablePDOStatement.php";


require_once __DIR__ . "/../debug/DebugBar/DataCollector/ConfigCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/LocalizationCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/AggregatedCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/MemoryCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/AssetProvider.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/ExceptionsCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/PhpInfoCollector.php";

require_once __DIR__ . "/../debug/DebugBar/DataCollector/RequestDataCollector.php";
require_once __DIR__ . "/../debug/DebugBar/DataCollector/TimeDataCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/SwiftMailer/SwiftLogCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/SwiftMailer/SwiftMailCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/PropelCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/DoctrineCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/Twig/TraceableTwigTemplate.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/Twig/TraceableTwigEnvironment.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/Twig/TwigCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/MonologCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/SlimCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/Propel2Collector.php";
require_once __DIR__ . "/../debug/DebugBar/Bridge/CacheCacheCollector.php";
require_once __DIR__ . "/../debug/DebugBar/Storage/MemcachedStorage.php";

require_once __DIR__ . "/../debug/DebugBar/Storage/RedisStorage.php";
require_once __DIR__ . "/../debug/DebugBar/Storage/FileStorage.php";
require_once __DIR__ . "/../debug/DebugBar/Storage/PdoStorage.php";
require_once __DIR__ . "/../debug/DebugBar/DataFormatter/DebugBarVarDumper.php";
require_once __DIR__ . "/../debug/DebugBar/DataFormatter/VarDumper/DebugBarHtmlDumper.php";
require_once __DIR__ . "/../debug/DebugBar/DataFormatter/VarDumper/SeekingData.php";

require_once __DIR__ . "/../debug/DebugBar/DataFormatter/DataFormatter.php";

use DebugBar\StandardDebugBar;


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

final class debug{
	
	/*private function get_caller_info() {
		$c = '';
		$file = '';
		$func = '';
		$class = '';
		$trace = debug_backtrace();
		if (isset($trace[2])) {
			$file = $trace[1]['file'];
			$func = $trace[2]['function'];
			if ((substr($func, 0, 7) == 'include') || (substr($func, 0, 7) == 'require')) {
				$func = '';
			}
		} else if (isset($trace[1])) {
			$file = $trace[1]['file'];
			$func = '';
		}
		if (isset($trace[3]['class'])) {
			$class = $trace[3]['class'];
			$func = $trace[3]['function'];
			$file = $trace[2]['file'];
		} else if (isset($trace[2]['class'])) {
			$class = $trace[2]['class'];
			$func = $trace[2]['function'];
			$file = $trace[1]['file'];
		}
		if ($file != '') $file = basename($file);
		$c = $file . ": ";
		$c .= ($class != '') ? ":" . $class . "->" : "";
		$c .= ($func != '') ? $func . "(): " : "";
		return($c);
	}
	
	public static function log($msg) {
		$msgOut = "===============================================================\n";
		$msgOut .=  date('Y-m-d H:i:s') . " " .  self::get_caller_info() .  " \n";
		$msgOut .= "===============================================================\n";
		$msgOut .= $msg . "\n";
		$msgOut .= "===============================================================\n";
		//$msgOut .= print_r(debug_backtrace(),true);
		$handle = fopen("/tmp/Kolibri_debug.log", "a+");
		fwrite($handle, $msgOut. "\n");
		fclose($handle);
	}*/
	
	
	public static function log($msg) {
		
				
		
		
		
		
		
		
		
		
		$debugbar = new StandardDebugBar();
		$debugbarRenderer = $debugbar->getJavascriptRenderer();
		$debugbar["messages"]->addMessage($msg);
		
		page::addBody($debugbarRenderer->renderHead());
		page::addBody($debugbarRenderer->render());
		
		
	}
	
}