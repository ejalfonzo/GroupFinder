<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
require_once("../../config/db.php");
require_once("Events.php");
$events = new Events();
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
		var user = '<?php echo $_SESSION["id"]; ?>';

		function joinEvent(eventIT){
		 $.ajax({
			 type:"post",
			 url:"handler.php",
			 data:{"join":eventIT, "userID":user},
			 success:function(data){
				 console.log("Result",data);
				 // $("#search").val("");
			//    $("#eventIT"+data).html("");
				 var obj = JSON.parse(data);
				 alert(obj);
				//  console.log("JOIN Event: ", obj);
				 search();
			 }
		 });
	}

	function leaveEvent(eventIT){
		 $.ajax({
			 type:"post",
			 url:"handler.php",
			 data:{"leave":eventIT, "userID":user},
			 success:function(data){
				 console.log("Result",data);
				 // $("#search").val("");
			//    $("#group"+data).html("");
				 var obj = JSON.parse(data);
				 alert(obj);
				//  console.log("LEAVE Event: ", obj);
				 search();
				 // createElement(obj);
			 }
		 });
	}

	function search(){
		 var title=$("#search").val();
		 if(title!=""){
			$.ajax({
				 type:"post",
				 url:"search.php",
				 data:{"search":title, "userID":user},
				 success:function(data){
					//  console.log("Result",data);
					 // $("#search").val("");
					 $("#contentLocation").html("");
					 var obj = JSON.parse(data);
					 createElement(obj);
					}
			 });
		 }
	}

	function createElement(data){
		// console.log("Create: ", data);
		if(data.forEach){
			var user = '<?php echo $_SESSION["id"]; ?>';
			data.forEach(function(item){
				// console.log("ITEM", item);
				var targetElement = document.getElementById('contentLocation');
					var li = document.createElement('li');
					li.className = "mix panel event "+ item.category;
					var inHTML =  '<div class="panel panel-primary" style="margin-bottom:0px;">'+
						 '<div class="panel-heading">'+
						 '<h3 class="panel-title">'+ item.name +'</h3>'+
						 '</div>'+
						 '<div class="panel-body">'+
						 '<div style="float: left; margin-right: 20px;">'+
						 '<img src="'+ item.image +'" alt="Friend Image" width="40" height="40"> '+
						 '</div>'+
						 '<div>'+
						 '<h3>Description:</h3>'+
						 (item.description ? item.description:"No Description Available")+
						 '</div>'+
						 '</div>';
						 if(user){
							 inHTML = inHTML +'<div class="panel-footer" style="text-align:center;">';
							 if(!item.isMember){
									 inHTML = inHTML + '<button id="event'+item.id+'" class="btn btn-flat btn-info" onclick="joinEvent('+item.id+')" >Join Event</button>';
							 }else{
									 inHTML = inHTML + '<button id="event'+item.id+'" class="btn btn-flat btn-warning" onclick="leaveEvent('+item.id+')" >Leave Event</button>';
							 }
							 inHTML = inHTML + '</div>'+
							 '</div>';
						 }else{
							 inHTML = inHTML +'</div>';
						 }
						li.innerHTML = inHTML;
						targetElement.appendChild(li)
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

    $(document).ready(function(){

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
				<input type="text" id="search" class="form-control input-lg" placeholder="Search for events" style="margin-bottom:10px; height:55px; font-size:25px;">
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
					<li class="filter" data-filter=".event"><a href="#0" data-type="event">Event</a></li>
					<!-- <li class="filter" data-filter=".image"><a href="#0" data-type="image">Team</a></li> -->
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
					<h4>Select</h4>

					<div class="cd-filter-content">
						<div class="cd-select cd-filters">
							<select class="filter" name="selectThis" id="selectThis">
								<option value="">Choose an option</option>
								<?php
								 $categories = $events->getEventCategories();
								//  echo("<script>console.log('results_row: ".json_encode($categories->id_category)."');</script>");
									if($categories != null){
										while($row = $categories->fetch_object()){
					               			echo('<option value=".'.$row->id_category. '">'. $row->name . '</option>');
					          			}
								 	}
								?>
							</select>
						</div> <!-- cd-select -->
					</div> <!-- cd-filter-content -->
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
