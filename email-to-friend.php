<?php
include 'config/config.php';
extract($_REQUEST);
$msg = '';
if ( isset($send_emails) && !empty($send_emails) ) {
	
	//var_dump($_REQUEST);
	if ( empty($txtMessage) ) {
		$msg = "Provide your message.";
	} elseif ( empty($txtName) ) {
		$msg = "Provide your name.";
	} elseif ( empty($txtEmail) ) {
		$msg = "Provide your email.";
	} elseif ( !validate_email($txtEmail) ) {
		$msg = "Provide your valid email.";
	} elseif ( !count($txtEmails) ) {
		$msg = "Provide you friend email(s).";
	} else {
            
            /* add footer message to $txtMessage */
            $site_url = siteURL;
            $txtMessage .= "<br/><br/><br/> <a href='{$site_url}'>{$site_url}</a>";
		/* send email here */
		//$txtEmails = explode(';', $txtEmails);
		$card_class = new table_class(TBL_CARDS);
		$card_class->card_id = $item_id;
		$card_class->populate("AND", TRUE);
		$boundary1 = md5("designsoftstudios");
		$boundary2 = md5("dsswebdesign");
		$attachments = add_mail_attachment( SAMPLE_CARDS_BASE . $card_class->card_sample_path, $boundary1);
		$from = "$txtName <$txtEmail>";
$headers = <<<HEADERS
From: $from
Bcc: sobish@designsoftstudios.com
MIME-Version: 1.0
Content-Type: multipart/mixed;
    boundary="$boundary1"
HEADERS;
$message = <<<MESSAGE
This is a multi-part message in MIME format.

--$boundary1
Content-Type: multipart/alternative;
    boundary="$boundary2"

--$boundary2
Content-Type: text/plain;
    charset="windows-1256"
Content-Transfer-Encoding: quoted-printable

$txtMessage
--$boundary2
Content-Type: text/html;
    charset="windows-1256"
Content-Transfer-Encoding: 7bit

$txtMessage

--$boundary2--

$attachments
--$boundary1--
MESSAGE;
		$total_messages = 0;
		foreach( $txtEmails as $to ) {
                    $to = trim($to);
                    if ( validate_email( $to ) ) { // send to only valid email addresses 
                        if ( mail($to, "Send With Style - Card Referred", $message, $headers) ) {
                            $total_messages++;
                        } 
                        sleep(0.5);
                    }
		}
		$msg = "$total_messages messages sent to your friend(s)";
            }
        }

?>
<link href="<?php echo siteURL;?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo siteURL;?>js/jquery.min.js"></script>
<body style="background-color:#ccc">
	<h1 style="text-align: center;">Tell Your Friends <img src="images/icons/x.png" style="float:right; cursor:pointer" onclick="self.parent.tb_remove();" /></h1> 
	<form method="post">
		<p style="float: left; width: 90%; margin: 10px;">
			<label for='txtMessage'>Your Message:</label><br/>
			<textarea style="width:100%; height: 100px;" name="txtMessage" id="txtMessage">I found an invitation I really like. Hope you like it, too!</textarea>
		</p>
		<p style="float: left; width: 45%; margin: 10px;">
			<label for='txtName'>Your Name:</label><br/>
			<input type='text' style="width:95%;" name="txtName" id="txtName" />
		</p>
		<p style="float: left; width: 45%; margin: 10px;">
			<label for='txtEmail'>Your Email:</label><br/>
			<input type='text' style="width:95%;" name="txtEmail" id="txtEmail" />
		</p>
		
		<fieldset style="float: left; width: 90%; margin: 10px;">
			<lagend>Friend Email(s)</lagend><br/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/><br/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/><br/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
			<input type="text" name="txtEmails[]" style="width:33%;" style="margin-bottom:5px"/>
		</fieldset>
			
		<p style="float: left; width: 450px; margin: 10px;">
			<input type='button' value='Cancel' class="btn_normal" onclick="self.parent.tb_remove();" style="float:none!important;"/>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' value='Send' class="btn_normal" id='send_emails' name='send_emails'  style="float:none!important;"/>&nbsp;
		</p>
		<p style="float: left; width: 90%; margin: 10px; color: red; font-weight: bold; ">
		<?php echo $msg; ?>
		</p>
	</form>

</body>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#send_email").live ('click', function() {
			if ( $("#txtMessage").val().trim() == '' ) {
				alert("provide valid message."); return false;
			} else if ( $("#txtName").val().trim() == '' ) {
				alert("provide your name."); return false;
			} else if ( $("#txtEmail").val().trim() == '' ) {
				alert("provide your email."); return false;
			}
			return true;
		});
	});
</script>


