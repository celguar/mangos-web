<?php

if (INCLUDED!==true) { include('index.htm'); exit; }

?>
<style type="text/css">
	.breakWord { width:100%; overflow: hidden; word-wrap:break-word; }
</style>
<script type="text/javascript" src="new-hp/js/forum.js"></script>
<div style="height: 21px; left: -1000px; top: 420px; visibility: hidden;" id="contents">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
	<td><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
	<td bgcolor="#000000"></td>
	<td><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
</tr>
<tr>
	<td bgcolor="#000000"></td>
	<td>
	
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody><tr>
				<td bgcolor="#000000" height="1" width="1"></td>
				<td bgcolor="#d5d5d7" height="1"><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
				<td bgcolor="#000000" height="1" width="1"></td>
			  </tr>
			  <tr>
				<td bgcolor="#a5a5a5" width="1"><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
				<td class="trans_div" valign="top"><div style="color: rgb(255, 255, 255); visibility: visible;" id="tooltipText"><b>Gnome</b></div></td> 
				<td bgcolor="#a5a5a5" width="1"><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
			  </tr>
			  <tr>
				<td bgcolor="#000000" height="1" width="1"></td>
				<td bgcolor="#4f4f4f"><img src="new-hp/images/pixel.gif" alt="" height="2" width="1"></td>
				<td bgcolor="#000000" height="1" width="1"></td>
			  </tr>
			</tbody></table>
	
	</td>
	<td bgcolor="#000000"></td>
</tr>
<tr>
	<td><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
	<td bgcolor="#000000"></td>
	<td><img src="new-hp/images/pixel.gif" alt="" height="1" width="1"></td>
</tr>
</tbody></table>
			

</div>
<script type="text/javascript">

//<![CDATA[
var objGlobal;
var startContainerHeight=0;
var topPadding=365;
if(is_safari)
	topPadding=240;
var topScrollLocation=0;

function floater(){
	
	try{
	var scrollTopValue=document.documentElement.scrollTop;
	if(is_safari)
		scrollTopValue=document.body.scrollTop;
	var divHeight=document.getElementById("floatingContainer"+previousPost).offsetHeight;
	var browserHeight=document.documentElement.clientHeight;

		if(scrollTopValue>topPadding && divHeight<browserHeight){
				if((scrollTopValue+divHeight)<(document.body.offsetHeight-260))
					objGlobal.style.top=scrollTopValue-topPadding+"px";
					


		}else{

				objGlobal.style.top="0px";

		}
	}catch(err){}

}
function init(){

	objGlobal = document.getElementById("floatingContainer2");
	window.onscroll=floater;
	switchPost(postIdArray[0])
	
}
function testFunc(){

	alert(objGlobal.style.top)
	objGlobal.style.top=200+"px";

}

var previousPost=0;
var previousBg=1;

function hilightPost(postId) {
	var obj;

	if(postId != previousPost && postId != 0){
		obj = document.getElementById("colorMod" + postId);
		obj.style.backgroundColor="#0D242D";
	}
	
}

function restorePost(postId) {
	var obj;

	if(postId != previousPost && postId != 0){
		obj = document.getElementById("colorMod" + postId);
		obj.style.backgroundColor="transparent";
	}


}

function switchPost(postId, linkId) {
	var obj;
	
	
	if (postId == previousPost) {
		document.location.href=linkId;
	
	}else{
	
		if(previousPost) {
		
			obj = document.getElementById("colorMod" + previousPost);
			// added to avoid javascript error for no search results
			if (obj == null) {
				return;
			}
			obj.style.backgroundColor="transparent";
			
			obj = document.getElementById("floatingContainer" + previousPost);
			obj.style.display="none";		
			
			obj = document.getElementById("searchArrow" + previousPost);
			obj.style.visibility="hidden";
			
			obj = document.getElementById("miniText" + previousPost);
			obj.innerHTML='<img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" border="0" alt="" />';

		}


		obj = document.getElementById("searchArrow" + postId);
		// added to avoid javascript error for no search results
		if (obj == null) {
			return;
		}
		obj.style.visibility="visible";

		obj = document.getElementById("floatingContainer" + postId);
		obj.style.display="block";

		obj = document.getElementById("colorMod" + postId);
		obj.style.backgroundColor="#063449";

		obj = document.getElementById("miniText" + postId);

		obj.innerHTML='<img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-jumpto-post.gif" border="0" alt="" />';



		var divHeight=document.getElementById("floatingContainer"+postId).offsetHeight;

		if(startContainerHeight==0)
			startContainerHeight = document.getElementById("searchbackground").offsetHeight;
		
		
		obj = document.getElementById("floatingContainer");

		if(!is_opera)
		if (divHeight > startContainerHeight){
			obj.style.height=divHeight+"px";
			obj = document.getElementById("searchbackground");
			obj.style.height=divHeight+"px";
		}else{
			obj.style.height=startContainerHeight+"px";
			obj = document.getElementById("searchbackground");
			obj.style.height=startContainerHeight+"px";			
		}
		

		//alert(obj.style.height)

		previousPost = postId;

		floater();

		//testFunc();

	}

}

function checkSearchField(){
	textSearch = document.searchForm.searchText.value;
	characterName = document.searchForm.characterName.value;
	return true;
}

