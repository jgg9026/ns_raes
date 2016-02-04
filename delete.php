<?php
  require_once('../../config.php');
  $courseid = required_param('courseid', PARAM_INT);
  $id = optional_param('id', 0, PARAM_INT);
  $confirm = optional_param('confirm', 0, PARAM_INT);
   
  if (!$course = $DB->get_record('course', array('id' => $courseid)))
  {
    print_error('invalidcourse', 'block_ns_raes', $courseid);
  }
  require_login($course);
  if(! $simplehtmlpage = $DB->get_record('block_ns_raes', array('id' => $id))) {
      print_error('nopage', 'block_ns_raes', '', $id);
  }
  $site = get_site();
  $PAGE->set_url('/blocks/ns_raes/view.php', array('id' => $id, 'courseid' => $courseid));
  $heading = $site->fullname . ' :: ' . $course->shortname . ' :: ' . $simplehtmlpage->pagetitle;
  $PAGE->set_heading($heading);
  if (!$confirm)
  {
    $optionsno = new moodle_url('/course/view.php', array('id' => $courseid));
    $optionsyes = new moodle_url('/blocks/ns_raes/delete.php', array('id' => $id, 'courseid' => $courseid, 'confirm' => 1, 'sesskey' => sesskey()));
  }
  else
  {
    if (confirm_sesskey())
    {
      $temp=$DB->get_record('block_ns_raes',array('id'=>$id));
      $temp->status=0;
      if (!$DB->update_record('block_ns_raes',$temp))
      {
        print_error('deleteerror', 'block_ns_raes');
      }
    }
    else 
    {
      print_error('sessionerror', 'block_ns_raes');
    }
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
  }
  echo $OUTPUT->header();
  echo $OUTPUT->confirm(get_string('deletepage', 'block_ns_raes', $simplehtmlpage->pagetitle), $optionsyes, $optionsno);
  echo $OUTPUT->footer();