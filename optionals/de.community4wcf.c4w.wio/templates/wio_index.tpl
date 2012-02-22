<div class="container-2" style="min-height: 22px; padding:6px">
                
	<div class="containerIcon">
		<img src="{icon}groupM.png{/icon}" alt="" />
	</div>
	                     
	<div class="containerContent">
	                     
	{if WIO_OPEN_POPUP}
		<h3><a href="javascript:;" onclick="window.open('index.php?page=Wio{@SID_ARG_2ND}','WhoIsOnline','width=800,height=450,toolbar=no,scrollbars=yes,left=50,top=50,resizable=yes');return false;"> {lang}wcf.wio.title{/lang}</a></h3>
	{else}
		<h3><a href="index.php?page=wio{@SID_ARG_2ND}">{lang}wcf.wio.title{/lang}</a></h3>
	{/if}
	                     
	{if $users || $guestCount}
		<div>
			<p class="smallFont">{if $guestCount}{$guestCount} {if $guestCount == 1}{lang}wcf.wio.guest{/lang}{else}{lang}wcf.wio.guests{/lang}{/if}{/if}{if $guestCount && $users|count} {lang}wcf.wio.and{/lang} {/if}{if $guestCount && !$users|count} {lang}wcf.wio.online{/lang}{/if}{if $users|count}{$users|count} {if $users|count == 1}{lang}wcf.wio.member{/lang}{else}{lang}wcf.wio.members{/lang}{/if}{/if}</p>
			{if $users}
				<p class="smallFont">{implode from=$users item=user}<a href="index.php?page=User&amp;userID={@$user.userID}{@SID_ARG_2ND}">{@$user.username}</a>{/implode}</p>
			{/if}
		</div>
	{else}
		<div>
			<p class="smallFont">{lang}wcf.wio.nobodyOnline{/lang}</p>
		</div>
	{/if}
			
	</div>
</div>