<?php
 
	require_once('../../config.php');
	global $DB;

 	//nota: para direccionar externamente la url debe empezar por http, de lo contrario moodle cree que la dirección es local.

	$urlext = required_param('urlext', PARAM_RAW);
	$componente = required_param('component', PARAM_RAW);
	$id = required_param('id', PARAM_INT);

	$consul1 = $DB->get_record('block_ns_raes',array('id'=> $id));
	$count = $consul1->click_count;
	$count = $count+1;

	$obj1 = new stdclass;
	$obj1->id = $id;
	$obj1->click_count = $count;

	if (!$DB->update_record('block_ns_raes', $obj1)) {
          print_error('updateerror', 'block_ns_raes');
        }

	//$urlfixed = 'http://'.$urlext;
	redirect($urlext);
