<?php

	require_once('../../config.php');	
			
	global $DB;
	$tablename = 'block_ns_raes';
	$id = required_param('id', PARAM_INT);	
	$record = $DB->get_record($tablename,array('id'=>$id));		
	$record->click_count += 1;
	$DB->update_record($tablename, $record, $bulk=false);			
	$contextid = required_param('context_id', PARAM_INT);
	$component = 'block_ns_raes';
	$filearea = 'draft';
	$itemid = required_param('itemid', PARAM_INT);	
	$filepath = '/';
	$filename = required_param('filename', PARAM_TEXT);
	$fs = get_file_storage();
	$file = $fs->get_file($contextid, $component, $filearea, 
		$itemid, $filepath, $filename);
	send_stored_file($file, 86400, 0, true, array());	
