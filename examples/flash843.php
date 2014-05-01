<?php

	

	$serv = new swoole_server("0.0.0.0", 843);
	$serv->addlistener('0.0.0.0', 11843,SWOOLE_SOCK_TCP);
	echo "Flash 843 Server v 0.1  By 709653949@qq.com admin at 11843  start ....\n";
	$serv->set(array(
	    'worker_num' => 1,   //工作进程数量
	    'daemonize' => false, //是否作为守护进程
	));
	$serv->on('connect', function ($serv, $fd){
		$fdinfo = $serv->connection_info($fd);
		$clientinfo="Client ip:".$fdinfo["remote_ip"]." port:".$fdinfo["remote_port"]." to fromport:".$fdinfo["from_port"]." Connected!\n";
		echo $clientinfo;
	});
	$serv->on('receive', function ($serv, $fd, $from_id, $data) {
		
		$info = $serv->connection_info($fd, $from_id);
		
		$recvdata=$data;
		
		if($info['from_port'] == 843) {
			
			
			if(strpos("<policy-file-request/>", $recvdata)!=0){
					
				$serv->close($fd);
			}
			else{
				$response="<?xml version=\"1.0\"?> 
<cross-domain-policy>   
	<site-control permitted-cross-domain-policies=\"all\"/>
	<allow-access-from domain=\"*\" to-ports=\"*\"/>
</cross-domain-policy>\0";
				$serv->send($fd, $response);
				echo "Send 843 ok!\n";//.$response."\n";
				$serv->close($fd);
					
			}
			
			
		}
		else{
			
		echo "Close client data:".$data." connect ok!\n";
			$serv->close($fd);
		}
		
		
		
		
	});
	$serv->on('close', function ($serv, $fd) {
	  	$fdinfo = $serv->connection_info($fd);
		$clientinfo="Client ip:".$fdinfo["remote_ip"]." port:".$fdinfo["remote_port"]." Closed.......\n\n\n";
		echo $clientinfo;
	});
	$serv->start();

?>