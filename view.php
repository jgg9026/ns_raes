<?php
 
  require_once('../../config.php');
  require_once('ns_raes_form.php');
   
  global $USER, $DB, $OUTPUT, $PAGE, $COURSE;
   

  $courseid = required_param('courseid', PARAM_INT);
  $blockid = required_param('blockid', PARAM_INT);
  $id = optional_param('id', 0, PARAM_INT);
  $component = required_param('component', PARAM_RAW);
  $contextid = required_param('context_id',PARAM_INT);
  if (!$course = $DB->get_record('course', array('id' => $courseid))) {
      print_error('invalidcourse', 'block_ns_raes', $courseid);
  }
  require_login($course);
  $PAGE->set_url('/blocks/ns_raes/view.php', array('id' => $courseid));
  $PAGE->set_pagelayout('standard');
  $PAGE->set_heading(get_string('edithtml', 'block_ns_raes'));
  $PAGE->set_title('Nuevo Rea');
  $PAGE->set_context(context::instance_by_id($contextid));
  $simplehtml = new ns_raes_form();
  $toform['blockid'] = $blockid;
  $toform['courseid'] = $courseid;
  $toform['component'] = $component;
  $toform['id'] = $id;
  $toform['status']=1;
  $toform['context_id']=$contextid;

  $simplehtml->set_data($toform);

  $settingsnode = $PAGE->settingsnav->add(get_string('simplehtmlsettings', 'block_ns_raes'));
  $editurl = new moodle_url('/blocks/ns_raes/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid, 'component'=>$component,'context'=>$contextid));
  $editnode = $settingsnode->add(get_string('editpage', 'block_ns_raes'), $editurl);
  $editnode->make_active();
  $url = new moodle_url('/course/view.php', array('id' => $courseid));
  if($simplehtml->is_cancelled()) {
      redirect($url);
  } else if ($simplehtml->get_data()) {
      $fromform=$simplehtml->get_data();
      //$saveurl = new moodle_url('/blocks/ns_raes/db'));
      $name = $simplehtml->get_new_filename('attachment');
      //print_r($name);
      $itemid = new DateTime();
      $iditem=$itemid->getTimestamp();
      $simplehtml->save_stored_file('attachment',$contextid,'block_ns_raes','draft',$iditem,'/',$name,true,$USER->id);
      $fromform->file_name=$name;
      $fromform->item_id=$iditem;
      $fromform->context_id=$contextid;
      if (strpos($fromform->linkurl, 'http')===false){
          print_object(strpos($fromform->linkurl, 'http'));
          $fromform->linkurl = 'http://'.$fromform->linkurl;
        }
      if ($fromform->id != 0)
      {
        if (!$DB->update_record('block_ns_raes', $fromform)) {
          print_error('updateerror', 'block_ns_raes');
        }
      }else
      {
        $fromform->click_count=0;
        if (!$DB->insert_record('block_ns_raes', $fromform)) {
              print_error('inserterror', 'block_ns_raes');
        }
      }
      redirect($url);
  } else {
      $site = get_site();
      echo $OUTPUT->header();
      if ($id) {
        $simplehtmlpage = $DB->get_record('block_ns_raes', array('id' => $id));
        if($viewpage) {
          //block_simplehtml_print_page($simplehtmlpage);
        } else {
          $simplehtml->set_data($simplehtmlpage);
          $simplehtml->display();
          }
        } else {
          $simplehtml->display();
          }
  }
?>