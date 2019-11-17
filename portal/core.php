<?php

include 'assets/phpmailer/PHPMailerAutoload.php';

session_start();

class sso {

	public function __construct($host,$dbnm,$char,$usnm,$pass) {
		$this->db = new PDO('mysql:host='.$host.';dbname='.$dbnm.';charset='.$char, $usnm, $pass);
		$this->mail = new PHPMailer;
	}

	public function log_in($user, $type ,$verifier, $remember) {

		$continue_login = false;

		if (strpos($user, '@') !== false) {

			$check_email = $this->db->prepare("SELECT * FROM users WHERE email=?");
			$check_email->execute(array($user));
			$user_data = $check_email->fetchAll(PDO::FETCH_ASSOC);

		} else {

			$check_username = $this->db->prepare("SELECT * FROM users WHERE username=?");
			$check_username->execute(array($user));
			$user_data = $check_username->fetchAll(PDO::FETCH_ASSOC);
		}

		if (count($user_data)) {

			$user_data = $user_data[0];

			if ($type == "manual") {

				if (password_verify($_POST['pass'], $user_data['password'])) {
					if ($user_data['type'] != "pending") {
							$continue_login = true;
					} else {
						$_SESSION['temp_email'] = $user_data['email'];
						$_SESSION['temp_user'] = $user_data['username'];
						return "not_verified";
					}

				} else {
					return "bad_pass";
				}

			} elseif ($type == "token") {

				if (password_verify($verifier, $user_data['token'])) {
					$continue_login = true;
				} else {
					return "bad_token";
				}

			}

			if ($continue_login == true) {

				//Remember me will always be on, regardless of what the user ticked
				if ($remember)
					$time = time()+2678400;
				else
					$time = time() + (60 * 20);

				$user_new_code = uniqid();
				$user_token = uniqid(null, true);
				$update_token = $this->db->prepare("UPDATE users SET code=?, token=? WHERE id=?");
				$update_token->execute(array($user_new_code, password_hash($user_token, PASSWORD_DEFAULT), $user_data['id']));

				if($update_token->rowCount()) {
					setcookie("portal_user_code", $user_new_code, $time, '/', DOMAIN);
					setcookie("portal_user_token", $user_token, $time, '/', DOMAIN);
				}

				$_SESSION['logged_in'] = true;
				$_SESSION['li_data'] = $user_data;
				$_SESSION['id'] = $user_data['id'];

				return "success";

			}

		} else {
			return "no_user";
		}

	}

	public function add_user($name, $email, $username, $verifierword, $bday, $ivao, $vatsim, $status) {

		$verifierword = password_hash($verifierword, PASSWORD_BCRYPT);
		$code = uniqid();
		$check_email = $this->db->prepare("SELECT * FROM users WHERE email=:email");
		$check_email->execute(array(':email' => $email));
		$email_exists = $check_email->rowCount();

		if ($email_exists) {
			return "email_exists";
		} else {

			$check_username = $this->db->prepare("SELECT * FROM users WHERE username=:username");
			$check_username->execute(array(':username' => $username));
			$username_exists = $check_username->rowCount();

			if ($username_exists) {
				return "username_exists";
			} else {

				//actually register the user
				try {
					$add_user = $this->db->prepare("INSERT INTO users(name,email,username,password,birthday,ivao,vatsim,code,type) VALUES(:name,:email,:username,:password,:birthday,:ivao,:vatsim,:code,:type)");
					$add_user->execute(array(':name' => $name, ':email' => $email, ':username' => $username, ':password' => $verifierword, ':birthday' => $bday, ':ivao' => $ivao, ':vatsim' => $vatsim, ':code' => $code, ':type' => $status));
					$add_success = $add_user->rowCount();
					if ($add_success) {
						return "success";
					} else {
						return "fail";
					}
				} catch(PDOException $ex) {
					die($ex->getMessage());
				}

			}

		}

	}

