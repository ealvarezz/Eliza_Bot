<?php

Class Pre_Mesg{

    public $key_dictonary;
    public $built_in_dictionary;
    public $data_parsed;
    public $key_found;
    public $key_word;
    public $question;
    public $offset;
    public $key_index;

    function Pre_Mesg($human_question){

	  $this->data_parsed = false;
	  $this->key_index = 0;
	  $this->offset = 0;
	  $this->key_found = false;
	  $this->question = $human_question;
	  $this->init();
    }

    function init(){

	  if(!$this->data_parsed){
		$this->parse_data();
		$this->data_parsed = true;	
	  }
	  
	  $this->find_keyword();

    }

    function parse_data(){
	  

	  /* File ontaining the key words
		and the file contaiting built in responses */

	  $key_file = file_get_contents("resp_key.json");
	  $built_in_file = file_get_contents("built_in_resp.json");
	  $this->key_dictonary = json_decode($key_file);
	  $this->built_in_dictionary = json_decode($built_in_file);

	  if($this->built_in_dictionary == null)
		var_dump("Built in didn't work");
	  if($this->key_dictonary == null)
		var_dump("key dictionary didn't work");

    }

    function find_keyword(){
	  
	  $count = 0;
	  $results;

	  if($this->data_parsed == false)
		var_dump("Can't find keyword, data failed to be parsed.");

	  foreach($this->key_dictonary as $key=>$value){
		foreach($value as $k=>$v){
		    preg_match_all("/\b" . $k . "\b/", $this->question, $results, PREG_OFFSET_CAPTURE);
		    if(!empty($results[0])){
			  $this->key_found = true;
			  $new_offset = $results[0][count($results[0]) - 1 ][1] + strlen($k);
			  if($new_offset > $this->offset){
				$this->offset = $new_offset;
				$this->key_word = $k;
				$this->key_index = $count;
			  }
		    }

		    $count++;


		}
		$results = null;
	  }

    }

}

?>
