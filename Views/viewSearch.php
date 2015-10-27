<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
// require_once("config/db.php");
require_once("../config/db.php");
require_once("Basic.php");
$basic = new Basic();

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
	<!-- <link rel="stylesheet" type="text/css" href="/css/timeline-style.css"/> -->
	<link rel="stylesheet" href="/css/contentFilter-style.css"> <!-- Resource style -->
	<script src="/js/modernizr.js"></script> <!-- Modernizr -->
	<script type="text/javascript" src="/js/jquery.js"></script>
	<title>Group Finder</title>
	<script type="text/javascript">

    $(document).ready(function(){
		var data = <?php echo $_GET['searchItem']; ?> +"";
		console.log("POST: ",data);

         function search(){
              var title=$("#search").val();
              if(title!=""){
                // $("#contentLocation").html("<img alt="search" src='ajax-loader.gif'/>");
                 $.ajax({
                    type:"post",
                    url:"search.php",
                    data:"search="+title,
					// dataType:'json',
                    success:function(data){
						console.log("Result",data);
						$("#search").val("");
                        $("#contentLocation").html("");
						var obj = JSON.parse(data);
						createElement(obj);
                     }
                  });
              }
         }

		function createElement(data){
			console.log("Create: ", data);
			if(data.forEach){
				data.forEach(function(item){
					console.log("ITEM", item);
					if(item.type == "group"){
						var targetElement = document.getElementById('contentLocation');
					    var li = document.createElement('li');
						li.className = "mix panel group "+ item.category;
					    li.innerHTML =
					                    '<div class="panel panel-primary" style="margin-bottom:0px;">'+
										'<div class="panel-heading">'+
										'<h3 class="panel-title">Group: '+ item.name +'</h3>'+
										'</div>'+
										'<div class="panel-body">'+
										(item.description ? item.description:"No Description Available")+
										'</div>'+
					                    '</div>';
					    // Append 'foo' element to target element
										// '<img src="'+ item.image +'" alt="Image 1"> '+
					    targetElement.appendChild(li)
					}
					if(item.type == "event"){
						var targetElement = document.getElementById('contentLocation');
					    var li = document.createElement('li');
						li.className = "mix panel event "+ item.category;
					    li.innerHTML =
					                    '<div class="panel panel-primary" style="margin-bottom:0px;">'+
										'<div class="panel-heading">'+
										'<h3 class="panel-title">Event: '+ item.name +'</h3>'+
										'</div>'+
										'<div class="panel-body">'+
										(item.description ? item.description:"No Description Available")+
										'</div>'+
					                    '</div>';
					    // Append 'foo' element to target element
										// '<img src="'+ item.image +'" alt="Image 1"> '+
					    targetElement.appendChild(li)
					}
				});
			}else{
				console.log("No Results");
			}
			var targetElement = document.getElementById('contentLocation');
			var li = document.createElement('li');
			li.className = "gap";
			targetElement.appendChild(li);
			var li2 = document.createElement('li');
			li2.className = "gap";
			targetElement.appendChild(li2);
			buttonFilter.init();
			$('.cd-gallery ul').mixItUp('filter', 'all');
			// <li class="gap"></li>
			// <li class="gap"></li>
		}

        $("#searchButton").click(function(){
           search();
        });

        $('#search').keyup(function(e) {
           if(e.keyCode == 13) {
              search();
            }
        });
    });
	</script>

</head>
<body>
	<!-- Static navbar -->
    <?php
       $path = $_SERVER['DOCUMENT_ROOT'];
       $path .= "/Views/General/navbar.php";
       include_once($path);
    ?>

	<div class="panel panel-primary" style="margin:60px 0px 0px; padding:0px 50px;">
		<div>
				<!-- <form method="get" action="" name="searchGroup"> -->
			<div class="input-group">
				<input type="text" id="search" class="form-control input-lg" placeholder="Search for a group" style="margin-bottom:10px; height:55px; font-size:25px;">
				<span class="input-group-btn">
					<button class="btn btn-default" id="searchButton" type="button" type="submit" value="Search" class="search_button"><div class="icon-preview"><i class="mdi-action-search"></i><span></span></div></button>
				</span>
			</div><!-- /input-group -->
				<!-- </form> -->
		</div>
	  </div>

	<main class="cd-main-content">
		<div class="cd-tab-filter-wrapper">
			<div class="cd-tab-filter">
				<ul class="cd-filters">
					<li class="placeholder">
						<a data-type="all" href="#0">All</a> <!-- selected option on mobile -->
					</li>
					<li class="filter"><a class="selected" href="#0" data-type="all">All</a></li>
					<li class="filter" data-filter=".group"><a href="#0" data-type="group">Groups</a></li>
					<li class="filter" data-filter=".event"><a href="#0" data-type="event">Event</a></li>

				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->

		<section class="cd-gallery">
			<ul id="contentLocation">


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
<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/material.js"></script>
<script type="text/javascript" src="/js/ripples.js"></script>
<script type="text/javascript" src="/js/timeline.js"></script>
<script src="/js/jquery.mixitup.min.js"></script>
<script src="/js/contentFilter.js"></script> <!-- Resource jQuery -->
</body>
</html>
