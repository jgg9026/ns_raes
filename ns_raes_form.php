<?php
  //require_once("{$CFG->libdir}/formslib.php");
  require_once("$CFG->libdir/formslib.php");

 
  class ns_raes_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        $itemid = $this->_customdata['itemid'];
        $contextid = $this->_customdata['contextid'];
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
        $areas= array('101'=>'Socio-Humanística - Abogacía',
        '102'=>'Socio-Humanística - Ciencias de la Educación',
        '103'=>'Socio-Humanística - Ciencias Humanísticas y Religiosas',
        '104'=>'Socio-Humanística - Comunicación Social',
        '105'=>'Socio-Humanística - Educación Infantil',
        '106'=>'Socio-Humanística - Inglés',
        '107'=>'Socio-Humanística - Lenguas y Comunicación',
        '108'=>'Socio-Humanística - Psicología',
        '109'=>'Socio-Humanística - Postgrado Derecho Empresarial',
        '110'=>'Socio-Humanística - Maestría en Gerencia y Liderazgo Educacional',
        '201'=>'Administrativa - Administración de empresas',
        '202'=>'Administrativa - Banca y Finanzas',
        '203'=>'Administrativa - Hotelería y Turismo',
        '204'=>'Administrativa - Administración Turística',
        '205'=>'Administrativa - Asistencia Gerencial',
        '206'=>'Administrativa - Contabilidad y Auditoría',
        '207'=>'Administrativa - Economía',
        '208'=>'Administrativa - Secretariado Ejecutivo Bilingüe',
        '209'=>'Administrativa - Administración en Gestión Pública',
        '210'=>'Administrativa - Especialista en Gestión de la Calidad',
        '211'=>'Administrativa - Maestría en auditoria y gestión de la calidad',
        '301'=>'Biológica - Gestión Ambiental',
        '302'=>'Biológica - Bioquímica y Farmacia',
        '303'=>'Biológica - Industrias Agropecuarias',
        '304'=>'Biológica - Ingeniería Agropecuaria',
        '305'=>'Biológica - Ingeniería Química',
        '306'=>'Biológica - Medicina',
        '307'=>'Biológica - Biología',
        '308'=>'Biológica - Maestría en gerencia de la salud y desarrollo local',
        '401'=>'Técnica - Informática',
        '402'=>'Técnica - Geología y Minas',
        '403'=>'Técnica - Ingeniería Civil',
        '404'=>'Técnica - Electrónica ',
        '405'=>'Técnica - Arte y Diseño',
        '406'=>'Técnica - Arquitectura',
        '501'=>'Socio-Humanística - Todas',
        '502'=>'Administrativa - Todas',
        '503'=>'Biológica - Todas',
        '504'=>'Técnica - Todas');
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
        $resource_type= array('1'=>'Recurso Educativo Abierto',
        '2'=>'Animación',
        '3'=>'Artículo',
        '4'=>'Libro',
        '5'=>'Capítulo de Libro',
        '6'=>'Dataset',
        '7'=>'Objeto de Aprendizaje',
        '8'=>'Imagen',
        '9'=>'Imagen, 3D',
        '10'=>'Mapa',
        '11'=>'Partituras',
        '12'=>'Plan o diseño',
        '13'=>'Preimpresión',
        '14'=>'Presentación',
        '15'=>'Grabación, acústico',
        '16'=>'Grabación, musical',
        '17'=>'Grabación, oral',
        '18'=>'Software',
        '19'=>'Reporte Técnico',
        '20'=>'Tesis',
        '21'=>'Video',
        '22'=>'Documento de trabajo',
        '23'=>'Ejercicio',
        '24'=>'Simulación',
        '25'=>'Cuestionario',
        '26'=>'Diagrama',
        '27'=>'Gráfico',
        '28'=>'Tabla',
        '29'=>'Texto narrativo',
        '30'=>'Examen',
        '31'=>'Experimento',
        '32'=>'Autoevaluación',
        '33'=>'Conferencia',
        '34'=>'Evaluación a Distancia',
        '35'=>'Guía Didactica',
        '36'=>'Otro');
        $select = $mform->addElement('select', 'resource_type', get_string('recursos','block_ns_raes'), $resource_type);
        //language
        $languages= array('1'=>'English', '2'=>'Spanish');
        $select = $mform->addElement('select', 'languages', get_string('languages','block_ns_raes'), $languages);
        global $COURSE;
        $mform->addElement('filepicker','attachment', get_string('attachment','block_ns_raes'),null,array('subdirs' => 0, 'maxbytes' => 8000, 'maxfiles' => 1, 'accepted_types' =>'imagen'));
        $draftitemid = file_get_submitted_draft_itemid('attachment');
        file_prepare_draft_area($draftitemid, $contextid, 'block_ns_raes', 'draft', $itemid,  array('subdirs' => 0, 'maxfiles' => 1));
        $entry = new stdClass();
        $fieldname = 'attachment';
        $entry->$fieldname = $draftitemid;
        $this->set_data($entry);
        echo('draftitemidaasasa:');
        print_r($draftitemid);
        echo('contextid;');
        print_r($contextid);
        echo('-----');
        print_r($itemid);
        $mform->addElement('text', 'linkurl', get_string('linkurl', 'block_ns_raes'));
        
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
        $mform->addElement('hidden','context_id');
        $mform->setType('context_id',PARAM_INT);
        $mform->addElement('hidden','file_name');
        $mform->setType('file_name',PARAM_TEXT);
        $mform->addElement('hidden','item_id');
        $mform->setType('item_id',PARAM_INT);
        $mform->addElement('hidden','click_count');
        $mform->setType('click_count',PARAM_INT);
        $this->add_action_buttons();
    }
    function validation($data, $files){
            $errors = array();
            $website = $data['linkurl'];
            $attachment = $data['attachment'];
           // print_object($data);
           // print_object($files);
            if ($website==null && $attachment==null) {
              $errors['linkurl'] = "Agregue una URL o un archivo"; 
            }           
            return $errors;

        }
  }