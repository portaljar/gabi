<?php
include 'db.php';





 $sql = "UPDATE aire_ac SET " ;
 
 
 
  if (isset($_POST['OnOff'])){ $sql = $sql."OnOff = '".$_POST['OnOff']."'";}
  
   if (isset($_POST['EspOn'])){ $sql = $sql."EspOn = '".$_POST['EspOn']."'";}
  
  if (isset ($_POST['TempIn'])){ $sql = $sql.",TempIn = '".$_POST['TempIn']."'";}
  
  if (isset($_POST['HumIn'])){ $sql = $sql.",HumIn = '".$_POST['HumIn']."'";}
  
  if (isset($_POST['Esp12'])){ $estado[] = array( 'OnOff'=> $row['OnOff'], 'Modo'=> $row['Modo'], 'Fan'=> $row['Fan'],'Temp'=> $row['Temp'],'Swing'=> $row['Swing'],'TimerHr'=> $row['TimerHr'],'TimerDia'=> $row['TimerDia']);
      
      $sql =$sql." WHERE Id=1";

 if ($conn->query($sql) === TRUE) {
		   // echo "OK- ";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		

	$conn->close();
      
  }

$json_string = json_encode($estado);
echo $json_string;

?>