<?php

require "Pre_Mesg.php";
require "Transform_Words.php";

Class Eliza_Generator{
    
    public $human_question_info;
    public $built_in_found;
    public $question;
    public $transform_array;

    function Eliza_Generator($human_question){
	  
	  $this->human_question_info = new Pre_Mesg($human_question);
	  $this->question = $human_question;
	  $this->transform_array = new Transform_Words();
    }

    function generate_response(){


	  $index = $this->human_question_info->key_index;
	  if($this->human_question_info->key_found){
		
		$post_string = $this->generate_post_string();

		$key_array = $this->human_question_info->key_dictonary[$index];
		$key_word = $this->human_question_info->key_word;
		$pre_string = $key_array->{$key_word}[rand(0, count($key_array->{$key_word}) - 1)];
		return preg_replace("/#/", $post_string, $pre_string);
				
	  }
	  else{
		
		foreach($this->human_question_info->built_in_dictionary as $key=>$value){
		    foreach($value as $k=>$v){
			  if(strcmp(trim($this->question), $k) == 0)
				return $v[rand(0, count($v) - 1)];
		    }
		}
	  }
	  
	  return null;	  
    }

    function generate_post_string(){
	    
	  $trim_string = substr($this->question, $this->human_question_info->offset, strlen($this->question));
	  
	  return $this->transform_string($trim_string);  
    }
    
    /**
     * This function is going to transform the remainder string to be added
     * to the response string using regex.
     */

    function transform_string($string){
	  $data_string = "";
	  $count = 0;
	  $result;
	  $even_found = false;
	  $array = $this->transform_array->transform_key_words;
	  $data_string = print_r($array, true);

	  foreach($array as $key=>$value){
		
		if($count % 2 != 0 && $even_found){
		    $data_string .= "skipped at: " . $key;
		    $count++;
		    continue;
		}
		else
		    $even_found = false;

		preg_match("/\b" . $key . "\b/", $string, $result);
		if($result){
		    if($count % 2 == 0)
			  $even_found = true;
		    $string = preg_replace("/\b" . $key . "\b/", $value, $string);
		    $data_string .= "\n" . $string. " ". $key . ", " . $value;
		    
		}
		$count++;
	  }
	  $data_string .= "\n" . $string;
	  file_put_contents("testdata", $data_string);
	  return $string;	  

    }

}


?>
