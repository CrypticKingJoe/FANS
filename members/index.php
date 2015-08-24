<?php
$TITLE = "Members";
$PAGE  = "Members";
$SIDEBAR_LEFT = true;

require "../inc/Settings.php";
require "../inc/Head.php";
?>
<div class="container">
	<h2>Filter</h2>
	<hr />
	<div class="btn-group btn-group-sidebar">
		<a class="btn btn-white btn-sm" id="f-all">All</a>
		<a class="btn btn-blue btn-sm" id="f-online">Online</a>
		<a class="btn btn-blue btn-sm" id="f-staff">All Staff Online</a>
		<a class="btn btn-blue btn-sm" id="f-moderators">Moderators Online</a>
		<a class="btn btn-blue btn-sm" id="f-artists">Artists Online</a>
	</div>
</div>
<div class="container">
	<h2>Members</h2>
	<p>There are <strong><span id="stat-registered">0 registered</span></strong> users, <strong><span id="stat-userso">0 users</span></strong> and <strong><span id="stat-guestso">0 guests</span></strong> are online.</p>
	<hr />
	<input class="input" id="q" type="text" name="q" placeholder="Looking for someone?" /><br /><br /><br />
	<img id="loading" class="loading" src="../img/loading.gif" />
</div>
</div>
<div class="container">
	<div id="members-results">
		<div class="members"></div>
	</div>
</div>

<script>
	$(document).ready(function() {
		function renderMembers(data) {
			$('.members').html('');
			$('#loading').hide();
			if (data != '') {
				var members = data.split(':');

				for (var i = 0; i < members.length; i++) {
					var userdata = members[i].split(',');
					var username = userdata[1];
					var userid = userdata[0];

					$('.members').append("<div class='member-card'><a href='../profile/?ID=" + userid + "'><img src='http://placehold.it/100x200' /></a><br /><a href='../profile/?ID=" + userid + "'>" + username + "</a></div>");
				}
			}
		}
		
		function removeFilterClasses() {
			if ($('#f-all').hasClass("btn-white")) {
				$('#f-all').removeClass("btn-white");
				$('#f-all').addClass("btn-blue");
			}
			
			if ($('#f-online').hasClass("btn-white")) {
				$('#f-online').removeClass("btn-white");
				$('#f-online').addClass("btn-blue");
			}
			
			if ($('#f-staff').hasClass("btn-white")) {
				$('#f-staff').removeClass("btn-white");
				$('#f-staff').addClass("btn-blue");
			}
			
			if ($('#f-moderators').hasClass("btn-white")) {
				$('#f-moderators').removeClass("btn-white");
				$('#f-moderators').addClass("btn-blue");
			}
			
			if ($('#f-artists').hasClass("btn-white")) {
				$('#f-artists').removeClass("btn-white");
				$('#f-artists').addClass("btn-blue");
			}
		}
		
		var filterActive = 0;
		
		// load initial
		$.ajax({
			url: "../api/members.php",
			method: "GET",
			data: { 
				"query": true,
				"start": "0",
				"stop": "12"
			}
		}).done(function(data) {
			renderMembers(data);
		});
		
		// search bar
		$('#q').keyup(function() {
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12",
					"filter": filterActive
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// filter all
		$('#f-all').click(function() {
			$('#loading').show();
			$('.members').html('');
			
			removeFilterClasses();
			filterActive = 0;
			
			if ($('#f-all').hasClass("btn-blue")) {
				$('#f-all').removeClass("btn-blue");
				$('#f-all').addClass("btn-white");
			}
			
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12"
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// filter online
		$('#f-online').click(function() {
			$('#loading').show();
			$('.members').html('');
			
			removeFilterClasses();
			filterActive = 1;
			
			if ($('#f-online').hasClass("btn-blue")) {
				$('#f-online').removeClass("btn-blue");
				$('#f-online').addClass("btn-white");
			}
			
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12",
					"filter": "1"
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// staff online online
		$('#f-staff').click(function() {
			$('#loading').show();
			$('.members').html('');
			
			removeFilterClasses();
			filterActive = 2;
			
			if ($('#f-staff').hasClass("btn-blue")) {
				$('#f-staff').removeClass("btn-blue");
				$('#f-staff').addClass("btn-white");
			}
			
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12",
					"filter": "2"
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// moderators online online
		$('#f-moderators').click(function() {
			$('#loading').show();
			$('.members').html('');
			
			removeFilterClasses();
			filterActive = 3;
			
			if ($('#f-moderators').hasClass("btn-blue")) {
				$('#f-moderators').removeClass("btn-blue");
				$('#f-moderators').addClass("btn-white");
			}
			
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12",
					"filter": "3"
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// artists online online
		$('#f-artists').click(function() {
			$('#loading').show();
			$('.members').html('');
			
			removeFilterClasses();
			filterActive = 4;
			
			if ($('#f-artists').hasClass("btn-blue")) {
				$('#f-artists').removeClass("btn-blue");
				$('#f-artists').addClass("btn-white");
			}
			
			var qval = $('#q').val();
			
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"query": true,
					"q": qval,
					"start": "0",
					"stop": "12",
					"filter": "4"
				}
			}).done(function(data) {
				renderMembers(data);
			});
		});
		
		// reload user stats
		function reloadUserStats() {
			$.ajax({
				url: "../api/members.php",
				method: "GET",
				data: {
					"stats": true
				}
			}).done(function(data) {
				var dataSet = data.split(',');

				$('#stat-registered').html(dataSet[0] + ' registered');
				$('#stat-userso').html(dataSet[1] + ' users');
				$('#stat-guestso').html(dataSet[2] + ' guests');
			});
		}
		reloadUserStats();
		
		window.setInterval(function(){
			reloadUserStats();
		}, 1000);
	});
</script>