<?php	$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

$current_date = "$date/$month/$year // $hour:$min:$sec";?>
	<nav class="navbar navbar-default !navbar-fixed-top" style="margin: 0px;">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="./?mod=main" class="navbar-brand"><?php echo $head; ?></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> <?php echo $_SESSION["uName"]; ?> 
							(<?php if ($_SESSION["level"] == 2) {
								echo "Hr";
							}elseif ($_SESSION["level"] == 3){
								echo "GM";
							}else echo "user"; ?>) <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<?php if ($_SESSION["level"] <=	 2) { ?>
							<li><a href="./?mod=profile&id=<?= $_SESSION["uID"]?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
							<?php } ?>
							</li>
							<li><a href="./?mod=edit_password&id=<?= $_SESSION["uID"]?>"><i class="fas fa-cog fa-fw"></i> เปลี่ยนรหัสผ่าน</a>
							<li class="divider"></li>
							<li><a href="./?mod=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
							</li>
						</ul>
					</li>
				</ul><?php if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1"){ ?>
					<?php if ($_SESSION['level'] < 3) {?>
					<?php if ($hour <10 && $hour >= 7 ) {?>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="?mod=fn/checkin&id=<?=$_SESSION['uID']?>" >
							<i class="fa fa-calendar-check fa-fw"></i> ลงชื่อเข้างาน 
						</a>
					</li><?php }?>
				</ul><?php } ?>
			<?php } ?>
			<?php if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1"){ ?>
					<?php if ($_SESSION['level'] < 3) {?>
					<?php if ($hour >= 17 && $hour <= 24 ) {?>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="?mod=fn/checkout&id=<?=$_SESSION['uID']?>">
							<i class="fa fa-calendar-check fa-fw"></i> ลงชื่อออก 
						</a>
					</li><?php }?>
				</ul><?php } ?>
			<?php } ?>
			</div>
		</div>
	</nav>
