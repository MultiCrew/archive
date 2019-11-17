<?php

// PHPMailer stuff
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';

class Academy {

	public function checkPortal($sso, $type=null) {

		// check user type if required
		if (isset($type) && $type=='instr') {	// for instructors

			if ($sso->logged_in() && ($sso->get_user_data('type')=='trngman'||$sso->get_user_data('type')=='instructor'||$sso->get_user_data('type')=='admin')) {
				$hdrLoggedIn = true;
			} else {
				header('LOCATION: '.PROTOCOL.'://portal.'.DOMAIN.'/?rd=academy');
				die();
			}

		} elseif (isset($type) && $type=='trngman') { // for training managers

			if ($sso->logged_in() && ($sso->get_user_data('type')=='trngman'||$sso->get_user_data('type')=='admin')) {
				$hdrLoggedIn = true;
			} else {
				header('LOCATION: '.PROTOCOL.'://portal.'.DOMAIN.'/?rd=academy');
				die();
			}

		} else {		// for all other users

			if ($sso->logged_in()) {
				$hdrLoggedIn = true;
			} else {
				header('LOCATION: '.PROTOCOL.'://portal.'.DOMAIN.'/?rd=academy');
				die();
			}

		}

		return $hdrLoggedIn;

	}

	public function send_mail($sso, $subject, $type, $userid, $connect, $info=null) {

		$mail = new PHPMailer(true);

		$body = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/phpmailer/mail_templates/$type/main.html');
		$altbody = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/phpmailer/mail_templates/$type/alt.txt');

		if ($type=='cert' || $type=='report') {
			$shortcodes = array('/{full name}/');
			$replace = array($sso->get_user_data('name', $userid));

			$body = preg_replace($shortcodes, $replace, $body);
			$altbody = preg_replace($shortcodes, $replace, $altbody);

		}
		elseif ($type=='cancelled') {
			// $shortcodes = array('/{full name}/', '/{date}/', '/{stime}/', '/{ftime}/', '/{acft}/', '/{type}/', '/{type name}/');
			$replace = array($sso->get_user_data('name', $userid));

			$body = preg_replace($shortcodes, $replace, $body);
			$altbody = preg_replace($shortcodes, $replace, $altbody);
		}
		elseif ($type=='new_session'){
			$mysqldate = DateTime::createFromFormat('Y-m-d', $info['date']);
			$date = $mysqldate->format('j M Y');

			$shortcodes = array('/{full name}/', '/{date}/', '/{stime}/', '/{ftime}/', '/{acft}/', '/{instr}/');
			$replace = array($sso->get_user_data('name', $userid), $date, $info['stime'], $info['ftime'], $info['acft'], $info['instr']);

			$body = preg_replace($shortcodes, $replace, $body);
			$altbody = preg_replace($shortcodes, $replace, $altbody);
		}

		//Server settings
		$mail->isMail();
		$mail->Host = 'smtp.zoho.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'noreply@multicrew.co.uk';
		$mail->Password = $connect->mailGetPassword('noreply');
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;

		//Recipients
		$mail->setFrom('noreply@multicrew.co.uk', 'MultiCrew No-Reply');
		$mail->addAddress($sso->get_user_data('email', $userid), $sso->get_user_data('name', $userid));               // Name is optional

		//Content
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $altbody;

		$mail->send();
	}

	public function redirect($url) {

		if (headers_sent()) {
			die('<script type="text/javascript">window.location=\'' .$url.'\'; </script>');
		} else {
			header('LOCATION: '.$url);
			die();
		}

	}

