var ans = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0]
var nowfollowers = 0;
var page = 1;
var pageCount = 0;
var nowlist = [];
var list = [];
var diff = [];
var normal_unfollowers = [];
var deleted_unfollowers = [];
var all_unfollowers = [];
var followers = 0;
var user = "SuperScratcher_1234";

$(document).ready(function () {
	$(".agreement").on("click", function () {
		if ($(".agreement:checked").length > 1) {
			$('#submit-unfollowers').prop('disabled', false);
		}
		else {
			$('#submit-unfollowers').prop('disabled', true);
		}
	});
	$(document).on('click', '#show-deleted-users', function () {
		var show_deleted_users = $('#show-deleted-users').is(':checked');
		if (show_deleted_users === true) {
			$('#normal-unfollowers').hide();
			$('#all-unfollowers').show();
		} else if (show_deleted_users === false) {
			$('#normal-unfollowers').show();
			$('#all-unfollowers').hide();
		}
	});
	$("#submit-unfollowers").click(function () {
		$('#unfollowers-results').remove();
		$('.agreement').prop("disabled", true);
		$("#submit-unfollowers").prop("disabled", true);
		$("#unfollowers-username").prop("disabled", true);
		user = $("#unfollowers-username").val();
		console.log("Loading unfollowers: " + user);
		ans = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0]
		nowfollowers = 0;
		page = 1;
		nowlist = [];
		list = [];
		diff = [];
		normal_unfollowers = [];
		deleted_unfollowers = [];
		all_unfollowers = [];
		followers = 0;
		pageCount = 0;
		unfollowers = 0;
		/*
		document.getElementById("percBar").style.width = '0%';
		document.getElementById("usertitle").innerHTML = "Loading...";
		document.getElementById("userlist").innerHTML = "You will see who unfollowed this user here...";
		*/
		$.get("https://scratch.mit.edu/users/" + user + "/followers/?page=" + page, start).fail(function () { alert("That user does not exist."); console.log("That user doesn't exists"); ready(); });
	});
	/*
	$("#unfdirect").click(function(){
		prompt('Copy and paste this link to auto download the enetered project',"https://juegostrower.github.io/unfollowers/#" + $("#unfuser").val());
	});
	$("#unfuser").bind("input paste", function(){
	$("#unfuser").val($("#unfuser").val().match(/([^\/]*)\/*$/)[1].replace(/ /g, '').replace(/\//g, '').replace(/%20%/g, '').substring(0,30));
	});
	if (!window.location.hash.replace("#", "") == ""){
		$("#unfuser").val(window.location.hash.replace("#", "").substring(0,30).match(/([^\/]*)\/*$/)[1].replace(/ /g, '').replace(/%20%/g, ''));
		document.getElementById("unfnow").click();
	}
	*/
});
function start(data) {
	$("#unfollowers-username").prop("disabled", true);
	$('.unfollowers-agreement').fadeOut(fadeAnimationDuration);
	$('#submit-unfollowers').fadeOut(fadeAnimationDuration, function () {
		$('<p class="text-justify font-size-18" id="loading-status-text" style="display: none;"></p> <div class="progress h-25" id="current-followers-progress-div" style="display: none;"> <!-- h-25 = height: 2.5rem (25px) --> <div id="current-followers-progress" class="progress-bar rounded-0 progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div> <!-- w-three-quarter = width: 75%, rounded-0 = border-radius: 0 --> </div>').insertAfter('#unfollowers-form');
		$('#current-followers-progress').attr('aria-valuenow', 0).css('width', 0 + '%');
		$('#current-followers-progress').html('');
		//$('#submit-unfollowers').remove();
		$('#loading-status-text').html('Indexing current followers... (Step 1/3)');
		$('#loading-status-text').fadeIn(fadeAnimationDuration);
		$('#current-followers-progress-div').fadeIn(fadeAnimationDuration, function () {
			loaded(data);
		});
	})
}
function loaded(data) {
	var $dom = $(data);
	if (pageCount == 0) {
		pageCount = ($dom.find('span.page-current').children() || []).length + 1;
		if (pageCount > 50) {
			$('<div class="alert alert-secondary" id="expected-long-load-time" role="alert" style="display: none;"> <h4 class="alert-heading">This may take a while...</h4> This user has a lot of followers so it will take longer than usual to load all unfollowers. Sit back and relax, or take a break from your device and come back a little bit later. Please do not close this tab while waiting for the results! Thank you for your patience!</div>').insertAfter('#unfollowers-form');
			$('#expected-long-load-time').fadeIn(fadeAnimationDuration);
		}
	}
	var $users = $dom.find('span.title').children();
	for (var i = 0; i < $users.length; i++) {
		nowlist.push($users[i].text.trim());
	}
	nowfollowers += $users.length;
	//setProgress(40*(page/pageCount));
	console.log("Indexing current followers: page " + page + "/" + pageCount);
	progress = page / pageCount * 100;
	progress = Math.round(progress);
	$('#current-followers-progress').attr('aria-valuenow', progress).css('width', progress + '%');
	$('#current-followers-progress').html(progress + '%');
	if (page <= pageCount) {
		page++;
		$.get("https://api.allorigins.win/raw?url=https://scratch.mit.edu/users/" + user + "/followers/?page=" + page, loaded).fail(function () { alert("An error has occured. Please refresh the page and try again!"); });
	} else {
		continueCode();
	}
	/*$.ajax({
		type: 'GET',
		url: 'https://api.codetabs.com/v1/proxy/?quest=https://scratch.mit.edu/users/' + user + '/followers/?page=' + page,
		success: function () {
			if(pageCount < page){
				continueCode();
			}else{
				loaded();
				
			}
			
		},
		error: function (xhr) {
			if (xhr.status = 404) {
				alert("404");
			}
		}
	});*/
}

