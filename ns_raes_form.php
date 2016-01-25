<?php
  require_once("{$CFG->libdir}/formslib.php");
 
  class ns_raes_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', get_string('textfields', 'block_ns_raes'));
        $mform->addElement('text', 'pagetitle', get_string('pagetitle', 'block_ns_raes'));
        $mform->addRule('pagetitle', null, 'required', null, 'client');
        $mform->setType('pagetitle', PARAM_TEXT);
        $mform->addElement('textarea', 'linkdescription', get_string('linkdescription', 'block_ns_raes'),'wrap="virtual" rows="5" cols="50"');
        $mform->setType('linkdescription', PARAM_RAW);
        $mform->addRule('linkdescription', null, 'required', null, 'client');
        global $COURSE;
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
        $this->add_action_buttons();
    }
  }