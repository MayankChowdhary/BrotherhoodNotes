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
            //echo "Message sent!";
      

}

    
}
    $error = '';
    $name = '';
    $email = '';
    $subject = '';
    $message = '';
    
    if(isset($_POST['submit'])) {
        
        
$servername = "localhost";
$username = "id12113512_brotherhood";
$password = "4201977";
$dbname = "id12113512_student";
$flag=0;
$temp=$_POST['email'];
$lastid=0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `st_email`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
        $sid= $row["st_id"];
        $mailid= $row["email_id"];
         $lastid=$sid+1;
        if($temp==$mailid)
        {
            $flag=1;
        }
     }
    
} else {
     //echo "0 results";
}

$conn->close();
        
   if($flag==1){
      echo '<script language="javascript">';
echo 'alert("You are already our subscriber!")';
echo '</script>';
       
            
   }else{
            
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
        
        $sql = "INSERT INTO st_email ". "(st_id,email_id) ". "VALUES ($lastid,'$temp')";

            if ($conn->query($sql) === TRUE) {
                
                mailer("Thanks for subscribing us!","You are successfully subscribed to Brotherhood Notes. You will receive notifications for further updates.",$temp);
                
                
                 echo '<script language="javascript">';
                echo 'alert("Thank you for subscribing us!.\n You will receive a confirmation E-mail shortly.\n\n Note: Email may land to spambox without any notification. Please move it to Primary mailbox to remove further restrictions.")';
                echo '</script>';
              

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        
    }
}elseif(isset($_POST['submitform'])) {
    

function clean_text($string)
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 return $string;
}

 if(empty($_POST["name"]))
 {
  $error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
 }
 else
 {
  $name = clean_text($_POST["name"]);
  if(!preg_match("/^[a-zA-Z ]*$/",$name))
  {
   $error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
  }
 }
 if(empty($_POST["emailx"]))
 {
  $error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
 }
 else
 {
  $email = clean_text($_POST["emailx"]);
  if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
   $error .= '<p><label class="text-danger">Invalid email format</label></p>';
  }
 }
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
     $message= "Name: ".$name."\nEmail: ".$email."\nMessage: ".$message;
     $subject= "Feedback: ".$subject;
     
     mailer($subject,$message,"mayankchoudhary00@gmail.com");
     
      echo '<script language="javascript">';
                echo 'alert("Message Successfully Sent!.\n")';
                echo '</script>';
     
      $name = '';
      $email = '';
      $subject = '';
      $message = '';
 }
        
}
        

  ?>
    
    
<head>
     <title>Brotherhood Notes</title>
    <link rel="icon" href="brother.png" type="image/png">
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
    <link rel="stylesheet" type="text/css" href="css/toast.css">
    
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "57700726-0d57-4e4f-a599-8eda6fd5dbb6",
      notifyButton: {
        enable: true,
      },
        
        welcomeNotification: {
          "title": "Brotherhood Notes",
          "message": "Thanks for subscribing!",
          // "url": "" /* Leave commented for the notification to not open a window on Chrome and Firefox (on Safari, it opens to your webpage) */
        }
    });
      
  });
</script>
    <script type="text/javascript">
        function confirm_alert(node) {
            return confirm("Download will start shortly. Please Check Notification!");
        }
        
    function launch_toast() {
        var x = document.getElementById("toast")
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>
    
</head>

<body>
  <div class="content">
    <div class="container wow ">
      <div class="row">
       <h1>BROTHERHOOD &nbsp; &nbsp;<br> NOTES&trade;</h1>
          <br><br><br><br>
            <div class="announcements subs-title ">
                <section aria-label="Announcements" class="announcements">
                     <div class="neon font-weight-bold border-bottom pb-3 mt-3 mb-0 pr-5 text-center">Announcements</div>
                </section>
                 <div class="announcements announcement-slider border-r-xs-0 border-r position-relative scroll " id="style-2">
                        <div>
                            <ul   class="nolist list-unstyled position-relative mb-0 px-lg-5 pt-lg-5 " >
                                
                                <?php include("announc.php"); ?> 
                                              
                            </ul>
                        
                        </div>
                    </div>
          </div>
          <br><br><br><br>

          <div class="flux text-center">Downloads</div>
          
<div class="listscroll" id="style-3">
<ul id="expList" >
    <?php include("fifthsem.php"); ?>
    <?php include("forthsem.php"); ?>
    <?php include("thirdsem.php"); ?>
  </ul>
</div>  
  
          <h3 class="text-center " style="color:blueviolet"> <br><br>Subscribe now to get Recent updates!!!<br><br></h3>

        <div class="subcription-info text-center">
          <form class="subscribe_form" method="post">
            <input required="" value="" placeholder="Enter your email..." class="email" id="email" name="email" type="email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$">
            <input class="subscribe" action="#" name="submit" value="Subscribe!" type="submit">
          </form>
            <br><br><br><br>
          <p class="sub-p text-center" >We Promise to never span you.</p>
        </div>
      </div>
    </div>
    <section>
      <div class="container">
        <div class="row bort text-center">
          <div class="social">
            <ul>
              <li>
                <a href="https://www.facebook.com/Mayank1185" target="_blank"><i class="fa fa-facebook"></i></a>
              </li>
              <li>
                <a href="https://www.instagram.com/aap_ka_m.a.y.a.n.k/" target="_blank"><i class="fa fa-instagram"></i></a>
              </li>
              <li>
                <a href="https://stackoverflow.com/users/10016761/mayank-choudhary?tab=profile" target="_blank"><i class="fa fa-rss"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>
      <br><br>
    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 text-center">
            <div class="about-title">
              <h2>About Author</h2>
                <p><u><br>Mayank Choudhary<br></u><br>Directorate of Notes Department, MCA.<br>Masters in Android and Web Application Development.<br><br></p>
            </div>
           <br>
          </div>
        </div>
      </div>
    </section>
    <div id="contact-info">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="contact-title">
              <i class="fa fa-envelope" style="color: #4965ff"></i>
              <h2 style="color: #4965ff">Get in touch</h2>
              <p style="color: #4965ff">Send your Queries, Feedback  &amp; Advice<br>We usually respond within 24 hours</p>
            </div>
          </div>
          <div class="contact col-md-6 wow ">
            <div class="col-md-10 col-md-offset-1">
              <div id="note"></div>
              <div id="sendmessage">Your message has been sent. Thank you!</div>
              <div id="errormessage"></div>
                <?php echo $error; ?>
              <form action="" method="post" role="form" name="feedback" id="feedform" class="contactForm">
                <div class="form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" value="<?php echo $name; ?>" required/>
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailx" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$"  value="<?php echo $email; ?>" required/>
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" value="<?php echo $subject; ?>" required />
                  <div class="validation"></div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message" required><?php echo $message; ?></textarea>
                  <div class="validation"></div>
                </div>

                <div class="text-center" ><button type="submit" class="contact-submit"  name="submitform">Send Message</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div id="toast"><div id="img"> <img src="download.png" alt="download icon" height="42" width="42"> </div><div id="desc">Download Started...</div></div>
  <footer class="footer">
    <div class="container">
      <div class="row bort">
<!-- Start of WebFreeCounter Code -->
<a><img src="https://www.webfreecounter.com/hit.php?id=geuuxocok&nd=6&style=52" border="0" alt="web counter"><b>&nbsp;&nbsp;HITS</b></a>
<!-- End of WebFreeCounter Code -->
          <br><br>
        <div class="copyright">
          Copyright MC-Developers © 2019-20.<br>All rights reserved.
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
    
</body> 

</html>
