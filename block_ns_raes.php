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
      $count=0;
      foreach ($records as $record) {
        $count = $count + $record->click_count;
      }
      $showrecords = '';
      $editimgcurl = new moodle_url('/pix/t/editstring.png');
      $deletepicurl = new moodle_url('/pix/t/delete.png');
      $showrecords.=html_writer::start_tag('ul');
      $context = context_course::instance($COURSE->id);
      $canmanage = has_capability('block/ns_raes:managepages', $context);
      $canview = has_capability('block/ns_raes:viewpages', $context);

      foreach($records as $record){
        $showrecords.=html_writer::start_tag('li');

          $showrecords.=html_writer::start_tag('div');
            $showrecords .=  html_writer::tag('h4',$record->pagetitle, array ('class'=>'titulo', 'style'=>'margin-left: 0px;font-size: 1.1em;color: firebrick;display: inline-block;text-align: left;'));
            $editurl2 = new moodle_url('/blocks/ns_raes/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2], 'id'=>$record->id,'context_id'=>$this->context->id));
            $deleteparam = array('id' => $record->id, 'courseid' => $COURSE->id);
            $deleteurl = new moodle_url('/blocks/ns_raes/delete.php', $deleteparam);
            $urlget = new moodle_url('/blocks/ns_raes/test.php', array());
            if ($canmanage)
            {
              $showrecords .= html_writer::start_tag('div',array('style'=>'text-align: right;margin-left:55%;display: inline;'));
                $showrecords .= html_writer::link($editurl2, html_writer::tag('img', '', array('src' => $editimgcurl, 'alt' => 'Edit')),array('style'=>'  display: inline-block;padding-right: 13px;text-align: left;'));
                $showrecords .= html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => 'Delete')),array('style'=>'  display: inline-block;padding-right: 5px;text-align: left;'));
              $showrecords .= html_writer::end_tag('div');

              //$showrecords .= html_writer::link($urlget,'Prueba');
            } else {
            }
          $showrecords.=html_writer::end_tag('div');
          //----DIV para la popularidad y los botones de edicion y borrado
            $showrecords.=html_writer::start_tag('div',array('style'=>'top:0%;width: auto;'));
             

            $showrecords .=  html_writer::tag('h4','Popularidad: '.round(((($record->click_count)/$count)*100),0, PHP_ROUND_HALF_DOWN).'%', array ('class'=>'titulo', 'style'=>'font-size: 0.8em;display: block;text-align: right;padding-left: 132px;'));
          //$showrecords.=html_writer::end_tag('div');
        //----DIV para la popularidad y los botones de edicion y borrado


        $showrecords.=html_writer::end_tag('div');
        $showrecords .= html_writer::tag('p',$record->resume);
        $showrecords .= html_writer::tag('p',$record->linkdescription, array('class'=>'linkdescription','style'=>'text-align: justify;left:10px;'));

        $showrecords .= html_writer::start_tag('div');
        $showrecords .= html_writer::tag('p','Autor:',array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::tag('p',$record->author_name,array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::tag('p',$record->author_lastname,array('style'=>'display: inline-block;padding-right: 5px;'));
        $showrecords .= html_writer::end_tag('div');
        if($record->file_name!='0'){
          $urldocument = new moodle_url('/blocks/ns_raes/download.php',array('context_id'=>$record->context_id
            ,'itemid'=>$record->item_id,'filename'=>$record->file_name,'id'=>$record->id));
          $showrecords .=html_writer::link($urldocument,$record->file_name);
        }
        // $showrecords .= html_writer::tag('p',html_writer::tag('a',$record->linkurl),array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;'));
         //lo que introduje nuevo
        if($record->linkurl)
        {
          $redirecturl = new moodle_url('/blocks/ns_raes/redirect.php', array('urlext'=>$record->linkurl, 'id' => $record->id, 'component'=>$array[2],'context'=>$this->context->id));
          $showrecords .= html_writer::tag('p',html_writer::link($redirecturl, $record->linkurl ,array('class'=>'linkurl', 'style'=>'text-align: center;margin-left: 5px;')));
        }
       
        //--------------------------------
        // $editurl2 = new moodle_url('/blocks/ns_raes/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2], 'id'=>$record->id,'context_id'=>$this->context->id));
        // $deleteparam = array('id' => $record->id, 'courseid' => $COURSE->id);
        // $deleteurl = new moodle_url('/blocks/ns_raes/delete.php', $deleteparam);
        // $urlget = new moodle_url('/blocks/ns_raes/test.php', array());
        // if ($canmanage)
        // {
        //   $showrecords .= html_writer::start_tag('div',array('style'=>'text-align: right;'));
        //     $showrecords .= html_writer::link($editurl2, html_writer::tag('img', '', array('src' => $editimgcurl, 'alt' => 'Edit')),array('style'=>'  display: inline-block;padding-right: 5px;text-align: left;'));
        //     $showrecords .= html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => 'Delete')),array('style'=>'  display: inline-block;padding-right: 5px;text-align: left;'));
        //   $showrecords .= html_writer::end_tag('div');

        //   //$showrecords .= html_writer::link($urlget,'Prueba');
        // } else {
        // }
        $showrecords .= '<br>';
        $showrecords.=html_writer::end_tag('li');
      }
      $showrecords.=html_writer::end_tag('ul');
      $this->content->text   = $showrecords;
   
      $url = new moodle_url('/blocks/ns_raes/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id, 'component'=>$array[2],'context_id'=>$this->context->id));
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