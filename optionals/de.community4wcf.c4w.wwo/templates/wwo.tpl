{if $usersWasOnline|isset && INDEX_ENABLE_WASONLINE_LIST}
	<div class="container-2">
		<div class="containerIcon" id="wwoIconContainer"> <a href="javascript:wwolist_togglesort();"><img src="icon/wasOnlineSortM.png" alt="" id="wwoIcon" /></a></div>
		<div class="containerContent">
			<h3>{if !INDEX_WASONLINE_LIST_SHOWPERMANENT}<a href="javascript:wwolist_togglehide();">{/if}{lang}c4w.index.usersWasOnline{/lang}{if !INDEX_WASONLINE_LIST_SHOWPERMANENT}</a>{/if}</h3>
			<div id="wwoStats">
				<p class="smallFont">{lang}c4w.index.usersWasOnline.detail{/lang} {lang}c4w.index.usersWasOnline.record{/lang}</p>
				{if $usersWasOnline|count}
					{if INDEX_LIMIT_WASONLINE_LIST && INDEX_LIMIT_WASONLINE_LIST_AMOUNT > 0}<p class="smallFont">{lang}c4w.index.usersWasOnline.limitedlist{/lang}</p>{/if}
					<p class="smallFont" id="wwoNames">{implode from=$usersWasOnline item=userWasOnline}<a href="index.php?page=User&amp;userID={@$userWasOnline.userID}{@SID_ARG_2ND}">{@$userWasOnline.username}</a>{if !INDEX_WASONLINE_LIST_HIDETIME}&nbsp;({@$userWasOnline.lastActivityTime|time:"%H:%M"}){/if}{/implode}</p>
				{/if}
			</div>
		</div>
		<script type="text/javascript">
		//<![CDATA[
		{if !INDEX_WASONLINE_LIST_SHOWPERMANENT}
		var wwolist_hidden = false;
		function wwolist_togglehide () {
			if (wwolist_hidden) {
				document.getElementById("wwoIcon").style.visibility = "visible";
				document.getElementById("wwoStats").className = "";
				wwolist_hidden = false;
			}
			else {
				document.getElementById("wwoIcon").style.visibility = "hidden";
				document.getElementById("wwoStats").className = "hidden";
				wwolist_hidden = true;
			}
		}
		wwolist_togglehide();
		{/if}
		var wwolist_sortbyname = false;
		var wwolist_byname = '{implode from=$usersWasOnlineByName item=userWasOnline}<a href="index.php?page=User&amp;userID={@$userWasOnline.userID}{@SID_ARG_2ND}">{@$userWasOnline.username|addcslashes:"'\\"}</a>{if !INDEX_WASONLINE_LIST_HIDETIME}&nbsp;({@$userWasOnline.lastActivityTime|time:"%H:%M"}){/if}{/implode}';
		var wwolist_bytime = '{implode from=$usersWasOnline item=userWasOnline}<a href="index.php?page=User&amp;userID={@$userWasOnline.userID}{@SID_ARG_2ND}">{@$userWasOnline.username|addcslashes:"'\\"}</a>{if !INDEX_WASONLINE_LIST_HIDETIME}&nbsp;({@$userWasOnline.lastActivityTime|time:"%H:%M"}){/if}{/implode}';
		function wwolist_togglesort () {
			if (wwolist_sortbyname) {
				document.getElementById("wwoNames").innerHTML = wwolist_bytime;
				document.getElementById("wwoIcon").title = "{lang}c4w.index.usersWasOnline.sortByName{/lang}";
				wwolist_sortbyname = false;
			}
			else {
				document.getElementById("wwoNames").innerHTML = wwolist_byname;
				document.getElementById("wwoIcon").title = "{lang}c4w.index.usersWasOnline.sortByTime{/lang}";
				wwolist_sortbyname = true;
			}
		}
		document.getElementById("wwoIcon").title = "{lang}c4w.index.usersWasOnline.sortByName{/lang}";
		//]]>
		</script>
	</div>
{/if}