init();
//]]>
</script>
<!-- Thread search options -->
<div class="clear"></div>
<div id="searchshell">
<form method="post" action="?n=forums&f=search" onsubmit="javascript: return checkSearchField()" name="searchForm" accept-charset="UTF-8">
<input name="stationId" value="1" type="hidden">
<div id="searchborder">
	<div>
		<div>
			<div>
				<div>
					<div class="padding">
	<div class="searchbox">
		<div class="listbox">
			<ul>
				<li class="icon"><img src="new-hp/images/forum/icons/search-text.gif" alt="Search" border="0"></li>
				<li class="text"><span><b>Forum Search:</b></span></li>
				<li>
					<select name="forumId">
					<optgroup label="Non-Categorized">
					<option value="0" SELECTED>All	
					<?php 
					$getallforums = mysql_query("SELECT id_forum, title, `group` FROM forums WHERE viewlevel<='".$userlvl."' ORDER BY `group`, title ASC", $MySQL_CON);
					while ($rowforum = mysql_fetch_array($getallforums)) {
						if ($fgroup!=$rowforum['group']) {
							$fgroup=$rowforum['group'];
							echo '<optgroup label="'.$FORUM_GROUP[$rowforum['group']].'">';
						}
						echo'<option value="'.$rowforum['id_forum'] .'">'.$rowforum['title'];
					}			
					?>
					</select>
				</li>
			</ul>
			<ul>
				<li class="icon"><img src="new-hp/images/forum/icons/search-text.gif" alt="Search" border="0"></li>
				<li class="text"><span><b>Topic Type:</b></span></li>
				<li>
					<select name="forumId">
					<option value="0" SELECTED>Any	
					<option value="news">News
					<option value="community">Community
					<option value="contest">Contest
					</select>
				</li>
				<li class="icon" style="padding-left: 5px;"><img src="new-hp/images/forum/icons/search-text.gif" alt="Blizzard Entertainment" border="0"></li>
				<li class="text"><span><b>Posts Search:</b></span></li>
				<li>
					<select name="forumId">
					<option value="news">Entire Post
					<option value="community">Titles Only
					</select>
				</li>
			</ul>
			<ul>
				<li class="icon"><img src="new-hp/images/pixel.gif" style="background: url('new-hp/images/forum/icons/flag.gif') no-repeat 0 50%;" border="0" height=21></li>
				<li class="text"><span><b>Topic Flag:</b></span></li>
				
				<li class="icon" style="padding-left: 0px;"><img src="new-hp/images/forum/square-grey.gif" alt="Blizzard Entertainment" border="0"></li>
				<li style="padding-top: 3px; margin-left: -8px"><span><b><label for="blizzardPoster2">Viewed:</label></b></span></li>
				<li><span><input class="checkbox" name="blizzardPoster" id="blizzardPoster2" value="true" type="checkbox" CHECKED></span></li>
				
				<li class="icon" style="padding-left: 10px;"><img src="new-hp/images/forum/square.gif" alt="Blizzard Entertainment" border="0"></li>
				<li style="padding-top: 3px; margin-left: -8px"><span><b><label for="blizzardPoster3">Unviewed:</label></b></span></li>
				<li><span><input class="checkbox" name="blizzardPoster" id="blizzardPoster3" value="true" type="checkbox" CHECKED></span></li>	
				
				<li class="icon" style="padding-left: 10px;"><img src="new-hp/images/forum/square-new.gif" alt="Blizzard Entertainment" border="0"></li>
				<li style="padding-top: 3px; margin-left: -8px"><span><b><label for="blizzardPoster4">New:</label></b></span></li>
				<li><span><input class="checkbox" name="blizzardPoster" id="blizzardPoster4" value="true" type="checkbox" CHECKED></span></li>	
				
				<li class="icon" style="padding-left: 10px;"><img src="new-hp/images/forum/square-update.gif" alt="Blizzard Entertainment" border="0"></li>
				<li style="padding-top: 3px; margin-left: -8px"><span><b><label for="blizzardPoster5">Updated:</label></b></span></li>
				<li><span><input class="checkbox" name="blizzardPoster" id="blizzardPoster5" value="true" type="checkbox" CHECKED></span></li>	
			</ul>
			<ul>
				<li class="icon"><img src="new-hp/images/forum/icons/search-text.gif" alt="Search" border="0"></li>
				<li class="text"><span><b>Text Search:</b></span>
				</li>
				
				<li><span><input name="searchText" size="40"></span>				
				</li>
			</ul>
			<ul>
				<li class="icon"><img src="new-hp/images/forum/icons/search.gif" alt="Search" border="0"></li>
				<li class="text"><span><b>Player Search:</b></span></li>
				
				<li><span><input name="characterName" value="" style="width: 100px;"></span>				
				</li>
				
				<li class="icon" style="padding-left: 5px;"><img src="new-hp/images/forum/icons/search-blizz.gif" alt="Blizzard Entertainment" border="0"></li>
				<li style="padding-top: 3px;"><span><b><label for="blizzardPoster1">Blizzard Poster Only:</label></b></span></li>
				<li><span><input class="checkbox" name="blizzardPoster" id="blizzardPoster1" value="true" type="checkbox"></span></li>		
			</ul>
			<ul>	
				<li class="icon"><img src="new-hp/images/forum/icons/search-recent.gif" alt="Blizzard Entertainment" border="0"></li>
				<li class="text"><span><b>Recent posts:</b></span></li>
				<li>					
					<select name="recentPosts" style="display: inline;">
						<option value="0" selected="selected">All Time</option>					
						<option value="1">Last Hour</option>
						<option value="24">Last Day</option>
						<option value="72">Last 3 Days</option>
						<option value="168">Last 7 Days</option>
					</select>
				</li>
			</ul>
			<div style="position: relative; clear: both; width: 1px;"><input src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/search-button.gif" style="position: absolute; top: -48px; left: 403px;" class="button" type="image"></div>
			</div>
		</div>
	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
</div>



<script type="text/javascript">
//<![CDATA[
	var postIdArray = new Array;
//]]>
</script>








 <!-- search submitted -->



 <!-- have search results -->

	<div id="cover" style="position: absolute; z-index: 999999; top: 0px; right: 10px; width: 300px; height: 3000px; display: none; background-color: red;"></div>

<div id="topicheader">

	<div style="float: right;">
	<a href="board.html?forumId=11079&amp;sid=1"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" alt="" border="0" height="41" width="104"></a>
	</div>
	
	<div id="topicview" style="margin-top: 14px;">
		<ul>
			<li><span title="Current time"><small><font color="white"><b>&nbsp;Forum Search Results</b>| 29/05/2007 13:26:45 UTC&nbsp;</font></small></span></li>
		</ul>
	</div>
