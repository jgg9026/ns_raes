<?php
 
  require_once('../../config.php');
  require_once('ns_raes_form.php');
   
  global $USER, $DB, $OUTPUT, $PAGE, $COURSE;
  $courseid = required_param('courseid', PARAM_INT);
  $blockid = required_param('blockid', PARAM_INT);
  $id = optional_param('id', 0, PARAM_INT);
  $component = required_param('component', PARAM_RAW);
  $contextid = required_param('context_id',PARAM_INT);
  if (!$course = $DB->get_record('course', array('id' => $courseid)))
  {
      print_error('invalidcourse', 'block_ns_raes', $courseid);
  }
  require_login($course);
  $PAGE->set_url('/blocks/ns_raes/view.php', array('id' => $courseid));
  $PAGE->set_pagelayout('standard');
  $PAGE->set_heading(get_string('edithtml', 'block_ns_raes'));
  $PAGE->set_title('Nuevo Rea');
  $PAGE->set_context(context::instance_by_id($contextid));
  $itemid = new DateTime();
  if($id!=0)
  {
    $ay=$DB->get_record('block_ns_raes', array('id' => $id));
    $iditem=$ay->item_id;
  }
  else
  {
    $iditem=$itemid->getTimestamp();
  }
  
  $simplehtml = new ns_raes_form(null, array('itemid'=>$iditem,'contextid'=>$contextid));
  $toform['blockid'] = $blockid;
  $toform['courseid'] = $courseid;
  $toform['component'] = $component;
  $toform['id'] = $id;
  $toform['status']=1;
  $toform['context_id']=$contextid;
  $simplehtml->set_data($toform);
  $url = new moodle_url('/course/view.php', array('id' => $courseid));
  if($simplehtml->is_cancelled()) {
      redirect($url);
  } 
  else if ($simplehtml->get_data())
  {
      $fromform=$simplehtml->get_data();
      $name = $simplehtml->get_new_filename('attachment');
      
      $simplehtml->save_stored_file('attachment',$contextid,'block_ns_raes','draft',$iditem,'/',$name,true,$USER->id);
      $fromform->file_name=$name;
      $fromform->item_id=$iditem;
      $fromform->context_id=$contextid;
      if($fromform->linkurl!=null)
      {
         if (strpos($fromform->linkurl, 'http')===false){
          print_object(strpos($fromform->linkurl, 'http'));
          $fromform->linkurl = 'http://'.$fromform->linkurl;
        }
      }
      //------------------
      if ($fromform->id != 0)
      {
        $fs = get_file_storage();
 
          $oldentry = $DB->get_record('block_ns_raes',array('id'=>$fromform->id));
          // Prepare file record object
          //print_object($oldentry);          
          $fileinfo = array(
              'component' => 'block_ns_raes',
              'filearea' => 'draft',     // usually = table name
              'itemid' => $oldentry->item_id,               // usually = ID of row in table
              'contextid' => $oldentry->context_id, // ID of context
              'filepath' => '/',           // any path beginning and ending in /
              'filename' => $oldentry->file_name); // any filename
           
          // Get file
          if($fileinfo['itemid']!=$fromform->item_id){
            $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], 
                    $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);                          
            if($file){
              $hash = $file->get_contenthash();          
              $file->delete();
              $filestable = 'files';
              $DB->delete_records($filestable, array('contenthash'=>$hash));              
            }                          
          }

          if (!$DB->update_record('block_ns_raes', $fromform)) {
            print_error('updateerror', 'block_ns_raes');
          }else{

          }
        // if (!$DB->update_record('block_ns_raes', $fromform)) {
        //   print_error('updateerror', 'block_ns_raes');
        // }
      }else
      {
        $fromform->click_count=0;
        if (!$DB->insert_record('block_ns_raes', $fromform)) {
              print_error('inserterror', 'block_ns_raes');
        }
      }
      redirect($url);
  }
  else
  {
    $site = get_site();
    echo $OUTPUT->header();
    if ($id)
    {
      $simplehtmlpage = $DB->get_record('block_ns_raes', array('id' => $id));
      $simplehtml->set_data($simplehtmlpage);
      $simplehtml->display();
    }
    else
    {
      $simplehtml->display();
    }
  }
  echo $OUTPUT->footer();