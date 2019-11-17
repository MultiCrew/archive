<?php

include $_SERVER['DOCUMENT_ROOT'].'/../config.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'phpmailer/vendor/autoload.php';

$sso_db = $sso->db;

class Copilot {

	public function redirect($url) {
		if(headers_sent()){
			die('<script type="text/javascript">window.location=\'' .$url.'\'; </script>');
		}
		else{
			header('LOCATION: '.$url);
			die();
		}

	}

	public function init_checks($sso, $page) {

		if ($sso->logged_in()) {

			if ($page!='index' && $page!='help' && $page!='support') {
				if ( $sso->get_user_data('type')!='admin' && $sso->get_user_data('type')!='beta tester' && $sso->get_user_data('type')!='web' ) {
					header('LOCATION: /index.php');
				}
			}

			/*if ($page=='support' && $sso->get_user_data('type')!='admin') {
				header('LOCATION: /index.php');
			}*/

			$hdrLoggedIn = true;
			$discordBroke = false;

			if ($sso->get_user_data('discord') == '') {
				$discordBroke = true;
				if ($page != 'index' && $page!='help' && $page!='support') {
					header('LOCATION: /index.php');
					die();
				}
			}

			if (!$sso->get_user_data('copilotAgree')) {

				if (isset($_POST['agree'])) {

					if ($_POST['check']) {
						$sso->copilot_agree($sso->get_user_data('id'));
					} else {
						if ($page!='index') { header('LOCATION: /agreement.php'); }
					}

				} else {
					if ($page!='index') { header('LOCATION: /agreement.php'); }
				}

			}

			if ($sso->copilot_agree($sso->get_user_data('id')) && $sso->get_user_data('discord')!='' && $page=='index') {
				if (!isset($_COOKIE['copilot_visited'])) {
					setcookie('copilot_visited', 'true');
					$configAsk = true;
				} else {
					$configAsk = false;
				}
			}

		} else {

			if ($page == 'export' && isset($_GET['ofp_id'])) {
				$this->redirect('https://portal.multicrew.co.uk/?rd=copilot&ofp='.$_GET['ofp_id']);
				die();
			} elseif ($page!='index' && $page!='help' && $page!='support') {
				$this->redirect('https://portal.multicrew.co.uk/?rd=copilot');
				die();
			} else {
				$hdrLoggedIn = false;
				$discordBroke = false;
			}

		}

		return array($hdrLoggedIn, $discordBroke, $configAsk);

	}

	public function is_acceptee($sso) {

		$stmt = $mysqli->bind_param('SELECT acceptee FROM plans WHERE acceptee=?');
		$discord = $sso->get_user_data('discord');
		$stmt->bind_param("s", $discord);

	}

	public function new_support($portal, $form){

		$mail = new PHPMailer(true);

	    $body = file_get_contents('/var/www/copilot/assets/phpmailer/mail_templates/support.html');
	    $altbody = file_get_contents('/var/www/copilot/assets/phpmailer/mail_templates/support.txt');

		$shortcodes = array('/{cat}/', '/{sub}/', '/{msg}/');
		$replace = array($form['category'], $form['subject'], $form['msg']);

		$body = preg_replace($shortcodes, $replace, $body);
		$altbody = preg_replace($shortcodes, $replace, $altbody);

		$subject = '[NEW SUPPORT TICKET] From: ' . $portal->get_user_data('name') . '; Category:' . $form['category'] . '; Subject: ' . $form['subject'];

	    //server settings
	    $mail->isMail();
	    $mail->Host = 'smtp.zoho.com';
	    $mail->SMTPAuth = true;
	    $mail->Username = 'support@multicrew.co.uk';
	    $mail->Password = $connect->mailGetPassword('support');
	    $mail->SMTPSecure = 'ssl';
	    $mail->Port = 465;

	    // mail headers
	    $mail->setFrom($portal->get_user_data('email'), $portal->get_user_data('name'));
	    $mail->addAddress('support@multicrew.co.uk');

	    // content
	    $mail->isHTML(true);
	    $mail->Subject = $subject;
	    $mail->Body    = $body;
	    $mail->AltBody = $altbody;

	    if ($mail->send()) { $sent = true; } else { $sent = false; }
	    return $sent;

	}

	public function reject_plan($mysqli, $id, $ac, $dep, $arr) {

		$stmt = $mysqli->prepare('SELECT * FROM plans WHERE id=?');
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$stmt->close();

		$stmt = $mysqli->prepare('DELETE FROM plans WHERE id=?');
		$stmt->bind_param("i", $row['id']);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare('INSERT INTO accepted (id, requestee, acceptee, aircraft, dep, arr) VALUES (?,?,?,?,?,?)');
		$stmt->bind_param("isssss", $id, $row['requestee'], $row['acceptee'], $ac, $dep, $arr);
		$stmt->execute();
		$stmt->close();
		return true;

	}

	public function accept_plan($mysqli, $discord) {

		$stmt = $mysqli->prepare('SELECT * FROM plans WHERE requestee=? or acceptee=?');
		$stmt->bind_param("ss", $discord, $discord);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$stmt->close();

		if ($discord == $row['requestee']) {
			$stmt = $mysqli->prepare('UPDATE plans SET requesteeaccept="1"');
			$stmt->execute();
			$stmt->close();
			return $row['ofp'];
		} elseif ($discord == $row['acceptee']) {
			$stmt = $mysqli->prepare('UPDATE plans SET accepteeaccept="1"');
			$stmt->execute();
			$stmt->close();
			return $row['ofp'];
		}

	}

