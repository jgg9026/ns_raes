<?php
  require_once('../../config.php');
  $fs = get_file_storage();
  $file = $fs->get_file(128, 'block_ns_raes','draft',1454098216, '/', 'Balotimetro.paw');
  //print_object($file);
  //$url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
  $options = array();
  send_stored_file($file, 86400, 0, true, $options);
  //$link=html_writer::link($url,'archivo');
  //echo($link);