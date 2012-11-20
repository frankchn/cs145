<?php

function get_current_time() {
	global $db;
	$data = $db->query('SELECT cur_time FROM Time');
	return end($data->fetch());
}

/* Code from Hawkee - Snippet 2056 @ http://www.hawkee.com/snippet/2056/ */
function duration($seconds, $max_periods = 7) {
	$seconds = abs($seconds);
    $periods = array('year' => 31536000, 'month' => 2419200, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60, 'second' => 1);
    $i = 1;
    foreach ( $periods as $period => $period_seconds ) {
        $period_duration = floor($seconds / $period_seconds);
        $seconds = $seconds % $period_seconds;
        if ( $period_duration == 0 ) continue;
        $duration[] = $period_duration .' '. $period . ($period_duration > 1 ? 's' : '');
        $i++;
        if ( $i > $max_periods ) break;
    }
    if (is_null($duration)) return 'just now';
    return implode(' ', $duration);
}
?>