	public function accepted_plan($mysqli, $discord) {

		$stmt = $mysqli->prepare('SELECT * FROM plans WHERE requestee=? or acceptee=?');
		$stmt->bind_param("ss", $discord, $discord);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();

		if ($row['requesteeaccept']==1 and $row['accepteeaccept']==0){
			return $row['requestee'];
		} elseif ($row['accepteeaccept']==1 and $row['requesteeaccept']==0) {
			return $row['acceptee'];
		} elseif ($row['accepteeaccept']==1 and $row['requesteeaccept']==1) {
			return "accepted";
		} else {
			return false;
		}
		$stmt->close();

	}


	public function acceptance_check($mysqli, $ofp_id) {

		$stmt = $mysqli->prepare('SELECT * FROM plans WHERE ofp=?');
		$stmt->bind_param("s", $ofp_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$stmt->close();

		if ($row['requesteeaccept']==1 and $row['accepteeaccept']==1) {
			$stmt = $mysqli->prepare('INSERT INTO flights (id, requestee, acceptee, ofp) VALUES (?,?,?,?)');
			$stmt->bind_param("isss", $row['id'], $row['requestee'], $row['acceptee'], $ofp_id);
			$stmt->execute();
			$stmt->close();

			$stmt = $mysqli->prepare('DELETE FROM plans WHERE ofp=?');
			$stmt->bind_param("s", $ofp_id);
			$stmt->execute();
			$stmt->close();
			return "accepted";
		}
		else {
			return false;
		}

	}

	public function completed($mysqli, $ofp_id, $ac, $dep, $arr, $date) {

		$stmt = $mysqli->prepare('SELECT * FROM flights WHERE ofp=?');
		$stmt->bind_param("s", $ofp_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array();
		$stmt->close();

		$stmt = $mysqli->prepare('INSERT INTO logbook (id, requestee, acceptee, aircraft, dep, arr, date) VALUES (?,?,?,?,?,?,?)');
		$stmt->bind_param("issssss", $row['id'], $row['requestee'], $row['acceptee'], $ac, $dep, $arr, $date);
		$stmt->execute();
		$stmt->close();

		$stmt = $mysqli->prepare('DELETE FROM flights WHERE ofp=?');
		$stmt->bind_param("s", $ofp_id);
		$stmt->execute();
		$stmt->close();

		if (mysqli_error($mysqli)) {
			return (mysqli_error($mysqli));
		} else {
			return 'complete';
		}

	}

	public function cancel_flight($mysqli, $ofp) {
		$stmt = $mysqli->prepare('DELETE FROM flights WHERE ofp=?');
		$stmt->bind_param("s", $ofp);
		$stmt->execute();
		$stmt->close();
		return "cancelled";

	}

	public function request_create($mysqli, $form, $sso) {

		// horrible way to work out highest request id in db
		$ids = [];

		$sql1 = 'SELECT MAX(id) FROM accepted';
		$res1 = $mysqli->query($sql1);
		$row1 = $res1->fetch_array();
		array_push($ids, $row1['MAX(id)']);

		$sql2 = 'SELECT MAX(id) FROM flights';
		$res2 = $mysqli->query($sql2);
		$row2 = $res2->fetch_array();
		array_push($ids, $row2['MAX(id)']);

		$sql3 = 'SELECT MAX(id) FROM logbook';
		$res3 = $mysqli->query($sql3);
		$row3 = $res3->fetch_array();
		array_push($ids, $row3['MAX(id)']);

		$sql4 = 'SELECT MAX(id) FROM plans';
		$res4 = $mysqli->query($sql4);
		$row4 = $res4->fetch_array();
		array_push($ids, $row4['MAX(id)']);

		$sql5 = 'SELECT MAX(id) FROM requests';
		$res5 = $mysqli->query($sql5);
		$row5 = $res5->fetch_array();
		array_push($ids, $row5['MAX(id)']);

		// make the request id +1 of the highest current one
		$id = max($ids) + 1;

		// get username from discord id
		$sql = 'SELECT discord FROM `users` WHERE id='.$sso->get_user_data('id');
		foreach ($sso->db->query($sql) as $names2) {
			$name = $names2['discord'];
		}

		// add request
		$stmt = $mysqli->prepare('INSERT INTO `requests` (id, discord, aircraft, dep, arr) VALUES (?, ?, ?, ?, ?)');
		$acft = strtoupper($form['aircraft']);
		$dep = strtoupper($form['dep']);
		$arr = strtoupper($form['arr']);
		$stmt->bind_param("iisss", $id, $name, $acft, $dep, $arr);
		$stmt->execute();
		$stmt->close();
		return $added = true;

	}

	/*
	function check_plans($sso) {

		$stmt = $mysqli->prepare('SELECT * FROM plans WHERE acceptee=? OR requestee=?');
		$discord = $sso->get_user_data('discord');
		$stmt->bind_param("ss", $discord, $discord);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows!=0) {

			$row = $result->fetch_array();
			$plan = $row['ofp'];

		}

		if (isset($plan)) { return $plan; } else { return false; }

	}
	*/

}

$copilot = new Copilot();

$connect->dbDefineCredentials('copilot');
$mysqli = $connect->dbConnect();

if (isset($page)) {
	$data = $copilot->init_checks($sso, $page);
	$hdrLoggedIn = $data[0];
	$discordBroke = $data[1];
	$configAsk = $data[2];
	/*if ($page=='output') {
		$copilot->check_plans($sso);
	}*/
}

$sect = 'copilot';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';

?>
