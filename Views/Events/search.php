<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/css/roboto.css"/>
    <link rel="stylesheet" type="text/css" href="/css/material.css"/>
    <link rel="stylesheet" type="text/css" href="/css/ripples.css"/>
	<link rel="stylesheet" href="/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/>
	<link rel="stylesheet" href="/css/contentFilter-style.css"> <!-- Resource style -->
	<script src="/js/modernizr.js"></script> <!-- Modernizr -->

	<title>Content Filters | CodyHouse</title>
</head>
<body>
	<!-- Static navbar -->
    <?php
       $path = $_SERVER['DOCUMENT_ROOT'];
       $path .= "/Views/General/navbar.php";
       include_once($path);
    ?>

	<div class="container" style="margin-bottom:20px;">
		<h1 style="font-size: 35px;">Event Search</h1>
	</div>

	<main class="cd-main-content">
		<div class="cd-tab-filter-wrapper">
			<div class="cd-tab-filter">
				<ul class="cd-filters">
					<li class="placeholder">
						<a data-type="all" href="#0">All</a> <!-- selected option on mobile -->
					</li>
					<li class="filter"><a class="selected" href="#0" data-type="all">All</a></li>
					<li class="filter" data-filter=".panel"><a href="#0" data-type="panel">Panels</a></li>
					<li class="filter" data-filter=".image"><a href="#0" data-type="image">Images</a></li>
				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->

		<section class="cd-gallery">
			<ul>


				<li class="mix image check3 radio3 option3"><img src="/images/contentFilter/img-6.jpg" alt="Image 6"></li>
				<li class="mix image check3 radio3 option1"><img src="/images/contentFilter/img-7.jpg" alt="Image 7"></li>
				<li class="mix image check3 radio3 option4"><img src="/images/contentFilter/img-8.jpg" alt="Image 8"></li>
				<li class="mix image check3 radio3 option3"><img src="/images/contentFilter/img-9.jpg" alt="Image 9"></li>
				<li class="mix image check3 radio3 option4"><img src="/images/contentFilter/img-10.jpg" alt="Image 10"></li>
				<li class="mix image check3 radio3 option3"><img src="/images/contentFilter/img-11.jpg" alt="Image 11"></li>
				<li class="mix image check1 radio3 option3"><img src="/images/contentFilter/img-12.jpg" alt="Image 12"></li>
				<li class="gap"></li>
				<li class="gap"></li>
				<li class="gap"></li>
			</ul>
			<div class="cd-fail-message">No results found</div>
		</section> <!-- cd-gallery -->

		<div class="cd-filter">
			<form>
				<div class="cd-filter-block">
					<h4>Search</h4>

					<div class="cd-filter-content">
						<input type="search" placeholder="Try panel...">
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->

				<div class="cd-filter-block">
					<h4>Check boxes</h4>

					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter=".check1" type="checkbox" id="checkbox1">
			    			<label class="checkbox-label" for="checkbox1">Option 1</label>
						</li>

						<li>
							<input class="filter" data-filter=".check2" type="checkbox" id="checkbox2">
							<label class="checkbox-label" for="checkbox2">Option 2</label>
						</li>

						<li>
							<input class="filter" data-filter=".check3" type="checkbox" id="checkbox3">
							<label class="checkbox-label" for="checkbox3">Option 3</label>
						</li>
					</ul> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->

				<div class="cd-filter-block">
					<h4>Select</h4>

					<div class="cd-filter-content">
						<div class="cd-select cd-filters">
							<select class="filter" name="selectThis" id="selectThis">
								<option value="">Choose an option</option>
								<option value=".option1">Option 1</option>
								<option value=".option2">Option 2</option>
								<option value=".option3">Option 3</option>
								<option value=".option4">Option 4</option>
							</select>
						</div> <!-- cd-select -->
					</div> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->

				<div class="cd-filter-block">
					<h4>Radio buttons</h4>

					<ul class="cd-filter-content cd-filters list">
						<li>
							<input class="filter" data-filter="" type="radio" name="radioButton" id="radio1" checked>
							<label class="radio-label" for="radio1">All</label>
						</li>

						<li>
							<input class="filter" data-filter=".radio2" type="radio" name="radioButton" id="radio2">
							<label class="radio-label" for="radio2">Choice 2</label>
						</li>

						<li>
							<input class="filter" data-filter=".radio3" type="radio" name="radioButton" id="radio3">
							<label class="radio-label" for="radio3">Choice 3</label>
						</li>
					</ul> <!-- cd-filter-content -->
				</div> <!-- cd-filter-block -->
			</form>

			<a href="#0" class="cd-close">Close</a>
		</div> <!-- cd-filter -->

		<a href="#0" class="cd-filter-trigger">Filters</a>
	</main> <!-- cd-main-content -->
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/material.js"></script>
<script type="text/javascript" src="/js/ripples.js"></script>
<script type="text/javascript" src="/js/timeline.js"></script>
<script src="/js/jquery.mixitup.min.js"></script>
<script src="/js/contentFilter.js"></script> <!-- Resource jQuery -->
</body>
</html>
