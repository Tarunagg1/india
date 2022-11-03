<?php
  function sendMessage(){
    /*$content = array(
      "en" => 'Hi There, This is 101india welcome message'
      );
    
    $fields = array(
      'app_id' => "bcfda9a7-06af-49b4-85fa-b077b4e15515",
      'included_segments' => array('My Segment'),
      'data' => array("foo" => "bar"),
      'contents' => $content,
	  'url'=> "[node:url]"
    );*/
    
    /*$fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);*/
	
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players/csv_export?app_id=bcfda9a7-06af-49b4-85fa-b077b4e15515");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic NzAxMmU0ZTUtOTdjOS00NWI3LTg4ODQtOWYxM2ExOTcyZWNh',"Cache-Control: no-cache", "Postman-Token: bcfda9a7-06af-49b4-85fa-b077b4e15515"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }
  
    $response = sendMessage();
  //$return["allresponses"] = $response;
  //$return = json_decode( $return);
  
  //print("\n\nJSON received:\n");
  //print_r($return);
  //print("\n");
  
  
  $arrJson = array();
  $arrJson = json_decode($response);
foreach($arrJson as $key=>$value){
    echo "<a href=\"$value\">"."Click here to download csv file"."</a>";
}
  
  
?>