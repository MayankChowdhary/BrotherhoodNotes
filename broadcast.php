<!DOCTYPE html>
<html>

    
<?php
     
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';



function mailer($subject,$message,$address){
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
$mail->Port = 587; // TLS only
$mail->SMTPSecure = 'tls'; // ssl is deprecated
$mail->SMTPAuth = true;
$mail->Username = 'brotherhoodnotes@gmail.com'; // email
$mail->Password = '4201977@m'; // password
$mail->setFrom('brotherhoodnotes@gmail.com', 'Brotherhood Notes'); // From email and name
$mail->addAddress($address, 'Dear'); // to email and name
$mail->Subject = $subject;
$mail->msgHTML($message); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = 'HTML messaging not supported'; // If html emails is not supported by the receiver, show this body
// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
$mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
if(!$mail->send()){
   $errors= "Mailer Error: " . $mail->ErrorInfo;
    
            echo '<script language="javascript">';
            echo 'alert("'.$errors.'")';
            echo '</script>';
    

}else{
           // echo "Message sent!";
      

}

    
}
    $error = '';
    $subject = '';
    $message = '';

        
        
$servername = "localhost";
$username = "id12113512_brotherhood";
$password = "4201977";
$dbname = "id12113512_student";
$count=0;
$countString="Recipient list";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `st_email`";
$result = $conn->query($sql);
$tableString="Sr.No.&nbsp;&nbsp;&nbsp;&nbsp;Email-id";
if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
        $sid= $row["st_id"];
        $mailid= $row["email_id"];
        $count++;
        $tableString= $tableString."\n&nbsp;&nbsp;".$sid."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$mailid;
         
    
         if(isset($_POST['submitform'])) {
             
             send_mail($row["email_id"]);
         }
         
     }
    
    
} else {
    
    
     //echo "0 results";
}
    
$countString=$countString." (".$count.")";
$conn->close();
    
  function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}  


function send_mail($dest_add)
{
 
global $error;
    
 if(empty($_POST["subject"]))
 {
  $error .= '<p><label class="text-danger">Subject is required</label></p>';
 }
 else
 {
  $subject = clean_text($_POST["subject"]);
   
 }
 if(empty($_POST["message"]))
 {
  $error .= '<p><label class="text-danger">Message is required</label></p>';
 }
 else
 {
  $message = clean_text($_POST["message"]);
 }
 if($error == '')
 {
     $message= "Dear Student, \r\n".$message."\r\nFollow below link to download:\r\n https://brotherhoodnotes.000webhostapp.com";
  
     
     mailer($subject,$message,$dest_add);
     
      echo '<script language="javascript">';
                echo 'alert("Message Successfully Sent!.")';
                echo '</script>';
     
    
      $subject = '';
      $message = '';
 }
}
        

  ?>
    
    
<head>
     <title>Brotherhood Broadcaster</title>
     <link rel="shortcut icon" href="brother.png" type="image/png"/>
      <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="MCA Notes by Mayank">
  <meta name="keywords" content="MCA Notes, free CS Notes, Best Computer Science Notes">
     <meta name="author" content="Mayank Choudhary" />
    
  <link href='https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,400italic,300italic,300|Raleway:300,400,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/brotherhood.css">
<link rel="stylesheet" type="text/css" href="css/announce.css">
    
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    
   <link rel="stylesheet" type="text/css" href="css/liststyle.css">
    <link rel="stylesheet" type="text/css" href="css/neonstyle.css">
    <link rel="stylesheet" type="text/css" href="css/glowfont.css">
    
</head>

<body>
    
   
  <div class="content">
    <div class="container wow ">
      <div class="row">
       <h1>BROTHERHOOD &nbsp; &nbsp;<br> NOTES&trade;</h1>
          <br><br><br><br>
          <h3 class="text-center" style="color:#3b43ff;"><?php echo $countString; ?><br></h3>
                <div class="recipients">
                  <textarea class="recipientlist" name="No recipient found!!" readonly spellcheck="false" wrap="off"><?php echo $tableString; ?></textarea>
                  <div class="validation"></div>
                </div>
          <br><br> <br>
          
          <div class="contact wow" style="width:80%; margin:auto;" >
            <div class="col-md-10 col-md-offset-1" >
              <div id="note"></div>
              <div id="sendmessage">Your message has been sent. Thank you!</div>
              <div id="errormessage"></div>
                <?php echo $error; ?>
              <form action="" method="post" role="form" name="feedback" id="feedform" class="contactForm" >
                
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" value="<?php echo $subject; ?>" required />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message" required><?php echo $message; ?></textarea>
                  <div class="validation"></div>
                </div>

                <div class="text-center" ><button type="submit" class="contact-submit"  name="submitform">Send Broadcast</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br>  <br><br>
  <footer class="footer">
    <div class="container">
      <div class="row bort">

        <div class="copyright">
          © Copyright MC-Developers 2019-20. All rights reserved.
          <div class="credits">
            <!--
              All the links in the footer should remain intact. 
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Maundy
            -->
            Designed by <a href="https://www.facebook.com/Mayank1185" target="_blank">Mayank Choudhary</a>
          </div>
        </div>

      </div>
    </div>
  </footer>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/wow.js"></script>
  <script src="js/custom.js"></script>
 <!-- <script src="contactform/contactform.js"></script> -->
 <script src="js/announcx.js"></script>
<script src="js/listscript.js"></script>
<script src="js/brotherhoods.js"></script>

    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

</body>

</html>
