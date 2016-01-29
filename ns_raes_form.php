<?php
  //require_once("{$CFG->libdir}/formslib.php");
  require_once("$CFG->libdir/formslib.php");

 
  class ns_raes_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        //$contextid= $this->_customdata['contextid'];
        $mform->addElement('header','displayinfo', get_string('textfields', 'block_ns_raes'));
        //titulo
        $mform->addElement('text', 'pagetitle', get_string('pagetitle', 'block_ns_raes'));
        $mform->addRule('pagetitle', null, 'required', null, 'client');
        $mform->setType('pagetitle', PARAM_TEXT);
        //Autor
        $mform->addElement('text','author_name', get_string('author_name','block_ns_raes'));
        $mform->addRule('author_name', null, 'required', null, 'client');
        $mform->setType('author_name', PARAM_TEXT);
        $mform->addElement('text', 'author_lastname', get_string('author_lastname','block_ns_raes'));
        $mform->addRule('author_lastname', null, 'required', null, 'client');
        $mform->setType('author_lastname', PARAM_TEXT);
        //keywords
        $mform->addElement('text','keywords',get_string('keywords','block_ns_raes'));
        $mform->addRule('keywords', null, 'required', null, 'client');
        $mform->setType('keywords', PARAM_TEXT);
        //Select area
        $areas= array('1'=>'Area 1', '2'=>'Area 2', '3'=>'Area 3', '4'=>'Area 4');
        $select = $mform->addElement('select', 'areas', get_string('areas','block_ns_raes'), $areas);

        //Resume
        $mform->addElement('textarea', 'resume', get_string('resume', 'block_ns_raes'),'wrap="virtual" rows="5" cols="50"');
        $mform->setType('resume', PARAM_RAW);
        $mform->addRule('resume', null, 'required', null, 'client');
        //Description
        $mform->addElement('textarea', 'linkdescription', get_string('linkdescription', 'block_ns_raes'),'wrap="virtual" rows="5" cols="50"');
        $mform->setType('linkdescription', PARAM_RAW);
        $mform->addRule('linkdescription', null, 'required', null, 'client');
        //resource type
        $resource_type= array('1'=>'Libro', '2'=>'Animacion', '3'=>'Link');
        $select = $mform->addElement('select', 'resource_type', get_string('recursos','block_ns_raes'), $resource_type);
        //language
        $languages= array('1'=>'English', '2'=>'Spanish');
        $select = $mform->addElement('select', 'languages', get_string('languages','block_ns_raes'), $languages);
        global $COURSE;
        // $filemanager=$mform->addElement('filemanager', 'attachments', get_string('attachment', 'moodle'), null,
        //             array('subdirs' => 0, 'maxbytes' => 8000, 'areamaxbytes' => 10485760, 'maxfiles' => 50,
        //                    'accepted_types' => array('document')));
        // // $this->set_upload_manager(new upload_manager('attachment', true, false, $COURSE, false, 0, true, true, false));
        //     $mform->addElement('file', 'attachment', get_string('attachment', 'forum'));
        //     $mform->addRule('attachment', null, 'required');
        //$this->set_upload_manager(new upload_manager('attachment', true, false, $COURSE, false, 0, true, true, false));
            $mform->addElement('file', 'attachment', get_string('attachment','block_ns_raes'));
            $mform->addRule('attachment', null, 'required');
            $mform->setType('MAX_FILE_SIZE',PARAM_INT);
     



        //----
        
        $mform->addElement('text', 'linkurl', get_string('linkurl', 'block_ns_raes'));
        $mform->addRule('linkurl', null, 'required', null, 'client');
        $mform->setType('linkurl', PARAM_TEXT);
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);
        $mform->addElement('hidden', 'component');
        $mform->setType('component', PARAM_TEXT);
        $mform->addElement('hidden','id','0');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden','status');
        $mform->setType('status', PARAM_INT);
        $mform->addElement('hidden','context');
        $mform->setType('context',PARAM_INT);
        $this->add_action_buttons();
    }
  }