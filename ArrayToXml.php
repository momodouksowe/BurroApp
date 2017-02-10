<?php
class ArrayToXml{
			//function defination to convert array to xml
			function array_to_xml($array, &$xml_user_info){

				$video = $xml_user_info->addChild(('User'));

				foreach($array as $key => $value){
                    $video->{0}->addChild("$key",htmlspecialchars("$value"));

    }
 }
}
?>