<div class="container-1">
	<div class="containerIcon"> <img src="{icon}membersM.png{/icon}" alt="" /></div>
	<div class="containerContent">
		<h3>{if $this->user->getPermission('user.usersOnline.canView')}<a href="index.php?page=UsersOnline{@SID_ARG_2ND}">{lang}c4w.index.usersOnline{/lang}</a>{else}{lang}c4w.index.usersOnline{/lang}{/if}</h3> 
		<p class="smallFont">{lang}c4w.index.usersOnline.detail{/lang} {lang}c4w.index.usersOnline.record{/lang}</p>
		{if $usersOnline|count}
			<p class="smallFont">{implode from=$usersOnline item=userOnline}<a href="index.php?page=User&amp;userID={@$userOnline.userID}{@SID_ARG_2ND}">{@$userOnline.username}</a>{/implode}</p>
			{if INDEX_ENABLE_USERS_ONLINE_LEGEND && $usersOnlineMarkings|count}
				<p class="smallFont">
					{lang}wcf.usersOnline.marking.legend{/lang} {implode from=$usersOnlineMarkings item=usersOnlineMarking}{@$usersOnlineMarking}{/implode}
				</p>
			{/if}
		{/if}
	</div>
</div>