	public function is_banned($defuser = null) {

		if (!$defuser && $this->logged_in()) {
			$username = $this->get_user_data("username");
		} elseif (!$defuser) {
			die("No username specified for <strong>is_banned()</strong> and no user is logged in.");
		} else {
			$username = $defuser;
		}

		$check_bans = $this->db->prepare("SELECT * FROM bans WHERE username=:username");
		$check_bans->execute(array(':username' => $username));
		$ban_exists = $check_bans->rowCount();

		if ($ban_exists) {

			$ban_data = $check_bans->fetchAll(PDO::FETCH_ASSOC)[0];
			$today = new DateTime("today");
			$ban_end = new DateTime($ban_data["date_end"]);
			$difference = $ban_end->diff($today);
			$difference = $difference->format('%R%a');

			if($difference >= 0) {
					$this->lift_ban($username);
					$this->discord_unban($username);
					return false;
			} else {
				return true;
			}

		} else {
			return false;
		}

	}

	public function send_email($type, $username, $subject) {

		$user_info = $this->db->prepare("SELECT * FROM users WHERE username=?");
		$user_info->execute(array($username));
		$user_info = $user_info->fetchAll(PDO::FETCH_ASSOC);

		if (count($user_info)) {

			$user_info = $user_info[0];
			$first_name = explode(' ',trim($user_info['name']));
			$first_name = $first_name[0];
			$link = $this->url . "verify/" . $user_info['code'] . "/";
			$reset_link = $this->url . "reset&code=" . $user_info['code'];

			if (file_exists($this->dir . "views/mail_templates/$type/main.html") and file_exists($this->dir . "views/mail_templates/$type/plaintext.txt")) {

				$html_body = file_get_contents($this->dir . "views/mail_templates/$type/main.html");
				$plaintext_body = file_get_contents($this->dir . "views/mail_templates/$type/plaintext.txt");

				$shortcodes = array('/{link}/', '/{name}/', '/{email}/', '/{reset_link}/');
				$replace = array($link, $first_name, $user_info['email'], $reset_link);

				$html_body = preg_replace($shortcodes, $replace, $html_body);
				$plaintext_body = preg_replace($shortcodes, $replace, $plaintext_body);

				$this->mail->isSMTP();
				$this->mail->Host = 'smtp.zoho.com';
				$this->mail->SMTPAuth = true;
				$this->mail->Username = 'noreply@multicrew.co.uk';
				$this->mail->Password = 'gjgS RNGW 8w4V';
				$this->mail->SMTPSecure = 'ssl';
				$this->mail->Port = 465;

				$this->mail->setFrom('noreply@multicrew.co.uk', 'MultiCrew');
				$this->mail->addAddress($user_info['email'], $user_info['name']);

				$this->mail->isHTML(true);

				$this->mail->Subject = $subject;
				$this->mail->Body    = $html_body;
				$this->mail->AltBody = $plaintext_body;

				if (!$this->mail->send()) {
					return "mail_error";
				} else {
					return "success";
				}

			} else {
				return("no_template_files");
			}

		} else {
			return "no_user";
		}

		die ();

	}

	public function check_cookies() {

		if (isset($_COOKIE['portal_user_token']) and isset($_COOKIE['portal_user_code'])) {

			$check_code = $this->db->prepare("SELECT * FROM users WHERE code=?");
			$check_code->execute(array($_COOKIE['portal_user_code']));
			$user_data = $check_code->fetchAll(PDO::FETCH_ASSOC);

			if (count($user_data)) {

				$user_data = $user_data[0];
				$token_auth = $this->log_in($user_data['username'], "token", $_COOKIE['portal_user_token'], true);
				if ($token_auth == "success") {
					return true;
				} else {
					setcookie("portal_user_code", '', -1, '/', DOMAIN);
					setcookie("portal_user_token", '', -1, '/', DOMAIN);
					return(false);
				}

			} else {

				setcookie("portal_user_code", '', -1, '/', DOMAIN);
				setcookie("portal_user_token", '', -1, '/', DOMAIN);
				return false;

			}

		} else {
			return false;
		}

	}

	public function logged_in() {

		$validated = false;

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
			$validated = true;
			$status = true;
		} elseif ($this->check_cookies()) {
			$validated = true;
			$status = true;
		} else {
			$status = false;
		}

