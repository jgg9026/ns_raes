<?php
class block_nsreas extends block_base {
    public function init() {
        $this->title = get_string('simplehtml', 'block_nsreas');
    }
    public function get_content() {
      if ($this->content !== null) {
        return $this->content;
      }
      $this->content         =  new stdClass;
      Global $DB, $COURSE, $PAGE;
      $array = explode('_',$COURSE->shortname);
      $records = $DB->get_records('block_nsreas',array('component'=>$array[2], 'status'=>1));
      $count=0;
      foreach ($records as $record) {
        $count = $count + $record->click_count;
      }
      $showrecords = '';
      $editimgcurl = new moodle_url('/pix/t/editstring.png');
      $deletepicurl = new moodle_url('/pix/t/delete.png');
      $showrecords.=html_writer::start_tag('ul');
      $context = context_course::instance($COURSE->id);
      $canmanage = has_capability('block/nsreas:managepages', $context);
      $canview = has_capability('block/nsreas:viewpages', $context);

      foreach($records as $record)
      {
        $pop=0;
        if($count!=0){
          $pop=round(((($record->click_count)/$count)*100),0, PHP_ROUND_HALF_DOWN);
        }
        $resume_length=strlen($record->resume);
        $description_length=strlen($record->linkdescription);
        if($resume_length>202)
        {
          $resume=substr($record->resume,0,202);
          $resume2=substr($record->resume,202,$resume_length);
          $resume.=' ...';
        }
        else
        {
          $resume=$record->resume;
          $resume2 = '';
        }
        if($description_length>202)
        {
          $description=substr($record->linkdescription,0,202);
          $description2=substr($record->linkdescription,202,$resume_length);
          $description.=' ...';
        }
        else
        {
          $description=$record->linkdescription;
          $description2 = '';
        }
        $showrecords.=html_writer::start_tag('div');
        $showrecords.=html_writer::start_tag('li');
        $showrecords.=html_writer::start_tag('div');
        $showrecords.=html_writer::start_tag('div', array('style'=>'width:63%;position: relative;margin-right: 0px;display: inline-block;'));
        $showrecords .=  html_writer::tag('h4',$record->pagetitle, array ('class'=>'titulo', 'style'=>'margin-left: 0px;font-size: 1.1em;color: firebrick;display: inline-block;text-align: left;'));
        $showrecords.=html_writer::end_tag('div');

        $editurl2 = new moodle_url('/blocks/nsreas/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2], 'id'=>$record->id,'context_id'=>$this->context->id));
        $deleteparam = array('id' => $record->id, 'courseid' => $COURSE->id);
        $deleteurl = new moodle_url('/blocks/nsreas/delete.php', $deleteparam);
        //$urlget = new moodle_url('/blocks/nsreas/test.php', array());
            if ($canmanage)
            {
              $showrecords .= html_writer::start_tag('div',array('style'=>'text-align: right;width:18%;display: inline;margin-right: 0px;    position: relative;left: 21%;'));
                $showrecords .= html_writer::link($editurl2, html_writer::tag('img', '', array('src' => $editimgcurl, 'alt' => 'Edit')),array('style'=>'  display: inline-block;padding-right: 13px;text-align: left;'));
                $showrecords .= html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => 'Delete')),array('style'=>'  display: inline-block;padding-right: 5px;text-align: left;'));
              $showrecords .= html_writer::end_tag('div');
            }else {
            }
          $showrecords.=html_writer::end_tag('div');
            $showrecords.=html_writer::start_tag('div',array('style'=>'top:0%;width: auto;'));
            $showrecords .=  html_writer::tag('h4','Popularidad: '.$pop.'%', array ('class'=>'titulo', 'style'=>'font-size: 0.8em;display: block;text-align: right;padding-left: 132px;'));

        $showrecords.=html_writer::end_tag('div');
        $showrecords .= html_writer::tag('p',$resume, array('title'=>$resume2,'style'=>'text-align: justify;left:10px;'));
        $showrecords .= html_writer::tag('p',$description, array('title'=>$description2,'style'=>'text-align: justify;left:10px;'));

        $showrecords .= html_writer::start_tag('div');
        $showrecords .= html_writer::tag('p','Autor:',array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::tag('p',$record->author_name,array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::tag('p',$record->author_lastname,array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::end_tag('div');
        if($record->file_name!='0'){
          $urldocument = new moodle_url('/blocks/nsreas/download.php',array('context_id'=>$record->context_id
            ,'itemid'=>$record->item_id,'filename'=>$record->file_name,'id'=>$record->id));
          $showrecords .=html_writer::link($urldocument,$record->file_name);
        }
        if($record->linkurl)
        {
          $redirecturl = new moodle_url('/blocks/nsreas/redirect.php', array('urlext'=>$record->linkurl, 'id' => $record->id, 'component'=>$array[2],'context'=>$this->context->id));
          $showrecords .= html_writer::tag('p',html_writer::link($redirecturl, $record->linkurl ,array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;')));
        }
        $showrecords .= '<br>';
        $showrecords.=html_writer::end_tag('li');
        $showrecords.=html_writer::end_tag('div');
      }
      $showrecords.=html_writer::end_tag('ul');
      $this->content->text   = $showrecords;
   
      $url = new moodle_url('/blocks/nsreas/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2],'context_id'=>$this->context->id));
      if (has_capability('block/nsreas:managepages', $context)) {
        $this->content->footer = html_writer::link($url, get_string('addpage', 'block_nsreas'));

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