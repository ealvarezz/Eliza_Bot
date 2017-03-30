<?php

Class Transform_Words {

    public $transform_key_words;


    function Transform_Words(){
	  $this->transform_key_words = array(
	  "are" => "am",
	  "am" => "are",
	  "was" => "were",
	  "were" => "was",
	  "you" => "me",
	  "me" => "you",
	  "i" => "you",
	  "@" => "@",
	  "my" => "your",
	  "your" => "my",
	  "i've" => "you've",
	  "you've" => "i've",
	  "i'm" => "you're",
	  "you're" => "i'm",
	  "myself" => "yourself",
	  "yourself" => "myself",
	  "yours" => "mine",
	  "mine" => "yours"
	  
	  );
    }


}

?>