		if ($validated == true) {

			if ($this->is_banned($_SESSION['li_data']['username'])) {

				$check_bans = $this->db->prepare("SELECT * FROM bans WHERE username=:username");
				$check_bans->execute(array(':username' => $_SESSION['li_data']['username']));
				$ban_data = $check_bans->fetchAll(PDO::FETCH_ASSOC)[0];
				$previous_page = explode("/", $_SERVER['REDIRECT_URL']);

				if ($previous_page[1] == "denied") {
					header('LOCATION: '.PROTOCOL.'://portal.'.DOMAIN.'/denied');
					die();
				}

				$status = false;

			} else {
				$status = true;
			}

		}

		return $status;

	}

	function date_difference($startDate, $endDate) {

			$startDate = strtotime($startDate);
			$endDate = strtotime($endDate);
			if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) {
				return "false";
			}

			$years = date('Y', $endDate) - date('Y', $startDate);
			$endMonth = date('m', $endDate);
			$startMonth = date('m', $startDate);

			// Calculate months
			$months = $endMonth - $startMonth;
			if ($months <= 0)  {
				$months += 12;
				$years--;
			}
			if ($years < 0)
				return "BAD HERE";

			// Calculate the days
			$offsets = array();
			if ($years > 0) {
				$offsets[] = $years . (($years == 1) ? ' year' : ' years');
			} if ($months > 0) {
				$offsets[] = $months . (($months == 1) ? ' month' : ' months');
			}
			$offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

			$days = $endDate - strtotime($offsets, $startDate);
			$days = date('z', $days);

			return array($years, $months, $days);

	}

	public function lift_ban($username) {

		$check_username = $this->db->prepare("SELECT * FROM users WHERE username=:username");
		$check_username->execute(array(':username' => $username));
		$username_exists = $check_username->rowCount();

		if ($username_exists) {

			$check_bans = $this->db->prepare("SELECT * FROM bans WHERE username=:username");
			$check_bans->execute(array(':username' => $username));
			$ban_exists = $check_bans->rowCount();

			if ($ban_exists) {

				$lift_ban = $this->db->prepare("DELETE FROM bans WHERE username=:username");
				$lift_ban->bindValue(':username', $username, PDO::PARAM_STR);
				$lift_ban->execute();

				if($lift_ban->rowCount()) {
					return "success";
				} else {
					return "error adding.";
				}

			} else {
				return "this user is not banned.";
			}

		} else {
			return "user doesn't exist.";
		}

	}

	public function ban_user($username, $duration) {

			$ban_start = date('Y-m-d');

			if (strtolower($duration) == "forever") {
				$ban_end = date('Y-m-d', strtotime("20 years"));
			} else {
				$ban_end = date('Y-m-d', strtotime("+" . $duration));
			}

			$check_username = $this->db->prepare("SELECT * FROM users WHERE username=:username");
			$check_username->execute(array(':username' => $username));
			$username_exists = $check_username->rowCount();

			if ($username_exists) {

				$check_bans = $this->db->prepare("SELECT * FROM bans WHERE username=:username");
				$check_bans->execute(array(':username' => $username));
				$ban_exists = $check_bans->rowCount();

				if ($ban_exists) {
					return "lift the previous ban on this user first.";
				} else {
					$add_ban = $this->db->prepare("INSERT INTO bans(username,date_start,date_end,status) VALUES(:username,:date_start,:date_end,:status)");
					$add_ban->execute(array(':username' => $username, ':date_start' => $ban_start, ':date_end' => $ban_end, ':status' => 'active'));
					if($add_ban->rowCount()) {
						return "success";
					} else {
						return "error_adding";
					}
				}

			} else {
				return "username doesn't exist.";
			}

	}

	public function delete_user($id) {

		$delete_thing = $this->db->prepare("DELETE FROM users WHERE id=:id");
		$delete_thing->bindValue(':id', $id, PDO::PARAM_STR);
		$delete_thing->execute();

		return $delete_thing->rowCount();

	}

	public function get_user_data($thing, $id=null) {

		if ($this->logged_in()) {

			$get_user_data = $this->db->prepare("SELECT * FROM users WHERE id=?");
			if(!$id) {
				$get_user_data->execute(array($_SESSION['id']));
			} else {
				$get_user_data->execute(array($id));
			}

			$user_data = $get_user_data->fetchAll(PDO::FETCH_ASSOC);

			if (count($user_data)) {

				$user_data = $user_data[0];

				if (isset($user_data[$thing])) {
					return $user_data[$thing];
				} elseif ($thing == "first_name") {
					$first_name = explode(' ',trim($user_data['name']));
					return $first_name[0];
				} elseif ($thing == "discord" and !isset($user_data[$thing])) {
					return "";
				} elseif ($thing == 'copilotAgree') {

					if ($user_data[$thing]==0) {
						return false;
					} else {
						return true;
					}

				} else {
					die("That is not a correct value to fetch user data.");
				}

			} else {
				die("Error finding user");
			}

		} else {
			return null;
		}

	}

	public function log_out() {

		$_SESSION['logged_in'] = false;
		$_SESSION['id'] = '';

		session_unset();
		session_destroy();

		setcookie("portal_user_code", '', -1, '/', DOMAIN);
		setcookie("portal_user_token", '', -1, '/', DOMAIN);

		return "success";

	}

	public function verify_user($code) {

		$verify = $this->db->prepare("UPDATE users SET type=? WHERE code=?");
		$verify->execute(array("trainee", $code));

		return true;

	}

	public function set_password($code, $password) {

		$verify = $this->db->prepare("UPDATE users SET password=? WHERE code=?");
		$verify->execute(array(password_hash($password, PASSWORD_DEFAULT), $code));

		if ($verify->rowCount()) {
			return true;
		} else {
			return false;
		}

	}

	public function update_user($id, $name, $email, $username, $password, $birthday, $ivao, $vatsim, $type, $discord) {

		if ($password!='' || $password) {
			$update_status = $this->db->prepare("UPDATE users SET name=?, email=?, username=?, password=?, birthday=?, ivao=?, vatsim=?, type=?, discord=? WHERE id=?");
			$update_status->execute(array($name, $email, $username, $password, $birthday, $ivao, $vatsim, $type, $discord, $id));
		} else {
			$update_status = $this->db->prepare("UPDATE users SET name=?, email=?, username=?, birthday=?, ivao=?, vatsim=?, type=?, discord=? WHERE id=?");
			$update_status->execute(array($name, $email, $username, $birthday, $ivao, $vatsim, $type, $discord, $id));
		}

		return "success";

	}

	public function copilot_agree($id) {
		$update_status = $this->db->prepare("UPDATE users SET copilotAgree=? WHERE id=?");
		$agree = 1;
		$update_status->execute(array($agree, $id));
		return 'success';
	}

	public function discord_ban($username) {

		$get_discord = $this->db->prepare("SELECT discord FROM users WHERE username=?");
		$get_discord->execute(array($username));
		$discord = $get_discord->fetchAll(PDO::FETCH_ASSOC);
		$data = 'ban,'.$discord[0]['discord'];

		set_time_limit(5);
		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false) { die("Could not create socket\n"); }
		socket_bind($socket, "127.0.0.1");
		if (($connection = socket_connect($socket, "127.0.0.1", 9001)) === false) { die("Could not connect to server\n"); }
		if (socket_write($socket, $data)) { $accepted = true; } else { die("Error seding data"); }
		socket_close($socket);

	}

	public function discord_unban($username) {

		$get_discord = $this->db->prepare("SELECT discord FROM users WHERE username=?");
		$get_discord->execute(array($username));
		$discord = $get_discord->fetchAll(PDO::FETCH_ASSOC);
		$data = 'unban,'.$discord[0]['discord'];

		set_time_limit(5);
		if (($socket = socket_create(AF_INET, SOCK_STREAM, 0)) === false) { die("Could not create socket\n"); }
		socket_bind($socket, "127.0.0.1");
		if (($connection = socket_connect($socket, "127.0.0.1", 9001)) === false) { die("Could not connect to server\n"); }
		if (socket_write($socket, $data)) { $accepted = true; } else { die("Error seding data"); }
		socket_close($socket);

	}

}

$password = $connect->dbGetPassword('sso');
$sso = new sso('localhost','sso','utf8mb4','sso',  $password);
