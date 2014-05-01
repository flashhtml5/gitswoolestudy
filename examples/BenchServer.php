<?php

	$clientcount=0;

	$serv = new swoole_server("0.0.0.0", 10000);
	echo "BenchServer v 0.1  By 709653949@qq.com admin at 10000  start ....\n";
	$serv->set(array(
	    'worker_num' => 10,   //工作进程数量
	    'daemonize' => false, //是否作为守护进程
	));
	$serv->on('connect', function ($serv, $fd){
		global $clientcount;
		$fdinfo = $serv->connection_info($fd);
		$clientcount++;
		$clientinfo="Client ip:".$fdinfo["remote_ip"]." port:".$fdinfo["remote_port"]." to fromport:".$fdinfo["from_port"]." Connected! count=".$clientcount."\n";
		echo $clientinfo;
	});
	$serv->on('receive', function ($serv, $fd, $from_id, $data) {
		
		$info = $serv->connection_info($fd, $from_id);
		
		
	});
	$serv->on('close', function ($serv, $fd) {
		global $clientcount;
	  	$fdinfo = $serv->connection_info($fd);
	  	$clientcount--;
		$clientinfo="Client ip:".$fdinfo["remote_ip"]." port:".$fdinfo["remote_port"]." Closed.......\n";
		echo $clientinfo;
	});
	$serv->start();

?>