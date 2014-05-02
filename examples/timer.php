<?php
date_default_timezone_set('Asia/Shanghai');
swoole_timer_add(3000, function($interval) {
	
    echo "b timer[$interval] :".date("H:i:s")." call\n";
});

swoole_timer_add(1000, function($interval) {
    echo "a timer[$interval] :".date("H:i:s")." call\n";
});