</div>

<!-- Paging -->
<div id="paging">
	<div class="rpage">
	<span>
	
	<table border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td>
<img src="new-hp/images/forum/arrow-left.gif" border="0"></td><td><small><a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=1" class="current">1</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=2">2</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=3">3</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=4">4</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=5">5</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=6">6</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=7">7</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=8">8</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=9">9</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=10">10</a></small></td><td><a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=2"><img src="new-hp/images/forum/arrow-right.gif" border="0"></a></td></tr></tbody></table> 
	</span>	
	</div>
</div>





<!-- // begin search results disply -->
<!-- // start search content -->
<div id="searchcontainer"><!-- search container -->
	<table style="min-width: 920px;" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td valign="top" width="50%">
<!--[if IE]>
<div style="width: 450px;"><img src="/images/pixel.gif" /></div>
<![endif]-->
	<div style="position: relative; display: block; width: 100%;">
		<div style="margin: 0pt auto; position: relative; width: 420px;">
			<div class="searchbanner"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/title-search-results.gif" style="position: absolute; top: 7px; left: 120px;" title="Search Results" alt="search-results" border="0">
			</div>
		</div>
	</div>
	<div style="height: 1210px;" id="searchbackground">
		<div class="right">
<!--[if IE]>
<img src="images/pixel.gif" alt="" width="1" height="240" align="left" />
<![endif]-->

	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[0]="217003271";
		//]]>
		</script>

		
		<a name="217003271"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell11" style="cursor: pointer;" onclick="javascript:switchPost('217003271','thread.html?topicId=22012269&postId=217003271&sid=1#0')" onmouseover="javascript:hilightPost('217003271')" onmouseout="javascript:restorePost('217003271')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer11">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post1">
			<div class="postf1">
				<div class="floatRight">
					<div id="miniText217003271" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0"></div>
				<div style="visibility: hidden;" class="searchArrow" id="searchArrow217003271"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div style="background-color: transparent;" id="colorMod217003271" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('217003271','thread.html?topicId=22012269&postId=217003271&sid=1#0')">Forum login issues with web proxies</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Legorol</b> on 05/09/2006 10:55:42 UTC</span>			
				</li>
				<li class="summary"><span><i>...ed Solution. If you are not interested in the technical details, feel free to skip them.