	public function stats($row, $aircraft) {

		if ($row["$aircraft.course"]!=0){ ?>

				<div class="progress card-text mb-3" style="height: 20px;">

				<?php if (($row["$aircraft.course"])=='100'){ ?>
					<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%;">100%</div>
				<?php }
				else{?>
					<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php echo ($row["$aircraft.course"]);?>%"><?php echo ($row["$aircraft.course"]);?>%</div>
				<?php } ?>

				</div>

				<div class="mx-auto text-center">

					<?php if($row["$aircraft.theory"]=='1'){ ?>
					<button class="btn btn-lg btn-success card-text"><strong>Theory: </strong>PASS</button>
					<?php }
					elseif($row["$aircraft.theory"]=='0'){ ?>
						<button class="btn btn-lg btn-danger card-text"><strong>Theory: </strong>FAIL</button>
					<?php }
					elseif($row["$aircraft.theory"]==''){ ?>
						<button class="btn btn-lg btn-warning card-text"><strong>Theory: </strong>N/A</button>
					<?php }

					if($row["$aircraft.practical"]=='1'){ ?>
					<button class="btn btn-lg btn-success card-text"><strong>Practical: </strong>PASS</button>
					<?php }
					elseif($row["$aircraft.practical"]=='0'){ ?>
						<button class="btn btn-lg btn-danger card-text"><strong>Practical: </strong>FAIL</button>
					<?php }
					elseif($row["$aircraft.practical"]==''){ ?>
						<button class="btn btn-lg btn-warning card-text"><strong>Practical: </strong>N/A</button>
					<?php }

					if($row["$aircraft.pass"]==1 && $row["$aircraft.practical"]=='1' && $row["$aircraft.theory"]=='1'){ ?>
						<button class="btn btn-lg btn-success card-text"><strong>Cert: </strong>YES</button>
					<?php }
					else{ ?>
						<button class="btn btn-lg btn-warning card-text"><strong>Cert: </strong>NO</button>
					<?php } ?>

				</div>


		<?php } else { ?>

		<p style="font-size: 1.5rem;"><strong>Not started!</strong></p>

		<?php }

	}

	public function active_course($mysqli, $sso, $ac) {
		$stmt = $mysqli->prepare('SELECT * FROM enrolment WHERE `users.id`=? AND active=? ');
		$users_id = $sso->get_user_data('id');
		$stmt->bind_param("is", $users_id, $ac);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows!=0){
			return true;
		}
		else{
			return false;
		}
		$stmt->close();
	}

	public function session_check($mysqli, $sso) {
		$stmt = $mysqli->prepare('SELECT * FROM sessions WHERE `users.id`=? AND reported=?');
		$reported = 0;
		$user_id = $sso->get_user_data('id');
		$stmt->bind_param("ii", $user_id, $reported);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows!=0){
			return true;
		}
		else{
			return false;
		}
		$stmt->close();

	}

	public function cert_info($row, $ac, $type) {

		if ($row["$ac.course"]=="0" || $row["$ac.course"]==''){
			if ($type == "class"){
				return "table-danger";
			}
			elseif ($type == "text"){
				return "NO";
			}
		}

		elseif ($row["$ac.course"]!="0" && $row["$ac.pass"]!="1"){
			if ($type == "class"){
				return "table-warning";
			}
			elseif ($type == "text"){
				return "IN PROG";
			}
		}

		elseif ($row["$ac.course"]=="100" && $row["$ac.pass"]=="1"){
			if ($type == "class"){
				return "table-success";
			}
			elseif ($type == "text"){
				return "YES";
			}
		}

	}

}

$academy = new Academy();

// check page and login stuff
if (isset($page)) {

	if ($page=='ment' || $page=='reports' || $page=='sessions') {
		$type = 'instr';
		$hdrLoggedIn = $academy->checkPortal($sso, $type);
	} elseif ($page=='mentman' || $page=='cert') {
		$type = 'mgr';
		$hdrLoggedIn = $academy->checkPortal($sso, $type);
	} else {
		$hdrLoggedIn = $academy->checkPortal($sso);
	}

} else {
	$hdrLoggedIn = $academy->checkPortal($sso);
}

$connect->dbDefineCredentials('academy');
$mysqli = $connect->dbConnect();

?>
