<?php
function sendMessage(){



    $content = array(
      "en" => "Music: test by mahbubeh"
      );

$con = str_replace("&amp;","&", $content);

$headings = array(
      "en" => "This is just Test by Mahbubeh!"
      );
 

/*   $fields = array(
      'app_id' => "bcfda9a7-06af-49b4-85fa-b077b4e15515",
      'included_segments' => array('All'),
      'data' => array("foo" => "bar"),
      'headings' => $headings,
      'contents' => $con,
      'url'=> "[node:url]?utm_source=onesignal&utm_medium=pushnotification&utm_campaign=push"
    ); 
*/
$fields = array(
'app_id' => "bcfda9a7-06af-49b4-85fa-b077b4e15515",
'include_player_ids' => array('bff58d95-a5dc-43f0-8316-6165fcd3a361'),
'data' => array("foo" => "bar"),
'headings' => $headings,
'contents' => $con,
 'url'=> "https://www.101india.com/music/jhelumas-alif-101-sufi?utm_source=onesignal&utm_medium=pushnotification&utm_campaign=push"
);
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                           'Authorization: Basic NzAxMmU0ZTUtOTdjOS00NWI3LTg4ODQtOWYxM2ExOTcyZWNh'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }

  
  $response = sendMessage();
  $return["allresponses"] = $response;
  $return = json_encode( $return);
  
  print("\n\nJSON received:\n");
  print($return);
  print("\n");
?>