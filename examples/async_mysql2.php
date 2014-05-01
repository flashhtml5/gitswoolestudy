<?php
if(!function_exists('swoole_get_mysqli_sock')) {
	die("no async_mysql support\n");
}
$db = new mysqli;
$db->connect('127.0.0.1', 'root', '123456', 'paopaogame');
$sql="show tables";
$db->query($sql, MYSQLI_ASYNC);
$readinfo="read mysql back:".$sql;
$count=0;
swoole_event_add(swoole_get_mysqli_sock($db), function($__db_sock) {
    global $db;
    global $readinfo;
    global $count;
    global $sql;
    
//     var_dump($__db_sock);
    $res = $db->reap_async_query();
    var_dump($res->fetch_all(MYSQLI_ASSOC));
    $db->query("SELECT * FROM paopaogame.paopaoaccount limit 0,2;", MYSQLI_ASYNC);
    echo $readinfo." count=".$count."\n";
    $count++;
//     echo "sleep "."1"." second";
    sleep(1);
});
echo "Finish\n";
