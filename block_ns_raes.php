<?php
class block_ns_raes extends block_base {
    public function init() {
        $this->title = get_string('simplehtml', 'block_ns_raes');
    }
    public function get_content() {
      if ($this->content !== null) {
        return $this->content;
      }
      $this->content         =  new stdClass;
      Global $DB, $COURSE, $PAGE;
      $array = explode('_',$COURSE->shortname);
      $records = $DB->get_records('block_ns_raes',array('component'=>$array[2], 'status'=>1));   
      $showrecords = '';
      $editimgcurl = new moodle_url('/pix/t/editstring.png');
      $deletepicurl = new moodle_url('/pix/t/delete.png');
      $showrecords.=html_writer::start_tag('ul');
      $context = context_course::instance($COURSE->id);
      $canmanage = has_capability('block/ns_raes:managepages', $context);
      $canview = has_capability('block/ns_raes:viewpages', $context);
      foreach($records as $record){
        $showrecords.=html_writer::start_tag('li');
        $showrecords .=  html_writer::tag('h4',$record->pagetitle, array ('class'=>'titulo', 'style'=>'margin-left: 0px;font-size: 1.1em;color: firebrick;'));
        $showrecords .= html_writer::tag('p',$record->linkdescription, array('class'=>'linkdescription','style'=>'text-align: justify;left:10px;'));
        $temp=html_writer::tag('a',$record->linkurl);
        $showrecords .= html_writer::tag('p',html_writer::tag('a',$record->linkurl),array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;'));
        $editurl2 = new moodle_url('/blocks/ns_raes/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2], 'id'=>$record->id,'context'=>$this->context->id));
        $deleteparam = array('id' => $record->id, 'courseid' => $COURSE->id);
        $deleteurl = new moodle_url('/blocks/ns_raes/delete.php', $deleteparam);
        $urlget = new moodle_url('/blocks/ns_raes/test.php', array());
        if ($canmanage) {
          $showrecords .= html_writer::link($editurl2, html_writer::tag('img', '', array('src' => $editimgcurl, 'alt' => 'Edit')));
          $showrecords .= html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => 'Delete')));
          $showrecords .= html_writer::link($urlget,'Prueba');
        } else {
        }
        $showrecords .= '<br>';
        $showrecords.=html_writer::end_tag('li');
      }
      $showrecords.=html_writer::end_tag('ul');
      $this->content->text   = $showrecords;
   
      $url = new moodle_url('/blocks/ns_raes/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2],'context'=>$this->context->id));
      if (has_capability('block/ns_raes:managepages', $context)) {
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_ns_raes'));

      } else {
        $this->content->footer = '';
      }
      if (! empty($this->config->text)) {
        $this->content->text = $this->config->text;
      }
      return $this->content;

    }
    public function instance_allow_multiple() {
    return false;
    }
    public function applicable_formats() {
    return array(
             'course-view' => true,
      'site'=>false,
      'my'=>false);
    }
}