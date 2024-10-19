<?php include 'header.php' ?>
	<?php
		error_reporting(E_ALL); ini_set('display_errors', 1);
		ini_set('memory_limit', '5120M');

		$pn = get_input($conn, "pn");

		$add = get_input($conn, "add");
		$edit = get_input($conn, "edit");
		$delete = get_input($conn, "delete");
		$role = tp_input($conn, "role");

		if(check_privilege($conn, $email, "role_management") == 1 && isset($_POST["delete"]) && isset($_POST["del"])){
			$i = $act = 0;
			$role_text = "";
			if(is_array($_POST["del"])){
				foreach ($_POST["del"] as $k => $c) {
					if($c != ""){ 
						$c = testQty($conn, $c);
						$queryRole = mysqli_query($conn, "SELECT * FROM role_management WHERE id = '$c'");
						if(mysqli_num_rows($queryRole) > 0){
							$rowRole = mysqli_fetch_array($queryRole);
							$role_text .= $rowRole['role']. ",";
						}
						$updateUsers = mysqli_query($conn, "UPDATE users SET role_id = '0' WHERE role_id = '{$c}'");
						$act = mysqli_query($conn, "DELETE FROM role_management WHERE id = '$c'");
						$i++;		
					}else{
						continue;
					}
				}

				if($act && $i > 0){

					$role_text = substr($role_text,0,-2);
					$activity = "Deleted {$i} role from database: <b>{$role_text}</b>.";

					mysqli_query($conn, "INSERT INTO activity_log (email, activity, date_time) VALUES ('$email', '$activity', '$date_time')");

					echo "<div class='row'><div class='col-md-12 alert alert-success'>{$i} role(s) successfully deleted.</div></div>";
				}else{
					echo "<div class='row'><div class='col-md-12 alert alert-danger'>Error. Unable to delete role(s).</div></div>";
				}

			}else{
				echo "<div class='row'><div class='col-md-12 alert alert-danger'>Atleast one role must be selected.</div></div>";
			}
		}

		if(check_privilege($conn, $email, "role_management") == 1 && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add_role'])){
			$pn = tp_input($conn, "pn");
			$checkRole = mysqli_query($conn, "SELECT * FROM role_management WHERE role = '$role'");
			if(mysqli_num_rows($checkRole) > 0){
				$check_row_exists = 1;
			}else{
				$check_row_exists = 0;
			}

			$data_array = array();
			$roles_combined = "";
			foreach($_POST as $key => $val){
				if($key != "add" && $key != "edit" && $key != "gh" && $key != "pn" && $key != "sel-all" && $key != "add_role" && $key != "role"){
					$data_array += array($key => $val);
					if($key != "role" && !empty($val)){
						$queryPriveleges = mysqli_query($conn, "SELECT * FROM privileges WHERE role_title = '$key'");
						if(mysqli_num_rows($queryPriveleges) > 0){
							$rowPriveleges = mysqli_fetch_array($queryPriveleges);
							$roles_combined .= $rowPriveleges['role_text'];
						}
					}
				}
			}

			$dataKeys = implode(", ", array_keys($data_array));

			$values = array_values($data_array);
			$quoted_values = array_map(function($value) {
			    return "'$value'";
			}, $values);
			$dataValues = implode(", ", $quoted_values);

			$act = "";

			if(empty($check_row_exists)){
				$act = mysqli_query($conn, "INSERT INTO role_management (date_created, role, {$dataKeys}, created_by) VALUES ('$date_time', '$role', {$dataValues}, '$email')");
			}
			if($act){
				$error = 0;
				$roles_combined = substr($roles_combined,0,-2);
				$activity = "Allowed the following privileges to a role (<b>{$role}</b>): {$roles_combined}.";

				mysqli_query($conn, "INSERT INTO activity_log (email, activity, date_time) VALUES ('$email', '$activity', '$date_time')");
				echo "<div class='row'><div class='col-md-12 alert alert-success'>Role successfully added.</div></div>";
			}else{
				echo "<div class='row'><div class='col-md-12 alert alert-danger'>Error. Unable to add role.</div></div>";
			}
		}

		if(check_privilege($conn, $email, "role_management") == 1 && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_role'])){
			$edit = tp_input($conn, "edit");
			$pn = tp_input($conn, "pn");

			$checkRole = mysqli_query($conn, "SELECT * FROM role_management WHERE role = '$role'");
			if(mysqli_num_rows($checkRole) > 0){
				$check_row_exists = 1;
			}else{
				$check_row_exists = 0;
			}

			$data_array = array();
			$roles_combined = "";
			foreach($_POST as $key => $val){
				if($key != "add" && $key != "edit" && $key != "gh" && $key != "pn" && $key != "sel-all" && $key != "role" && $key != "edit_role"){
					$data_array += array($key => $val);
					if($key != "role" && !empty($val)){
						$queryPriveleges = mysqli_query($conn, "SELECT * FROM privileges WHERE role_title = '$key'");
						if(mysqli_num_rows($queryPriveleges) > 0){
							$rowPriveleges = mysqli_fetch_array($queryPriveleges);
							$roles_combined .= $rowPriveleges['role_text'];
						}
					}
				}
			}

			$formatted_pairs = array();
			foreach ($data_array as $key => $value) {
			    $formatted_pairs[] = "$key = '$value'";
			}
			$result_string = implode(", ", $formatted_pairs);

			$act = mysqli_query($conn, "UPDATE role_management SET date_updated = '$date_time', role = '$role', updated_by = '$email', {$result_string} WHERE id = '$edit'");
			

			if($act){
				$error = 0;
				$roles_combined = substr($roles_combined,0,-2);
				$activity = "Allowed the following privileges to a role (<b>{$role}</b>): {$roles_combined}.";

				mysqli_query($conn, "INSERT INTO activity_log (email, activity, date_time) VALUES ('$email', '$activity', '$date_time')");
				echo "<div class='row'><div class='col-md-12 alert alert-success'>Role successfully updated.</div></div>";
			}else{
				echo "<div class='row'><div class='col-md-12 alert alert-danger'>Error. Unable to update role.</div></div>";
			}

		}


		$result = mysqli_query($conn, "SELECT * FROM role_management ORDER BY id DESC");

		$per_view = 20;
		$page_link = "role-management?pn=";
		$link_suffix = "";
		$style_class = "general-link";
		page_numbers();
		$offset = ($per_view * $pn) - $per_view;
		$result = mysqli_query($conn, "SELECT * FROM role_management ORDER BY id DESC LIMIT {$offset},{$per_view}");
		?>
    <div class="row">
        <div class="col-md-12">
            <div class="row d-flex justify-content-center">

				<?php if(empty($edit) && empty($add)){ ?>

					<div class="col-md-12 my-2"><div class="page-title">Role Management <a href="role-management?add=1" class="btn btn-primary" style="float: right;">New Role</a></div></div>

					<?php
						$d = 0;
						if(mysqli_num_rows($result) > 0){
					?> 
					<div class="col-md-12 my-2">
                        <div class="card p-4">
							<form action="" method="POST" enctype="multipart/form-data" style="overflow-x:auto;">
								<input type="hidden" name="pn" value="<?php echo $pn; ?>"> 
								<input type="hidden" name="gh" value="1"> 
								<input type="hidden" name="delete" value="1"> 
								<table class="table table-striped table-hover">
									<thead>
										<tr class="gen-title">
											<th style="width: 40px;">#ID</th>
											<th>Role Name</th>
											<th>Date Created</th>
											<th>Created By</th>
											<th>Last Update</th>
											<th>Updated By</th>
											<th style="width: 100px;">Option</th>
											<th style="width:30px;"><input type="checkbox" name="sel_all" id="delG" class="sel-group" value=""></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sn = 1;
										while($row = mysqli_fetch_array($result)){
											$role_id = $row["id"];
											$role = $row["role"];
											?>
											<tr>
												<td><?php echo $sn++; ?></td>
												<td><?php echo $role; ?></td>
												<td><?php echo $row['date_created'] ?></td>
												<td><?php echo $row['created_by'] ?></td>
												<td><?php echo $row["date_updated"] ?></td>
												<td><?php echo $row['updated_by'] ?></td>
												<td><a href="role-management?edit=<?php echo $role_id; ?>&pn=<?php echo $pn; ?>" class="btn btn-primary" title="Edit role #<?php echo $role_id; ?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
												<td><input type="checkbox" name="del[<?php echo $d; ?>]" id="del<?php echo $d; ?>" class="delG" value="<?php echo $role_id; ?>"></td>
											</tr>
											<?php 
											$d++;
										}
										?>
										<tr><td colspan="9"><input class="btn btn-danger" style="float: right;" type="submit" value="Delete selected role(s)"></td></tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<?php
						echo ($last_page>1)?"<div class=\"page-nos\">" . $center_pages . "</div>":"";
					}else{
						echo "<div class='not-success'>No roles found at the moment.</div>";
					}

				}

				if(check_privilege($conn, $email, "role_management") == 1 && !empty($add)){

					$result = mysqli_query($conn, "SELECT * FROM privileges");

					$role = "";
					if(!empty($edit)){
						$queryRole = mysqli_query($conn, "SELECT * FROM role_management WHERE id = '$edit'");
						if(mysqli_num_rows($queryRole) > 0){
							$rowrole = mysqli_fetch_array($queryRole);
							$role = $rowrole['role'];
						}
					}
					?>

					<div class="col-md-6 my-2">
						<div class="page-title">Add Role</div>
					</div>
					<div class="col-md-6 my-2">
						<a href="role-management?pn=<?php echo $pn; ?>" class="btn btn-primary" style="float: right;"><i class="fa fa-arrow-left"></i> Back to role management</a>
					</div>
					<div class="col-md-12">
                        <div class="card p-4">
							<form action="" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="add" value="1"> 
								<input type="hidden" name="pn" value="<?php echo $pn; ?>"> 

								<div class="overflow">
									<table class="table table-striped table-hover">
										<tr>
											<td></td>
											<td class="title_adjust" style="text-align:right!important; align-content: center;">
												<label for="role">Role Name:</label>
											</td>
											<td colspan="2">
												<input type="text" name="role" id="role" class="form-control" placeholder="Type the role name" required value="">
											</td>
											<td></td>
											<td></td>
											<td class="title_adjust">
												<input type="checkbox" name="sel-all" id="delG" class="sel-group">
											</td>
											<td class="title_adjust"><label for="delG">Select all</label></td>
										</tr>
										<tr>
											<?php
											$c = 0;
											while($row = mysqli_fetch_array($result)){
												$c++;
												$id = $row["id"];
												$role_title = $row["role_title"];
												$role_text = $row["role_text"];
												?>
												<td class="field_td"><input type="checkbox" name="<?php echo $role_title; ?>" id="<?php echo $role_title; ?>" class="delG" value="1"></td>
												<td><label for="<?php echo $role_title; ?>"><?php echo $role_text; ?></label></td>
												<?php
												if($c == 4){
													?>
												</tr><tr>
													<?php
													$c = 0;
												}
											}

											if($c > 0 && $c < 4){
												?>
												<td colspan="<?php echo (4 - $c) * 2; ?>"></td>
												<?php
											}
											?>
										</tr>
									</table>
								</div>

								<div class="submit-div col-sm-12">
									<input type="submit" class="btn btn-primary" style="float: right;" name="add_role" value="Add Role">
								</div>
							</form>
						</div>
					</div>

					<?php
				}





				if(check_privilege($conn, $email, "role_management") == 1 && !empty($edit)){

					$result = mysqli_query($conn, "SELECT * FROM privileges");

					$role = "";
					if(!empty($edit)){
						$queryRole = mysqli_query($conn, "SELECT * FROM role_management WHERE id = '$edit'");
						if(mysqli_num_rows($queryRole) > 0){
							$rowrole = mysqli_fetch_array($queryRole);
							$role = $rowrole['role'];
						}
					}
					?>

					<div class="col-md-6 my-2">
						<div class="page-title">Edit Role</div>
					</div>
					<div class="col-md-6 my-2">
						<a href="role-management?pn=<?php echo $pn; ?>" class="btn btn-primary" style="float: right;"><i class="fa fa-arrow-left"></i> Back to role management</a>
					</div>
					<div class="col-md-12">
                        <div class="card p-4">
							<form action="role-management" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="edit" value="<?php echo $edit; ?>"> 
								<input type="hidden" name="pn" value="<?php echo $pn; ?>"> 

								<div class="overflow">
									<table class="table table-striped table-hover">
										<tr>
											<td></td>
											<td class="title_adjust" style="text-align:right!important;align-content: center;">
												<label for="role">Role Name:</label>
											</td>
											<td colspan="2">
												<input type="text" name="role" id="role" class="form-control" placeholder="Type the role name" required value="<?php  echo $role; ?>">
											</td>
											<td></td>
											<td></td>
											<td class="title_adjust">
												<input type="checkbox" name="sel-all" id="delG" class="sel-group" value="">
											</td>
											<td class="title_adjust"><label for="delG">Select all</label></td>
										</tr>
										<tr>
											<?php
											$c = 0;
											while($row = mysqli_fetch_array($result)){
												$c++;
												$id = $row["id"];
												$role_title = $row["role_title"];
												$role_text = $row["role_text"];
												?>
												<td class="field_td"><input type="hidden" name="<?php echo $role_title; ?>" id="<?php echo $role_title; ?>1" value="0"><input type="checkbox" <?php if($rowrole[$role_title] == 1){ ?> checked <?php } ?> name="<?php echo $role_title; ?>" id="<?php echo $role_title; ?>" class="delG" value="1"></td>
												<td><label for="<?php echo $role_title; ?>"><?php echo $role_text; ?></label></td>
												<?php
												if($c == 4){
													?>
												</tr><tr>
													<?php
													$c = 0;
												}
											}

											if($c > 0 && $c < 4){
												?>
												<td colspan="<?php echo (4 - $c) * 2; ?>"></td>
												<?php
											}
											?>
										</tr>
									</table>
								</div>

								<div class="submit-div col-sm-12">
									<input type="submit" class="btn btn-primary" style="float: right;" name="edit_role" value="Update Role">
								</div>
							</form>
						</div>
					</div>

					<?php
				}
				?>
			</div>
		</div>
	</div>
		
<?php include 'footer.php' ?>