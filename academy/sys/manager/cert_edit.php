<?php

$tab = 'sys';
$page = 'cert';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/header.php';
include $_SERVER['DOCUMENT_ROOT'].'/assets/layout/sidebar_sys.php';

if (isset($_POST['updatecert'])){
	$getkey = array_keys($_POST);
	$key = $getkey[0];
	$column = str_replace('_', '.', $getkey[0]);

	if ($_POST[$key]=="NULL") {

		$stmt = $mysqli->prepare("UPDATE cert SET `$column`=NULL WHERE `users.id`=?");
		$stmt->bind_param("i", $_POST['userid']);
		$stmt->execute();
		$academy->send_mail($sso, "[myAcademy] Your certifictions have been updated", 'cert', $_POST['userid'], $connect);

	} else {

		$stmt = $mysqli->prepare("UPDATE cert SET `$column`=? WHERE `users.id`=?");
		$stmt->bind_param("si", $_POST[$key], $_POST['userid']);
		$stmt->execute();
		$academy->send_mail($sso, "[myAcademy] Your certifictions have been updated", 'cert', $_POST['userid'], $connect);

	}

}

if (isset($_POST['userid'])){
	$stmt = $mysqli->prepare('SELECT * FROM cert WHERE `users.id`=?');
	$stmt->bind_param("i", $_POST['userid']);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array();
}
else{
	$academy->redirect('/sys/manager/cert.php');
}


?>

<a href="cert.php" class="btn btn-secondary float-right"><i class="fas fa-angle-double-right fa-fw mr-2"></i>Back</a>
<h3 class="mb-3">Certifications</h3>

<div class="row w-50">

	<div class="col-md-6">

		<div class="form-group">
			<label>Student</label>
			<input type="text" class="form-control" disabled value="<?php echo $sso->get_user_data('name', $row['users.id'])?>">
		</div>

	</div>

	<div class="col-md-6">

		<div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" disabled value="<?php echo $sso->get_user_data('username', $row['users.id'])?>">
		</div>

	</div>

</div>

<div class="row">

	<div class="col-md-6">

		<div class="card mb-3">

			<h3 class="card-header">Aerosoft A320</h3>

			<div class="card-body">

				<div class="form-group">
					<label>Theory Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a320.theory" class="custom-select">
								<option <?php if ($row['a320.theory']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['a320.theory']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['a320.theory']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Practical Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a320.practical" class="custom-select">
								<option <?php if ($row['a320.practical']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['a320.practical']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['a320.practical']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Overall Certification</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a320.pass" <?php if ($row['a320.theory']!="1" || $row['a320.practical']!="1" || $row['a320.course']!="100"){ echo "disabled"; } ?> class="custom-select">
								<option <?php if ($row['a320.pass']==''){ echo "selected";} ?> value=NULL>Not Started</option>
								<option <?php if ($row['a320.pass']=='0'){ echo "selected";} ?> value="0">No</option>
								<option <?php if ($row['a320.pass']=='1'){ echo "selected";} ?> value="1">Yes</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>

		<div class="card mb-3">

			<h3 class="card-header">Aerosoft A330</h3>

			<div class="card-body">

				<div class="form-group">
					<label>Theory Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a330.theory" class="custom-select">
								<option <?php if ($row['a330.theory']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['a330.theory']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['a330.theory']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Practical Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a330.practical" class="custom-select">
								<option <?php if ($row['a330.practical']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['a330.practical']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['a330.practical']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Overall Certification</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="a330.pass" <?php if ($row['a330.theory']!="1" || $row['a330.practical']!="1" || $row['a330.course']!="100"){ echo "disabled"; } ?> class="custom-select">
								<option <?php if ($row['a330.pass']==''){ echo "selected";} ?> value=NULL>Not Started</option>
								<option <?php if ($row['a330.pass']=='0'){ echo "selected";} ?> value="0">No</option>
								<option <?php if ($row['a330.pass']=='1'){ echo "selected";} ?> value="1">Yes</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>

	</div>

	<div class="col-md-6">

		<div class="card mb-3">

			<h3 class="card-header">Majestic Q400</h3>

			<div class="card-body">

				<div class="form-group">
					<label>Theory Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="dh8d.theory" class="custom-select">
								<option <?php if ($row['dh8d.theory']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['dh8d.theory']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['dh8d.theory']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Practical Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="dh8d.practical" class="custom-select">
								<option <?php if ($row['dh8d.practical']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['dh8d.practical']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['dh8d.practical']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Overall Certification</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="dh8d.pass" <?php if ($row['dh8d.theory']!="1" || $row['dh8d.practical']!="1" || $row['dh8d.course']!="100"){ echo "disabled"; } ?> class="custom-select">
								<option <?php if ($row['dh8d.pass']==''){ echo "selected";} ?> value=NULL>Not Started</option>
								<option <?php if ($row['dh8d.pass']=='0'){ echo "selected";} ?> value="0">No</option>
								<option <?php if ($row['dh8d.pass']=='1'){ echo "selected";} ?> value="1">Yes</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>

		<div class="card mb-3">

			<h3 class="card-header">TDFi 717</h3>

			<div class="card-body">

				<div class="form-group">
					<label>Theory Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="b712.theory" class="custom-select">
								<option <?php if ($row['b712.theory']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['b712.theory']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['b712.theory']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Practical Exam</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="b712.practical" class="custom-select">
								<option <?php if ($row['b712.practical']==''){ echo "selected";} else{ echo "";} ?> value=NULL>Not Attempted</option>
								<option <?php if ($row['b712.practical']=='0'){ echo "selected";} else{ echo "";} ?> value="0">Failed</option>
								<option <?php if ($row['b712.practical']=='1'){ echo "selected";} else{ echo "";} ?> value="1">Passed</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<label>Overall Certification</label>
					<form action="" method="POST">
						<div class="input-group">
							<select name="b712.pass" <?php if ($row['b712.theory']!="1" || $row['b712.practical']!="1" || $row['b712.course']!="100"){ echo "disabled"; } ?> class="custom-select">
								<option <?php if ($row['a330.pass']==''){ echo "selected";} ?> value=NULL>Not Started</option>
								<option <?php if ($row['a330.pass']=='0'){ echo "selected";} ?> value="0">No</option>
								<option <?php if ($row['a330.pass']=='1'){ echo "selected";} ?> value="1">Yes</option>
							</select>
							<div class="input-group-append">
								<input type="hidden" name="userid" value="<?php echo $row['users.id']; ?>">
								<button class="btn btn-primary" type="submit" name="updatecert">Submit</button>
							</div>
						</div>
					</form>
				</div>

			</div>

		</div>

	</div>

</div>

<?php $call = 'academy'; include $_SERVER['DOCUMENT_ROOT'].'/../footer_sys.php'; ?>