function continueCode() {
	if (page < pageCount) {
		$('#current-followers-progress').addClass('bg-danger');
		return;
	}
	$('#current-followers-progress').attr('aria-valuenow', 100).css('width', 100 + '%');
	$('#current-followers-progress').html(100 + '%');

	$('<div class="progress h-25" id="old-followers-progress-div" style="display: none;"> <!-- h-25 = height: 2.5rem (25px) --> <div id="old-followers-progress" class="progress-bar rounded-0 progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div> <!-- w-three-quarter = width: 75%, rounded-0 = border-radius: 0 --> </div>').insertAfter('#loading-status-text');

	$('#old-followers-progress').attr('aria-valuenow', 0).css('width', 0 + '%');
	$('#loading-status-text').fadeOut(fadeAnimationDuration);
	$('#current-followers-progress-div').fadeOut(fadeAnimationDuration, function () {
		$('#current-followers-progress-div').remove();
		$('#old-followers-progress').html('');
		$('#loading-status-text').html('Indexing old followers... (Step 2/3)');
		$('#loading-status-text').fadeIn(fadeAnimationDuration);
		$('#old-followers-progress-div').fadeIn(fadeAnimationDuration);
	})

	indexOldFollowers();
	function indexOldFollowers() {
		$.ajax({
			type: "GET",
			url: 'https://api.allorigins.win/raw?url=https://api.scratch.mit.edu/users/' + user + '/followers?offset=' + followers,
			dataType: "json",
			success: function (response) {
				console.log(response);
				ans = response;
				for (var i = 0; i < ans.length; i++) {
					list.push(ans[i].username);
				}
				followers += ans.length;
				//setProgress(40 + 49*((followers/20)/(pageCount * 3 + 1)));
				console.log("Indexing old followers: page " + Math.round(followers / 20) + "/" + (pageCount * 3 + 1) + " (approx)");
				old_followers_page = Math.round(followers / 20);
				progress = old_followers_page / (pageCount * 3 + 1) * 100;
				progress = Math.round(progress);
				//alert(progress);
				$('#old-followers-progress').attr('aria-valuenow', progress).css('width', progress + '%');
				$('#old-followers-progress').html(progress + '%');
				if (ans.length > 19) {
					indexOldFollowers();
				} else {
					if (ans[0] != false) {
						console.log("Checking difrences between current and old");
						for (var i = 0; i < list.length; i++) {
							if (!(nowlist.includes(list[i]))) {
								diff.push(list[i]);
							}
						}
						console.log("Complete");
						unfollowers = followers - nowfollowers;
						//document.getElementById("usertitle").innerHTML = unfollowers + " Users Unfollowed " + user + ".";
						console.log(unfollowers + " Users Unfollowed " + user + ".");
						//document.getElementById("userlist").innerHTML = "Those are: " + diff.toString().replace(/,/g,", ")
						console.log("Those are: " + diff.toString().replace(/,/g, ", "));
						$('#old-followers-progress').attr('aria-valuenow', 100).css('width', 100 + '%');
						$('#old-followers-progress').html(100 + '%');

						unfollowers_array = diff.toString().split(',');
						console.log(unfollowers_array);
						if (unfollowers_array == "") {
							unfollowers_array = [];
						}
						indexDeletedUsers(unfollowers_array);
					}
				}
			},
			error: function () {
				$('#old-followers-progress').addClass('bg-danger');
				ans = [false];
				ready();
				console.log("Error! API unavailable");
				document.getElementById("usertitle").innerHTML = "Error! API unavailable";
				console.log("Please try again later. If this keeps happening, please report this error in my profile (@JuegOStrower).");
				document.getElementById("userlist").innerHTML = "Please try again later. If this keeps happening, please report this error in my profile (@JuegOStrower).";
			}
		})
	}
}
function indexDeletedUsers(users) {
	$('<div class="progress h-25" id="deleted-unfollowers-progress-div"style="display: none;"> <!-- h-25 = height: 2.5rem (25px) --> <div id="deleted-unfollowers-progress" class="progress-bar rounded-0 progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div> <!-- w-three-quarter = width: 75%, rounded-0 = border-radius: 0 --> </div>').insertAfter('#loading-status-text');

	$('#loading-status-text').fadeOut(fadeAnimationDuration);
	$('#old-followers-progress-div').fadeOut(fadeAnimationDuration, function () {
		$('#old-followers-progress-div').remove();
		$('#deleted-followers-progress').html('');
		$('#loading-status-text').html('Indexing deleted unfollowers... (Step 3/3)');
		$('#loading-status-text').fadeIn(fadeAnimationDuration);
		$('#deleted-unfollowers-progress-div').fadeIn(fadeAnimationDuration);
	})
	var users_counter = 0;
	checkForDeletedUser();
	function checkForDeletedUser() {
		progress = users_counter / users.length * 100;
		progress = Math.round(progress);
		$('#deleted-unfollowers-progress').attr('aria-valuenow', progress).css('width', progress + '%');
		$('#deleted-unfollowers-progress').html(progress + '%');
		if (users_counter != users.length && Array.isArray(users) && users.length) {
			username = users[users_counter];
			console.log(username);
			$.ajax({
				type: 'GET',
				url: 'https://api.allorigins.win/raw?url=https://scratch.mit.edu/users/' + username,
				success: function (response) {
					if (response != "") {
						normal_unfollowers.push(username);
						users_counter++;
						checkForDeletedUser();
					} else {
						deleted_unfollowers.push(username);
						users_counter++;
						checkForDeletedUser();
					}

				},
				error: function (xhr) {
					if (xhr.status = 404) {

					}
				}
			});
		} else {
			console.log(normal_unfollowers);
			console.log(deleted_unfollowers);
			$('.unfollowers-agreement').fadeIn(fadeAnimationDuration);
			$('#submit-unfollowers').fadeIn(fadeAnimationDuration, function () {
				$('<br><div id="unfollowers-results"><div class="custom-switch"><input type="checkbox" id="show-deleted-users"><label for="show-deleted-users">Show deleted users</label></div><h4>' + unfollowers_array.length + ' users unfollowed ' + user + ' (of whom ' + deleted_unfollowers.length + ' are deleted)</h4><div id="normal-unfollowers"></div><div id="all-unfollowers"></div></div>').insertAfter($('.unfollowers-agreement').last());
				$.each(normal_unfollowers, function (index, value) {
					if ((index + 1) != normal_unfollowers.length) {
						$('#normal-unfollowers').append('<a href="https://scratch.mit.edu/users/' + value + '">' + value + '</a>, ');
					} else {
						$('#normal-unfollowers').append('<a href="https://scratch.mit.edu/users/' + value + '">' + value + '</a>');
					}
				})
				$.each(all_unfollowers = $.merge(normal_unfollowers, deleted_unfollowers), function (index, value) {
					if ((index + 1) != all_unfollowers.length) {
						if ($.inArray(value, deleted_unfollowers) > -1) {
							$('#all-unfollowers').append('<i class="text-danger">' + value + '</i>, ');
						} else {
							$('#all-unfollowers').append('<a href="https://scratch.mit.edu/users/' + value + '">' + value + '</a>, ');
						}
					} else {
						if ($.inArray(value, deleted_unfollowers) > -1) {
							$('#all-unfollowers').append('<i class="text-danger">' + value + '</i>');
						} else {
							$('#all-unfollowers').append('<a href="https://scratch.mit.edu/users/' + value + '">' + value + '</a>');
						}
					}
				})
				$('#normal-unfollowers').show();
				$('#all-unfollowers').hide();
				ready();
				$('#deleted-unfollowers-progress').attr('aria-valuenow', 100).css('width', 100 + '%');
				$('#loading-status-text').fadeOut(fadeAnimationDuration);
				$('#deleted-unfollowers-progress-div').fadeOut(fadeAnimationDuration, function () {
					$('#deleted-unfollowers-progress-div').remove();
					$('#loading-status-text').remove();
					return;
				})
			});

		}

	}
}
/*
function setProgress(perc) {
	var width = document.getElementById('percBar').style.width.replace("%","");
	var id = setInterval(interval, 10);
	function interval() {
		if (width >= perc) {
			clearInterval(id);
		} else {
			width++;
			document.getElementById("percBar").style.width = width + '%';
		}
	}
}
*/
function ready() {
	//setProgress(100);
	$("#submit-unfollowers").prop("disabled", false);
	$("#unfollowers-username").prop("disabled", false);
	$('.agreement').prop("disabled", false);
}