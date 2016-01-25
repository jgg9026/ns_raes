<?php
 
  require_once('../../config.php');
  require_once('ns_raes_form.php');
   
  global $DB, $OUTPUT, $PAGE, $COURSE;
   

  $courseid = required_param('courseid', PARAM_INT);
  $blockid = required_param('blockid', PARAM_INT);
  $id = optional_param('id', 0, PARAM_INT);
  $component = required_param('component', PARAM_RAW);
  if (!$course = $DB->get_record('course', array('id' => $courseid))) {
      print_error('invalidcourse', 'block_ns_raes', $courseid);
  }
  require_login($course);
  $PAGE->set_url('/blocks/ns_raes/view.php', array('id' => $courseid));
  $PAGE->set_pagelayout('standard');
  $PAGE->set_heading(get_string('edithtml', 'block_ns_raes'));
  $PAGE->set_title('Nuevo Rea');
  $simplehtml = new ns_raes_form();
  $toform['blockid'] = $blockid;
  $toform['courseid'] = $courseid;
  $toform['component'] = $component;
  $toform['id'] = $id;
  $simplehtml->set_data($toform);

  $settingsnode = $PAGE->settingsnav->add(get_string('simplehtmlsettings', 'block_ns_raes'));
  $editurl = new moodle_url('/blocks/ns_raes/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid, 'component'=>$component));
  $editnode = $settingsnode->add(get_string('editpage', 'block_ns_raes'), $editurl);
  $editnode->make_active();
  $url = new moodle_url('/course/view.php', array('id' => $courseid));
  if($simplehtml->is_cancelled()) {
      redirect($url);
  } else if ($simplehtml->get_data()) {
      $fromform=$simplehtml->get_data();
      if ($fromform->id != 0) {
        if (!$DB->update_record('block_ns_raes', $fromform)) {
          print_error('updateerror', 'block_ns_raes');
        }
      } else {
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