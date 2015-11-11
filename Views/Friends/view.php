<?php
if (session_id() === "" && $_SESSION['user_login_status'] != 1) { session_start(); }
// include the configs / constants for the database connection
require_once("../../config/db.php");
require_once("Friends.php");
$friends = new Friends();
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
	<link rel="stylesheet" href="/css/contentFilter-style.css"> <!-- Resource style -->
	<script src="/js/modernizr.js"></script> <!-- Modernizr -->
	<script type="text/javascript" src="/js/jquery.js"></script>
	<title>Group Finder</title>
	<script type="text/javascript">
	function addFriend(friend){
	   $.ajax({
		   type:"post",
		   url:"handler.php",
		   data:"add="+friend,
		   success:function(data){
			   console.log("Result",data);
			   // $("#search").val("");
			//    $("#group"+data).html("");
			   var obj = JSON.parse(data);
			   alert(obj);
			   console.log("ADD FRIEND: ", obj);
				 search();
		   }
	   });
	}

	function removeFriend(friend){
	   $.ajax({
		   type:"post",
		   url:"handler.php",
		   data:"remove="+friend,
		   success:function(data){
			   console.log("Result",data);
			   // $("#search").val("");
			//    $("#group"+data).html("");
			   var obj = JSON.parse(data);
			   alert(obj);
			   console.log("REMOVE FRIEND: ", obj);
				 search();
			   // createElement(obj);
		   }
	   });
	}
	function search(){
			 var title=$("#search").val();
			 if(title!=""){
				 // $("#contentLocation").html("<img alt="search" src='ajax-loader.gif'/>");
					$.ajax({
						 type:"post",
						 url:"handler.php",
						 data:"search="+title,
						 success:function(data){
		 // $("#search").val("");
		 $("#contentLocation").html("");
		 var obj = JSON.parse(data);
		 createElement(obj);
							}
					 });
			 }
	}

 function createElement(data){
	//  console.log("Create: ", data);
	 if(data.forEach){
		 var user = '<?php echo $_SESSION["id"]; ?>';
		 data.forEach(function(item){
			 console.log("ITEM", item);
			 var targetElement = document.getElementById('contentLocation');
			 var li = document.createElement('li');
			 li.className = "mix panel friend ";
			 var inHTML =  '<div class="panel panel-primary" style="margin-bottom:0px;">'+
							 '<div class="panel-heading">'+
							 '<h3 class="panel-title">'+ item.user_name +'</h3>'+
							 '</div>'+
							 '<div class="panel-body">'+
							 '<div style="float: left; margin-right: 20px;">'+
							 '<img src="'+ item.image +'" alt="Friend Image" width="40" height="40"> '+
							 '</div>'+
							 '<div>'+
							 '<h3>Email:</h3>'+
							 (item.email ? item.email:"No Email Available")+
							 '</div>'+
							 '</div>';
							 if(user){
								 inHTML = inHTML +'<div class="panel-footer" style="text-align:center;">';
								 if(!item.isFriend){
										 inHTML = inHTML + '<button id="friend'+item.id+'" class="btn btn-flat btn-info" onclick="addFriend('+item.id+')" >Add Friend</button>';
								 }else{
										 inHTML = inHTML + '<button id="friend'+item.id+'" class="btn btn-flat btn-warning" onclick="removeFriend('+item.id+')" >Remove Friend</button>';
								 }
								 inHTML = inHTML + '</div>'+
								 '</div>';
							 }else{
								 inHTML = inHTML +'</div>';
							 }
				 li.innerHTML = inHTML;
				 if(user != item.id){
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
 }
	</script>
	<script type="text/javascript">
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
					<!-- <li class="filter" data-filter=".image"><a href="#0" data-type="image">Images</a></li> -->
				</ul> <!-- cd-filters -->
			</div> <!-- cd-tab-filter -->
		</div> <!-- cd-tab-filter-wrapper -->

		<section class="cd-gallery">
			<ul id="contentLocation">
				<!-- Content goes here -->
			</ul>
			<div class="cd-fail-message">No results found</div>
		</section> <!-- cd-gallery -->

		<div class="cd-filter">
			<form>
				<!-- <div class="cd-filter-block">
					<h4>Search</h4>

					<div class="cd-filter-content">
						<input type="search" placeholder="Try panel...">
					</div> -->
					 <!-- cd-filter-content -->
				<!-- </div>  -->
				<!-- cd-filter-block -->

				<!-- <div class="cd-filter-block">
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
					</ul>  -->
				<!-- </div>  -->
				<!-- cd-filter-block -->

				<div class="cd-filter-block">
					<h4>Select</h4>

					<div class="cd-filter-content">
						<div class="cd-select cd-filters">
							<select class="filter" name="selectThis" id="selectThis">
								<option value="">Choose an option</option>
								<?php
								 $categories = $friends->getFriendCategories();
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

				<!-- <div class="cd-filter-block">
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
					</ul>  -->
					<!-- cd-filter-content -->
				<!-- </div>  -->
				<!-- cd-filter-block -->
			</form>

			<a href="#0" class="cd-close">Close</a>
		</div> <!-- cd-filter -->

		<a href="#0" class="cd-filter-trigger">Filters</a>
	</main> <!-- cd-main-content -->

<script type="text/javascript" src="/js/bootstrap.js"></script>
<script type="text/javascript" src="/js/material.js"></script>
<script type="text/javascript" src="/js/ripples.js"></script>
<script src="/js/jquery.mixitup.min.js"></script>
<script src="/js/contentFilter.js"></script> <!-- Resource jQuery -->
<script>
$.material.init();
</script>
</body>
</html>
