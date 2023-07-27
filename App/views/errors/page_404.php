<?php require_once APPROOT . "/views/includes/header.php" ?>
<main>
<div id="error_page">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-xl-8 col-lg-9">
					<h2>404 <i class="fa-solid fa-triangle-exclamation"></i></h2>
					<p>Nous sommes désolés, mais la page que vous recherchez n'existe pas.</p>
					<form class="searchForm" role="search">
						<div class="search_bar_error">
							<input type="text" class="form-control" placeholder="What are you looking for?">
							<input type="submit" value="Search">
						</div>
					</form>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /error_page -->
</main>
<!--/main-->
<?php require_once APPROOT . "/views/includes/footer.php"; ?>