<?php
  require_once('../../config.php');
  $courseid = required_param('courseid', PARAM_INT);
  $id = optional_param('id', 0, PARAM_INT);
  $confirm = optional_param('confirm', 0, PARAM_INT);
   
  if (!$course = $DB->get_record('course', array('id' => $courseid)))
  {
    print_error('invalidcourse', 'block_nsreas', $courseid);
  }
  require_login($course);
  if(! $simplehtmlpage = $DB->get_record('block_nsreas', array('id' => $id))) {
      print_error('nopage', 'block_nsreas', '', $id);
  }
  $site = get_site();
  $PAGE->set_url('/blocks/nsreas/view.php', array('id' => $id, 'courseid' => $courseid));
  $heading = $site->fullname . ' :: ' . $course->shortname . ' :: ' . $simplehtmlpage->pagetitle;
  $PAGE->set_heading($heading);
  if (!$confirm)
  {
    $optionsno = new moodle_url('/course/view.php', array('id' => $courseid));
    $optionsyes = new moodle_url('/blocks/nsreas/delete.php', array('id' => $id, 'courseid' => $courseid, 'confirm' => 1, 'sesskey' => sesskey()));
  }
  else
  {
    if (confirm_sesskey())
    {
      $temp=$DB->get_record('block_nsreas',array('id'=>$id));
      $temp->status=0;
      if (!$DB->update_record('block_nsreas',$temp))
      {
        print_error('deleteerror', 'block_nsreas');
      }
    }
    else 
    {
      print_error('sessionerror', 'block_nsreas');
    }
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
  }
  echo $OUTPUT->header();
  echo $OUTPUT->confirm(get_string('deletepage', 'block_nsreas', $simplehtmlpage->pagetitle), $optionsyes, $optionsno);
  echo $OUTPUT->footer();