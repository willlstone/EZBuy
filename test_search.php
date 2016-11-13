<?php
	
	//$json =:
	$obj = jsonString2Obj($_POST['json']);

	echo $obj->name;
	// if (is_array($array) || is_object($array))
	// {
 //    	foreach ($array as $obj)
 //    	{
 //    		foreach ($obj as $value) {
 //    			echo "Hello";
 //    		}
        
 //    	}
	// }
	function jsonString2Obj($str) {
		return json_decode(stripslashes($str));
	}

?>