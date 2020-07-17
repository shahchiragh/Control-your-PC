
<?php
require 'PushBullet.class.php';// Class that contains most Push Bullet fucntions to get/post data
com_load_typelib('Word.Application');
try {
  #### Get methods
  //FUnction to open new word and start typing..
  function type_word($got_message){
  // echo "Inside type";
   $word = new COM('word.application') or die('Unable to load Word');
	 $word->Documents->Add();
	 $word ->Visible = 1;
	 $word ->Selection->TypeText($got_message);
   $word->Selection->InsertBreak(6);
   $word->Documents[1]->SaveAs("C:/xampp/htdocs/control_pc/new_document.docx");
   $word->ActiveDocument->Close(false);
   $word->Quit();
   $word = null;
   //unset($word); 
   
}
//FUnction to open new word and start typing from remote PC..
function type_chirag_word($got_message){
  // echo "Inside type";

   $word = new COM('word.application') or die('Unable to load Word');
   $word->Documents->Add();
   $word ->Visible = 1;
   $word ->Selection->TypeText($got_message);
   $word->Selection->InsertBreak(6);
   $word->Documents[1]->SaveAs("C:/xampp/htdocs/control_pc/new_document_remote.docx");
   $word->ActiveDocument->Close(false);
   $word->Quit();
   $word = null;
   //unset($word); 
   
}
//FUnction to open existing document word and start typing..
function continue_word($got_message){
  //echo "inside contine";
 /*$obj = com_get_active_object("Word.Application"); //Fails!
  if ($obj) {
  echo("<p>Object Found</p>");
  } else {
  echo("<p>Object NOT Found</p>");
  }*/
  try {
     $word = new COM('word.application') or die('Unable to load Word');
     $doc = $word->Documents->Open("C:/xampp/htdocs/control_pc/new_document.docx");
     $word ->Visible = 1;
     //$word->Selection->Collapse Direction('wdCollapseEnd');
     $word->Selection->TypeText($got_message);
     $word->Selection->InsertBreak(6);
     //$wordsCo= $word->ActiveDocument->Words->Count;
     $word->Documents[1]->SaveAs("C:/xampp/htdocs/control_pc/new_document.docx");
     $word->ActiveDocument->Close(false);
     $word->Quit();
     $word = null;
    //echo "Total words".$wordsCo;
  }
  catch (Exception $e1){
    echo $e1->getMessage();
  }	
}
//FUnction to open exisiting word and and save it as ..
function save_word($got_message){
  $word = new COM('word.application') or die('Unable to load Word');
     $doc = $word->Documents->Open("C:/xampp/htdocs/control_pc/new_document.docx");
     $word ->Visible = 1;
	 $word->Documents[1]->SaveAs("E:/UTA/".$got_message);
   //$word->Documents[1]->SaveAs("C:/xampp/htdocs/control_pc/new_document.docx");
     $word->ActiveDocument->Close(false);
     $word->Quit();
     $word = null;	
}
//FUnction to open just a fresh new word document..
function open_word(){
 $word = new COM('word.application') or die('Unable to load Word');
 $doc = $word->Documents->Add();
 $word ->Visible = 1;
  //$word->Selection->TypeText(" ".$got_message); 
}
//FUnction to open saved word file..
function saved_word(){
 $word = new COM('word.application') or die('Unable to load Word');
 $doc = $word->Documents->Open("C:/xampp/htdocs/control_pc/new_document.docx");
 $word ->Visible = 1;
  //$word->Selection->TypeText(" ".$got_message); 
}
//FUnction to Close all documents..
function close_word(){
 $word = new COM('word.application') or die('Unable to load Word');
$word->ActiveDocument->Close(false);
$word->Quit();
  $word = null;
  //$word->Selection->TypeText(" ".$got_message); 
}

//function get_response(){
#### AUTHENTICATION ####
// Get your API key here: https://www.pushbullet.com/account
$p = new PushBullet('o.qttbnrlCEJkwTQvu91RZDZeEbBxUYtKK');
  $response = $p->getPushHistory(1543283076);
  $got_command ='';
  $got_message = '';
  $is_dismissed ='';
  $identity ='';
  foreach($response as $key => $value){
    if($key == 'pushes'){
      foreach($value as $k1 => $v1){
        if($k1 == 0){
          // /print_r($v1);
          foreach($v1 as $k2 =>$v2){
            //print_r($v2);
              if($k2 == 'title'){
                $got_command = strtolower($v2);
                echo "Command: ".$got_command. "\n"; //Getting the command and message from PUshbullet..
               }
               if($k2 == 'body'){
                $got_message=$v2;
                //echo "".$got_message. "\n";
               } 
          }
        }
      }
    }
  }
  // a quick switch case scene for navigating through various comments
  if ($is_dismissed != 1){
    //$p->dismissPush($identity);
    switch($got_command){
      case 'open': open_word();
                break;
       case 'open word chirag': open_word();
                break;         
      case 'type': type_word($got_message);
             break;
      case 'type chirag': type_chirag_word($got_message);
             break;
      case 'write': type_word($got_message);
             break;       
      case 'continue': continue_word($got_message);
             break;
      case 'save as': save_word($got_message);
             break;
      case 'saved word': saved_word();
             break; 
      case 'close': saved_word();
             break;                
      default: echo "Found no commands";
           break;
    }  
}
//}
  
} catch (PushBulletException $e) {
  // Exception handling
  die($e->getMessage());
}

?>