The forum login/authentication system is not compatible with HTTP-only web proxies (those that proxy HTT...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[1]="151705016";
		//]]>
		</script>

		
		<a name="151705016"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell21" style="cursor: pointer;" onclick="javascript:switchPost('151705016','thread.html?topicId=15211899&postId=151705016&sid=1#0')" onmouseover="javascript:hilightPost('151705016')" onmouseout="javascript:restorePost('151705016')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer21">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post2">
			<div class="postf2">
				<div class="floatRight">
					<div id="miniText151705016" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-jumpto-post.gif" alt="" border="0"></div>
				<div style="visibility: visible;" class="searchArrow" id="searchArrow151705016"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div style="background-color: rgb(6, 52, 73);" id="colorMod151705016" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('151705016','thread.html?topicId=15211899&postId=151705016&sid=1#0')">Nothing happens at login in to game server</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Quanta</b> on 26/08/2006 11:11:55 UTC</span>			
				</li>
				<li class="summary"><span><i>Since
the 1.12 patch, I cannot log on to any realm in WoW. I can get to the
realm selection screen, which shows there are characters on the servers
I do have them on - but I can't actually get on t...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[2]="166201851";
		//]]>
		</script>

		
		<a name="166201851"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell11" style="cursor: pointer;" onclick="javascript:switchPost('166201851','thread.html?topicId=16661679&postId=166201851&sid=1#0')" onmouseover="javascript:hilightPost('166201851')" onmouseout="javascript:restorePost('166201851')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer11">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post1">
			<div class="postf1">
				<div class="floatRight">
					<div id="miniText166201851" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow166201851"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div style="background-color: transparent;" id="colorMod166201851" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('166201851','thread.html?topicId=16661679&postId=166201851&sid=1#0')">Disconnect on login! please help!</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Twiliteblade</b> on 28/08/2006 10:47:48 UTC</span>			
				</li>
				<li class="summary"><span><i>Pleeease
help!
since the patch on wednesday ive been unable to login to wow. I type in
my login info, the game goes thru the login process and then just says
"disconnected from server"
...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[3]="175508118";
		//]]>
		</script>

		
		<a name="175508118"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell21" style="cursor: pointer;" onclick="javascript:switchPost('175508118','thread.html?topicId=17622271&postId=175508118&sid=1#0')" onmouseover="javascript:hilightPost('175508118')" onmouseout="javascript:restorePost('175508118')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer21">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post2">
			<div class="postf2">
				<div class="floatRight">
					<div id="miniText175508118" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow175508118"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div style="background-color: transparent;" id="colorMod175508118" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('175508118','thread.html?topicId=17622271&postId=175508118&sid=1#0')">Brother cant login</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Elizeha</b> on 30/08/2006 20:42:24 UTC</span>			
				</li>
				<li class="summary"><span><i>Hey,
i cant log into my account, first i got a game freeze, after that when
i login, after 20 secs i get disconnected, and i made a new password,
and i could use it, but after 20 secs i got disconn...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[4]="556706181";
		//]]>
		</script>

		
		<a name="556706181"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell11" style="cursor: pointer;" onclick="javascript:switchPost('556706181','thread.html?topicId=55705651&postId=556706181&sid=1#0')" onmouseover="javascript:hilightPost('556706181')" onmouseout="javascript:restorePost('556706181')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer11">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post1">
			<div class="postf1">
				<div class="floatRight">
					<div id="miniText556706181" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow556706181"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod556706181" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('556706181','thread.html?topicId=55705651&postId=556706181&sid=1#0')">Can't login with 1.12.1 EU</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Arma</b> on 14/10/2006 10:11:18 UTC</span>			
				</li>
				<li class="summary"><span><i>Yesterday i came home from school and tryed to login my account , but 
guess what when i login it says to me "Unable to validate game version. This may be caused by file corruption of interfac...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[5]="664709194";
		//]]>
		</script>

		
		<a name="664709194"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell21" style="cursor: pointer;" onclick="javascript:switchPost('664709194','thread.html?topicId=66486861&postId=664709194&sid=1#0')" onmouseover="javascript:hilightPost('664709194')" onmouseout="javascript:restorePost('664709194')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer21">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post2">
			<div class="postf2">
				<div class="floatRight">
					<div id="miniText664709194" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow664709194"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod664709194" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('664709194','thread.html?topicId=66486861&postId=664709194&sid=1#0')">wow login problem </a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Gundar</b> on 20/10/2006 09:11:47 UTC</span>			
				</li>
				<li class="summary"><span><i>hi i got a problem with wow 
when i open the .exe file i get this error  failed to open archive data\model.mpq

does anyone konws a solutions for this ?
thx alot </i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[6]="760109699";
		//]]>
		</script>

		
		<a name="760109699"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell11" style="cursor: pointer;" onclick="javascript:switchPost('760109699','thread.html?topicId=76037798&postId=760109699&sid=1#0')" onmouseover="javascript:hilightPost('760109699')" onmouseout="javascript:restorePost('760109699')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer11">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post1">
			<div class="postf1">
				<div class="floatRight">
					<div id="miniText760109699" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow760109699"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod760109699" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('760109699','thread.html?topicId=76037798&postId=760109699&sid=1#0')">Cant Login to account</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Cardinus</b> on 26/10/2006 21:32:59 UTC</span>			
				</li>
				<li class="summary"><span><i>After starting the client and getting to the account login stage:

Connecting -&gt; Handshaking-&gt; .... (other steps) -&gt; Success! -&gt; Disconnected from server.

The whole thing takes about 0...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[7]="775310050";
		//]]>
		</script>

		
		<a name="775310050"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell21" style="cursor: pointer;" onclick="javascript:switchPost('775310050','thread.html?topicId=77527944&postId=775310050&sid=1#0')" onmouseover="javascript:hilightPost('775310050')" onmouseout="javascript:restorePost('775310050')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer21">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post2">
			<div class="postf2">
				<div class="floatRight">
					<div id="miniText775310050" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow775310050"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod775310050" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('775310050','thread.html?topicId=77527944&postId=775310050&sid=1#0')">Forum login problem</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Fikule</b> on 30/10/2006 11:09:01 UTC</span>			
				</li>
				<li class="summary"><span><i>I
can login from my university but not from home.
Before the new forums I could log in fine but now when i go to the
login screen and type in my username and password after pressing login
it just ...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[8]="807229532";
		//]]>
		</script>

		
		<a name="807229532"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell11" style="cursor: pointer;" onclick="javascript:switchPost('807229532','thread.html?topicId=80919729&postId=807229532&sid=1#0')" onmouseover="javascript:hilightPost('807229532')" onmouseout="javascript:restorePost('807229532')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer11">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post1">
			<div class="postf1">
				<div class="floatRight">
					<div id="miniText807229532" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow807229532"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod807229532" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('807229532','thread.html?topicId=80919729&postId=807229532&sid=1#0')">Probelms logging in. Getting DC'd at login</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Ztrider</b> on 08/11/2006 15:54:31 UTC</span>			
				</li>
				<li class="summary"><span><i>I
have problems with logging in. I had no problems logging in at all
until the servers went down at 5 o’clock this morning. When I got back
14.00 I got in at the first try, but when I logged ...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		<script type="text/javascript">
		//<![CDATA[
		postIdArray[9]="2604526068";
		//]]>
		</script>

		
		<a name="2604526068"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		

		

<div id="postshell21" style="cursor: pointer;" onclick="javascript:switchPost('2604526068','thread.html?topicId=260756075&postId=2604526068&sid=1#0')" onmouseover="javascript:hilightPost('2604526068')" onmouseout="javascript:restorePost('2604526068')">
	
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="postingcontainer21">
					<div class="insert">
<div id="resultsContainer">
	<div class="resultbox"><!-- search results container -->
		<div class="post2">
			<div class="postf2">
				<div class="floatRight">
					<div id="miniText2604526068" class="miniText"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-preview-post.gif" alt="" border="0">
					</div>
				<div class="searchArrow" id="searchArrow2604526068"></div>
				<img src="new-hp/images/forum/icons/arrow.gif" alt="" style="position: relative; top: 7px;" border="0">
				</div>
		<div id="colorMod2604526068" class="excerptPadd">
			<div class="breakWord">
			<ul>
				<li><span><a href="javascript:switchPost('2604526068','thread.html?topicId=260756075&postId=2604526068&sid=1#0')">Cannot login - Telia issues?</a></span><br>
				<span class="blue" style="font-size: 11px;">Posted By <b>Ama</b> on 14/03/2007 09:55:48 UTC</span>			
				</li>
				<li class="summary"><span><i>For
somewhere around half an hour I cannot login to game at all. After
having several weeks of lag spikes, this is just the cherry on top of
the Telia s**t pile.
Please kick some Telia a$$.
Thank y...</i></span>
				</li>
			</ul>
			</div><!-- end break -->
		</div>
	</div>
</div>

	</div><!-- end search results container -->
</div>
					</div><!-- end insert -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div><!-- End div postshell -->


		<!-- include of includes/insert-search-result.jsp finished -->

		
	


		</div>
	</div>
		</td>
		<td class="displaybox" valign="top" width="50%">
<!--[if IE]>
<div style="width: 450px;"><img src="/images/pixel.gif" /></div>
<![endif]-->
	<div style="position: relative; z-index: 999999999; width: 100%;">
		<div style="margin: 0pt auto; position: relative; width: 420px;">
			<div class="postpreview"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/title-post-preview.gif" style="position: absolute; top: 7px; left: 128px;" title="Post Preview" alt="post-preview" border="0">
			</div>
		</div>
	</div>
	<div style="height: 1210px;" id="floatingContainer">
		<div style="top: 0px;" id="floatingContainer2">

	

		

		<a name="217003271"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

<div id="floatingContainer217003271" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=22012269&amp;postId=217003271&amp;sid=1#0"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(new-hp/images/forum/portraits/wow/0-7-1.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide11">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/7-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Gnome</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Warrior</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Silvermoon&amp;n=Legorol" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Private</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=22012269&amp;postId=217003271&amp;sid=1#0">Forum login issues with web proxies</a><br>05/09/2006 10:55:42 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Legorol</span> <a href="search.html?forumId=11079&amp;characterId=214302543&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>The Scorned</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Silvermoon</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
This is a repost of the issue I have originally described on the beta
forums. It is still present and affects many players (including me) as
far as I can tell.
<br>
<br><b>Executive Summary</b>
<br>
<br>This post is about the inability to log in to the forums. The
symptoms, cause, technical details and a proposed workaround solution
are described. If you are unable to log in to the forums and your
symptoms match the description, try the suggested Solution. If you are
not interested in the technical details, feel free to skip them.
<br>
<br>The forum <span class="highlight">login</span>/authentication
system is not compatible with HTTP-only web proxies (those that proxy
HTTP traffic but not HTTPS), preventing successful <span class="highlight">login</span>.
In particular, it is not compatible with transparent proxies utilised
by many major ISPs. For example, many players who use the UK ISP called
NTL have problems logging in to the forums or are completely unable to
log in.
<br>
<br>The issue arises when a users's HTTP traffic is passed through a
proxy but his HTTPS traffic isn't, a common scenario with ISPs that use
transparent proxies. However, transparent proxies are not the only
possible cause, the issue can also arise with certain configurations of
proxy settings in the user's web-browser. (More technical details
below)
<br>
<br>The solution (described in detail below) is to configure the user's
browser to pass both HTTP and HTTPS traffic through the same proxy
server.
<br>
<br><b>Technical details</b>
<br>
<br>The <i>symptom</i> of the issue is this. You go to one of the
forums, e.g. English General. You type in your username and password
correctly in the <span class="highlight">login</span> box at the top
right, and try to log in. If this is the first time you are trying to
log in, then a page with your characters is supposed to come up, but
instead you just receive the page with no characters in the list. If
you have successfully logged in before and therefore have selected a
character, then instead you just simply get bounced back to the same
forum. No error message comes up and you are apparently not logged in.
Instead of showing your selected character in the top right corner, the
same empty log in box is displayed. No matter how many times you try,
you don't log in.
<br>
<br>The <i>cause</i> of the issue is this. The forum <span class="highlight">login</span>
system uses a mixture of URLs, some of which use HTTP, some of which
use HTTPS. The forum pages themselves use HTTP, but when you click Log
In, you are first taken through an HTTPS URL (which performs the
authentication) and then you are redirected back to the HTTP forum
page. The problem happens because of this mixing of HTTP and HTTPS
protocols.
<br>
<br>If your web traffic is proxied such that your HTTP traffic goes through a proxy, but your HTTPS traffic doesn't, then the <b>source IP address</b>
from which you are apparently making the connections to the URLs in
question are different for the two protocols. When accessing an HTTP
URL, your apparent source IP (that the forum server sees) is that of
your proxy server, but when accessing an HTTPS URL, the source IP is
that of your computer. The <span class="highlight">login</span> system
used by these forums seems to check for source IP address and therefore
if the HTTP and HTTPS traffic comes from different addresses then you
can't succesfully log in.
<br>
<br>This problem can arise in several situations. Here are the two most common scenarios I have encountered:
<br>
<br><li> ISPs that use so called "transparent" proxies. Example: NTL
(2nd largest ISP in UK). Even if the user has no proxy server specified
in their web-browser, nevertheless these ISPs forcefully pass
web-traffic through their proxy servers. Unfortunately, this is usually
done only to HTTP traffic and not to HTTPS. The result is that, unknown
to the user, their HTTP traffic goes via the ISPs proxy servers, and
therefore has a different source IP address than the user's IP address.
<br>
<br></li><li> User's whose proxy settings in their browser is
configured such as to pass HTTP traffic through a proxy server but not
HTTPS traffic. This can even happen without the user's knowledge, for
example when automatic proxy configuration settings are used. Many
institutions that provide automatic proxy settings provide them such
that only HTTP traffic is proxied. Example: several major UK
Universities.
<br>
<br><b>Solution</b>
<br>
<br>The solution in all cases involves manually setting up appropriate
proxy server settings in your web-browser. I am going to describe in
detail the necessary steps.
<br>
<br>First, you need to determine whether your web-traffic is indeed
currently going through a proxy server or not, and if so, what is its
name. If it's not, then your problem with logging in is probably caused
by something else and this post does not apply to you. To check this,
visit this page:
<br><a href="http://whatismyipaddress.com/" target="_new">http://whatismyipaddress.com/</a>
<br>If you are going through a proxy server, you will see a repot like this:
<br>
<br>Proxy Server Detected!
<br>Proxy Server IP address: W.X.Y.Z
<br>Proxy Server Details: <b>name.of.proxy.server</b>
<br>Proxy Reports IP as: A.B.C.D
<br>
<br>At this point, make a note of the name of the proxy server
(indicated in bold in the example above), as you will need it. Next you
have to configure your web-browser such that all traffic (both HTTP and
HTTPS) goes through the same proxy server. The steps for this are
different for each browser, the exact steps are explained here for
Internet Explorer 6.
<br>
<br>1) In Internet Explorer, go to Tools-&gt;Internet Options-&gt;Connections tab.
<br>2) Click "LAN Settings" button on the middle right. A new dialog box should open.
<br>3) Uncheck the "Automatically detect proxy settings" setting if it's checked.
<br>4) Under Proxy Server, check the "Use a proxy server for your LAN" setting. 
<br>5) In the Address box, type in the name of the proxy server you found above (the bold part). In the Port box, type 8080.
<br>6) Click the Advanced button. In the new dialog box, make sure the
"Use the same proxy server for all protocols" setting is checked.
<br>7) Hit OK sufficient number of times.
<br>
<br>If the above doesn't work for you, you can also try with Port
number 80 instead of 8080, which may work for some people. For other
web browsers, you need to make the equivalent settings, i.e. specify a
proxy server manually and make sure both HTTP and HTTPS traffic go
through the same one.
<br>
<br><b>Conclusion</b>
<br>
<br>This issue is a pain. I have made this post during the forum beta
test as well, as many people were unable to log in to the beta forums.
The solution suggested in this post allowed most people with this
problem to successfully log in.
<br>
<br>Unfortunately this is not 100% Blizzard's fault so we can't just
blame Blizzard for it. It's due to the interaction between the forum
software and the user's or their IPSs proxy configuration. This is not
an uncommon problem actually, I have encountered many forums, web-sites
and web services that suffer from the same problem. It arises any time
the web server checks the source IP address for security purposes.
<br></li></span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="151705016"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer151705016" style="display: block;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=15211899&amp;postId=151705016&amp;sid=1#0"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow/0-2-1.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide21">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/2-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Orc</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Warrior</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Daggerspine&amp;n=Quanta" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank3.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Sergeant</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=15211899&amp;postId=151705016&amp;sid=1#0">Nothing happens at login in to game server</a><br>26/08/2006 11:11:55 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Quanta</span> <a href="search.html?forumId=11079&amp;characterId=148401924&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>Syntax</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Daggerspine</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
Since the 1.12 patch, I cannot log on to any realm in WoW. I can get to
the realm selection screen, which shows there are characters on the
servers I do have them on - but I can't actually get on to a realm and
create/choose a character - when I try, it just pops me back to the
realm selection screen.
<br>Have tried to repair 3 times and have tried to completly shut down my firewall. And i have no router.
<br>Must have my daily wow fix... Havent played since the update...
<br>Anyone else have this problem?? </span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="166201851"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer166201851" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="a"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow-default/0-4-4.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>41</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide11">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/4-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Night Elf</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/4.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rogue</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Ragnaros&amp;n=Twiliteblade" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank3.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Sergeant</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=16661679&amp;postId=166201851&amp;sid=1#0">Disconnect on login! please help!</a><br>28/08/2006 10:47:48 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Twiliteblade</span> <a href="search.html?forumId=11079&amp;characterId=151403080&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Ragnaros</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							Pleeease help!
<br>
<br>since the patch on wednesday ive been unable to <span class="highlight">login</span> to wow. I type in my <span class="highlight">login</span> info, the game goes thru the <span class="highlight">login</span> process and then just says "disconnected from server"
<br>
<br>Ive been through all the forums and FAQs and done everything suggested,
<br>
<br>reinstalled the game several times
<br>run virus scans and disk defragments
<br>I have opened all nessasary ports on my firewall
<br>updated all of my drivers
<br>I also configured a static IP adress but I was unable to connect to the internet afterward so i had to change it back
<br>
<br>Pleeeease help as Im now at a loss as to what i should do! I
Emailed tech support, and they just suggested checking the FAQs, so
that was no help.
<br>
<br>Its day six without WOW and im starting to get slightly annoyed lol</span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="175508118"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer175508118" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=17622271&amp;postId=175508118&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow-default/1-1-8.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>25</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide21">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/1-1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Human</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/8.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Mage</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Arathor&amp;n=Elizeha" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
						
						
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank_default_0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"></div>
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=17622271&amp;postId=175508118&amp;sid=1#0">Brother cant login</a><br>30/08/2006 20:42:24 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Elizeha</span> <a href="search.html?forumId=11079&amp;characterId=174403558&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>Dutchflyer</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Arathor</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							Hey, i cant log into my account, first i got a game freeze, after that when i <span class="highlight">login</span>,
after 20 secs i get disconnected, and i made a new password, and i
could use it, but after 20 secs i got disconnected again, and now my
new and old password dont work. and i tried to retrieve it, but when i
must awnser my secret question and email it says ''error'''and goes
back to the account name part again.
<br>
<br>if anyone can help pls post or some1 from blizz tell this to the WoW staff cause i am out of ideas.
<br>acount support says he cant send the message with my prob, it
always gives a error and i filled everything even the things with no *
<br>
<br>( this typed my brother he cant <span class="highlight">login</span> or send a message on acount support, he just gets errors)</span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="556706181"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer556706181" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=55705651&amp;postId=556706181&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow-default/0-1-1.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>49</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide11">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/1-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Human</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Warrior</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Stonemaul&amp;n=Arma" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank2.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Corporal</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=55705651&amp;postId=556706181&amp;sid=1#0">Can't login with 1.12.1 EU</a><br>14/10/2006 10:11:18 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Arma</span> <a href="search.html?forumId=11079&amp;characterId=228102327&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>IndoriL</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Stonemaul</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							Yesterday i came home from school and tryed to <span class="highlight">login</span> my account , but 
<br>guess what when i <span class="highlight">login</span> it says to me <b>"Unable to validate game version. This may be caused by file corruption of interface of another program"</b>
<br>
<br>So i reinstaled whole Windows ( i needed it long time ago :) ) and instaled my WOW patched wersion to 1.12.1 and tryed <span class="highlight">login</span> again and whoala it says again <b>"Unable to validate game version. This may be caused by file corruption of interface of another program"</b>
<br>
<br><u>There is some kind of new patch at wow-eu ?</u></span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="664709194"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer664709194" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=66486861&amp;postId=664709194&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow/0-3-4.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide21">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/3-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Dwarf</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/4.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rogue</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Kul+Tiras&amp;n=Gundar" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank8.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Knight-Captain</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=66486861&amp;postId=664709194&amp;sid=1#0">wow login problem </a><br>20/10/2006 09:11:47 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Gundar</span> <a href="search.html?forumId=11079&amp;characterId=664606962&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>Drunk Dragons</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Kul Tiras</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							hi i got a problem with wow 
<br>when i open the .exe file i get this error  failed to open archive data\model.mpq
<br>
<br>does anyone konws a solutions for this ?
<br>thx alot </span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="760109699"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer760109699" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=76037798&amp;postId=760109699&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow/0-1-5.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide11">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/1-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Human</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/5.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Priest</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Moonglade&amp;n=Cardinus" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank5.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Sergeant Major</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=76037798&amp;postId=760109699&amp;sid=1#0">Cant Login to account</a><br>26/10/2006 21:32:59 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Cardinus</span> <a href="search.html?forumId=11079&amp;characterId=455904663&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>Primigenia</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Moonglade</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							After starting the client and getting to the account <span class="highlight">login</span> stage:
<br>
<br>Connecting -&gt; Handshaking-&gt; .... (other steps) -&gt; Success! -&gt; Disconnected from server.
<br>
<br>The whole thing takes about 0.5 seconds.</span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="775310050"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer775310050" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=77527944&amp;postId=775310050&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow/0-5-9.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide21">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/5-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Undead</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/9.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Warlock</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Arathor&amp;n=Fikule" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank6.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Stone Guard</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=77527944&amp;postId=775310050&amp;sid=1#0">Forum login problem</a><br>30/10/2006 11:09:01 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Fikule</span> <a href="search.html?forumId=11079&amp;characterId=151503990&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>WoW Wolf Clan</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Arathor</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							I can <span class="highlight">login</span> from my university but not from home.
<br>
<br>Before the new forums I could log in fine but now when i go to the <span class="highlight">login</span> screen and type in my username and password after pressing <span class="highlight">login</span> it just brings the <span class="highlight">login</span> screen back up again with no error message or anything.
<br>
<br>=(</span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="807229532"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer807229532" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=80919729&amp;postId=807229532&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow/0-8-4.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>60</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide11">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/8-0.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Troll</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/4.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rogue</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Kazzak&amp;n=Ztrider" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
																					
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank6.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rank: Stone Guard</b><br><i>Lifetime Highest PvP Rank</i>','#ffffff')" ;="" onmouseout="hideddrivetip()"></div>
						
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=80919729&amp;postId=807229532&amp;sid=1#0">Probelms logging in. Getting DC'd at login</a><br>08/11/2006 15:54:31 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Ztrider</span> <a href="search.html?forumId=11079&amp;characterId=129002239&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
									
					<small>Guild:&nbsp;</small>
					<small><b>Furieux</b></small>			
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Kazzak</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
I have problems with logging in. I had no problems logging in at all
until the servers went down at 5 o’clock this morning. When I got back
14.00 I got in at the first try, but when I logged out 2 minuts later
and tried to log in again, I just get DC’d in the loggin screen. Every
time I try to log in, I get DC’d now. <br>Does anyone know what this can be?
<br></span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	


	

		

		<a name="2604526068"></a>

		<!-- Main Post Body -->

		<!-- //including includes/insert-search-result.jsp -->

		
		
		
		





<div id="floatingContainer2604526068" style="display: none;">
	<div class="resultbox">
		<div class="postdisplay">
			<div class="border">
				<div class="innercontainer">
					<div class="secondcontainer">
			<div class="breakWord">
<div style="float: right;"><div style="position: relative;"><a href="thread.html?topicId=260756075&amp;postId=2604526068&amp;sid=1#0"><img src="new-hp/images/forum/button-jumptopost.gif" title="Jump To This Post" style="position: absolute; top: 2px; right: 4px;" alt="jumptopost" border="0"></a></div></div>
					<ul>
						<li class="postavatar">
				<div id="avatar" style="width: 85px;">
					<div class="shell">
<table border="0" cellpadding="0" cellspacing="0">
	<tbody><tr>
		<td style="background: transparent url(/images/portraits/wow-default/1-10-4.gif) repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" height="64" width="64">
		</td>
	</tr>
</tbody></table>
			<div class="frame">
				<img src="new-hp/images/forum/pixel.gif" alt="" border="0" height="83" width="82">
			</div>
		</div>
		<div style="position: relative;">
			<div class="iconPosition" style="right: 4px;">
			
				
				<b><small>3</small></b>
			
			</div>
		
<!-- //Begin Character ID Panel// -->		
			
				<div id="iconpanelhide21">
					<div id="search-iconpanel"></div>
						<div id="search-icon-panel">
						<div class="player-icons-race" style="background: transparent url(/images/icon/race/10-1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Blood Elf</b>','#ffffff')" ;="" onmouseout="hideddrivetip()">
						<img src="new-hp/images/forum/pixel.gif" alt="" height="18" width="18">
						</div>						
						<div class="player-icons-class" style="background: transparent url(/images/icon/class/4.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;" onmouseover="ddrivetip('<b>Rogue</b><br><i>Click to View Talent Build</i>','#ffffff')" ;="" onmouseout="hideddrivetip()">						
						
						<a href="character-talents.xml?r=Auchindoun&amp;n=Ama" target="_blank"><img src="new-hp/images/forum/icon-active.png" alt="" class="png" border="0" height="18" width="18"></a>
						</div>						
							
						
						
						<div class="player-icons-pvprank" style="background: transparent url(/images/icon/pvpranks/rank_default_1.gif) no-repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"></div>
						
						
						</div>
					</div>
			
<!-- //End Avatar Panel// -->
		</div>		
	</div>				
	
						</li>
						<li class="userdata"><span> <a href="thread.html?topicId=260756075&amp;postId=2604526068&amp;sid=1#0">Cannot login - Telia issues?</a><br>14/03/2007 09:55:48 UTC</span><br>
						<span><b>by <span style="color: rgb(255, 172, 4);">Ama</span> <a href="search.html?forumId=11079&amp;characterId=2606026062&amp;sid=1"><img src="new-hp/images/forum/search.gif" style="vertical-align: middle;" onmouseover="ddrivetip('View All Posts by This User','#ffffff')" onmouseout="hideddrivetip()" alt="search" border="0" height="21" width="17"></a></b><br>
				
			<br>
				
					<small>Realm:&nbsp;</small>
					<small><b>Auchindoun</b></small>
				
						</span></li>
						</ul>
						<ul>
						<li class="summary">	
							<div id="messagepanel">
								<div class="message-body">
							<img src="new-hp/images/forum/search-text-bubble.gif" alt="" style="position: absolute; top: -15px; left: 120px;" border="0">
									<div class="message-format"><span>
							
							For somewhere around half an hour I cannot <span class="highlight">login</span> to game at all. After having several weeks of lag spikes, this is just the cherry on top of the Telia s**t pile.
<br>Please kick some Telia a$$.
<br>Thank you.
<br>
<br>
<br>Tracing route to eu.logon.worldofwarcraft.com [80.239.180.117]
<br>over a maximum of 30 hops:
<br>
<br>  1    &lt;1 ms  4294967292 ms  4294967292 ms  10.0.0.1 
<br>
<br>  2    &lt;1 ms  4294967295 ms    &lt;1 ms  195.12.37.193 
<br>
<br>  3     3 ms  4294967295 ms  4294967295 ms  core.dcom.net.ua [195.12.36.1] 
<br>
<br>  4    &lt;1 ms    &lt;1 ms  4294967295 ms  world.dcom.net.ua [195.12.36.5] 
<br>
<br>  5    18 ms    14 ms    14 ms  linxtel-1GE-out-144dot1q.dcomcorp.net [195.12.37.238] 
<br>
<br>  6    47 ms    47 ms    44 ms  sl-gw11-fra-4-2.sprintlink.net [217.151.254.229] 
<br>
<br>  7    53 ms    45 ms    45 ms  sl-bb21-fra-5-0.sprintlink.net [217.147.96.70] 
<br>
<br>  8    59 ms    54 ms    60 ms  sl-bb20-par-14-0.sprintlink.net [213.206.129.65] 
<br>
<br>  9    59 ms    59 ms    54 ms  sl-telia1-5-0.sprintlink.net [217.118.225.234] 
<br>
<br> 10    63 ms    54 ms    55 ms  prs-nant-ks50-link.telia.net [80.91.249.54] 
<br>
<br> 11     *        *        *     Request timed out.
<br>
<br> 12     *        *        *     Request timed out.
<br>
<br> 13     *        *        *     Request timed out.
<br>
<br> 14     *        *        *     Request timed out.
<br>
<br> 15     *        *        *     Request timed out.
<br>
<br> 16     *        *        *     Request timed out.
<br>
<br> 17     *        *        *     Request timed out.
<br>
<br>etc etc etc
<br>
<br>
<br>- Your town and Country:
<br>Kiev, Ukraine
<br>- The hour and date when you experience the problems the most:
<br>All the time?
<br>- When did this problem start:
<br>A few weeks ago my overall latency raised from 80-100 to 180-300. And now I cannot <span class="highlight">login</span> at all
<br>- Realm played:
<br>Jaedenar
<br>- Internet Service Provider:
<br>Tica
<br>- How fast is your internet connection? :
<br>2MB 
<br>- Modem model:
<br>None
<br>- Firewall Software (if used):
<br>Windows Firewall with exceptions for WoW on, havent touched it in years, was working fine
<br>- Router model (if used):
<br>None
<br>- Network card model (if used):
<br>some ASUS  M2N32-SLI Nvidia  built-in ethernet adapter
<br>- Do you share your connection?
<br>No
<br>- Connection used, (USB, Ethernet or Wifi):
<br>Ethernet 
<br>- Could you please try to create characters on Agamaggan, Ragnaros
and Silvermoon to see if the latency persists on these realms? <br>I cannot, as I cant <span class="highlight">login</span> now
<br>- Your characters location on the realm (which zone you are in):
<br>...
<br>- Name of the instance (in the case that you are in an instance):
<br>...
<br>- When did you first experience this high latency? : 
<br>A few weeks ago my overall latency raised from 80-100 to 180-300. And now I cannot <span class="highlight">login</span> at all
<br>- What exactly happens? (Make sure to describe this as well as you can): 
<br>As of now I cannot <span class="highlight">login</span> at all, with the game being stalled at "Authenticating" screen
<br>
<br></span></div>
								</div>
							</div>
						</li>
					</ul>
			</div><!-- end break -->
					</div><!-- end secondcontainer -->
				</div><!-- end innercontainer -->
			</div><!-- end border -->
		</div><!-- end postdisplay -->
	</div><!-- end resultbox -->
</div>	

		<!-- include of includes/insert-search-result.jsp finished -->

		
	



		</div>
	</div>
		</td>
	</tr>
</tbody></table>
</div>
<!-- // end search results -->



<div id="paging">
	<div class="rpage">
	<span>
	
	<table border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td>
<img src="new-hp/images/forum/arrow-left.gif" border="0"></td><td><small><a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=1" class="current">1</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=2">2</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=3">3</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=4">4</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=5">5</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=6">6</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=7">7</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=8">8</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=9">9</a>&nbsp;.&nbsp;<a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=10">10</a></small></td><td><a href="search.html?sid=1&amp;forumId=11079&amp;characterName=&amp;characterId=0&amp;searchText=login&amp;accountId=0&amp;stationId=1&amp;recentPosts=0&amp;blizzardPoster=false&amp;pageNo=2"><img src="new-hp/images/forum/arrow-right.gif" border="0"></a></td></tr></tbody></table>
	</span>
	</div>
</div>

 <!-- have search results -->
 <!-- search submitted -->

<div class="tbottom"></div>

<div style="width: 100%; height: 41px; min-width: 775px;">
	<div style="float: right;">
	<a href="board.html?forumId=11079&amp;sid=1"><img src="new-hp/images/<? echo $_LANG['LANG']['SHORT_TAG']; ?>/forum/forum-index.gif" border="0" height="41" width="104"></a>
	</div>
</div>
<br clear="all">
