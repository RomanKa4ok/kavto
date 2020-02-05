<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['admin']))
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}
require_once 'php/admin/print_requests.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="Starter">
	<meta name="author" content="Admin">
	<title>KAVTO</title>

	<link rel="icon" href="images/favicon.jpg">
	<link rel="stylesheet" href="css/libs/slick.css"/>
	<link rel="stylesheet" href="css/libs/slick-theme.css"/>
	<link rel="stylesheet" href="css/libs/bootstrap-grid.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.min.css">
	<!-- <script src="https://kit.fontawesome.com/cf30c80347.js" crossorigin="anonymous"></script> -->
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
	




	<header class="header header--table">
		<div class="kavto-container">
			<nav class="header__nav">
				<a href="/" class="header__logo">
					<img src="images/logo.jpg" alt="logo" class="header__logo-img">
				</a>
				
					<form class="table__exit-form" action="php/admin_logout.php" method="post">
						
						<input type="submit" class="table__exit" name="logout" value="Выйти">
						<i class="fas fa-sign-out-alt"></i>
					</form>
			</nav>
		</div>
	</header>
	<main class="content content--table">
		<div class="kavto-container">

			<section class="table">
				<div class="table__admin-wrap">
					<i class="far fa-user"></i>
					<p class="table__admin">
						<?php echo isset($_SESSION['admin']) ?  $_SESSION['admin']['username'] :   header("HTTP/1.0 403 Forbidden"); ?>
					</p>

				</div>	
				<h1 class="table__title">ЗАЯВКИ</h1>
				<form action="#" id="deleteAllRows" method="post">
					<input class="table__delete" type="submit" name="deleteAll" value="Удалить все запросы">
				</form>	
				<div class="table__wrap">
					
					
					<?php
					if (empty($errors)) {
						if (!isset($data['info'])) {


							foreach ($data['results'] as $result) {


								?>
								<div class="table__block">
									<p class="table__block-id"><?php echo $result['id']?></p>
									<div class="table__block-wrap">
										<p class="table__block-phone"><?php echo $result['phone_number']?></p>
										<p class="table__block-name"><?php echo $result['name']?></p>
										<p class="table__block-message"><?php echo $result['message']?></p>
										<div class="table__button-wrap">

											<div class="table__button-blockstatus<?php echo $result['status'] !== 'new' ? ' table__button-blockstatus--read' : ''?> ">&#9733;</div>
											<form action="#" method="post" id="deleteRow"><button type="submit" data-id="<?php echo $result['id'];?>" id="submitDeleteRow" class="table__button-delete">X</button></form>
											<form action="#" method="post" id="changeStatus"><button type="submit" class="table__button-mark<?php echo $result['status'] !== 'new' ? ' hidden' : '' ?>" data-id="<?php echo $result['id'];?>" >&#10003</button></form>
										</div>
									</div>
								</div>
							<?php }
						}else{
							echo $data['info'];
						}
					}?>
				</div>
			</section>
		</div>
	</main>
	
	
	<footer class="footer footer--table">
		<div class="kavto-container">
			<ul class="footer__list">
				<li class="footer__item">© 2015 KAVTO. All right reserved.</li>
				<li class="footer__item">
					<a href="#" class="footer__link">
						<img src="images/logo.jpg" alt="" class="footer__link-img">
					</a>
				</li>
				<li class="footer__item">Made with love bt KAVTO</li>
			</ul>
		</div>
	</footer>

	<!-- Scripts -->
	<script src="js/libs/jquery-3.4.1.min.js"></script>
	<script src="js/admin.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript" src="js/libs/slick.min.js"></script>
</body>
</html>
