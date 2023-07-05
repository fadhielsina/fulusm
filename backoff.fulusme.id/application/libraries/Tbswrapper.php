<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once("Tbs_class.php");
require_once("Tbs_plugin_opentbs.php");

class Tbswrapper{

    /**
     * TinyButStrong instance
     *
     * @var object
     */
    private static $TBS = null;
	public $namafile;
	public $folder;

    /**
     * default constructor
     *
     */
    public function __construct(){
        if(self::$TBS == null) 
			self::$TBS = new clsTinyButStrong();
			self::$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    }

    public function tbsLoadTemplate($File, $HtmlCharSet=''){
        return self::$TBS->LoadTemplate($File, OPENTBS_ALREADY_UTF8);
    }

    public function tbsMergeBlock($BlockName, $Source){
        return self::$TBS->MergeBlock($BlockName, $Source);
    }

    public function tbsMergeField($BaseName, $X){
        return self::$TBS->MergeField($BaseName, $X);
    }

    public function tbsRender(){
		//self::$TBS->Plugin(OPENTBS_DEBUG_XML_SHOW);
        self::$TBS->Show(OPENTBS_FILE,$this->folder."\\".$this->namafile);
		
        return self::$TBS->Source;
    }

}


?>