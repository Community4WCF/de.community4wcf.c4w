	{include file="documentHeader"}
	<head>
		<title>{lang}wcf.wio.title{/lang} - {lang}{PAGE_TITLE}{/lang}</title>
		{include file='headInclude' sandbox=false}
		{if WIO_REFRESH > 0}
			<meta http-equiv="refresh" content="{@WIO_REFRESH}; url=index.php?page=Wio{@SID_ARG_2ND}" />
		{/if}
	</head>
	
	<body>
	{if WIO_OPEN_POPUP}
		<div id="page">
	{else}
		{include file='header' sandbox=false}
	{/if}
	
	<div id="main">
		<div class="mainHeadline">
			<img src="{icon}groupL.png{/icon}" alt="" />
			<div class="headlineContainer">
				<h2>{lang}wcf.wio.title{/lang}</h2>
				<p>{lang}{PAGE_TITLE}{/lang}</p>
			</div>
		</div>
		
		{if !WIO_OPEN_POPUP}
			{if $userMessages|isset}{@$userMessages}{/if}
		{/if}	
      
	
		<div class="WhoIsOnline">
			{cycle values='container-1,container-2' print=false advance=false}
			{if !$users && !$guestCount}
				<div class="border containerHead">
					<p class="normalFont">{lang}wcf.wio.nobodyOnlineHeader{/lang}</p>
				</div>
				
				<div class="border container-1">
				<table class="tableList">
					<thead>
						<tr>
							<th class="container-2">
								<div>
									<p class="smallFont"><strong>{lang}wcf.wio.nobodyOnline{/lang}</strong></p>
								</div>
							</th>
						</tr>
					</thead>
				</table>
			{elseif !$users && $guestCount}
				<div class="border containerHead">
					<p class="normalFont">{$guestCount} {if $guestCount == 1}{lang}wcf.wio.guest{/lang}{else}{lang}wcf.wio.guests{/lang}{/if} {lang}wcf.wio.online{/lang}</p>
				</div>
				
				<div class="border container-1">
				<table class="tableList">
					<thead>
						<tr>
							<th class="container-2">
								<div>
									<p class="smallFont"><strong>{lang}wcf.wio.noRegisteredOnline{/lang}</strong></p>
								</div>
							</th>
						</tr>
					</thead>
				</table>
			{else}
				<div class="border">
					<div class="containerHead">
						<h3>{if $guestCount}{$guestCount} {if $guestCount == 1}{lang}wcf.wio.guest{/lang}{else}{lang}wcf.wio.guests{/lang}{/if}{/if}{if $guestCount && $users|count} {lang}wcf.wio.and{/lang} {/if}{if $guestCount && !$users|count} {lang}wcf.wio.online{/lang}{/if}{if $users|count}{$users|count} {if $users|count == 1}{lang}wcf.wio.member{/lang}{else}{lang}wcf.wio.members{/lang}{/if}{/if}</h3>
					</div>
				</div>
				
				<div class="border borderMarginRemove">
				
					<table class="tableList">
						<thead>
						
							<tr class="tableHead">
								<th class="columnUsername container-1">
									<div>
										<p class="smallFont">{lang}wcf.wio.username{/lang}</p>
									</div>
								</th>
								
								{if $canViewIpAddress}
									<th class="columnIP container-1">
										<div>
											<p class="smallFont">{lang}wcf.wio.ipAddress{/lang}</p>
										</div>
									</th>
									<th class="columnUserAgent container-1">
										<div>
											<p class="smallFont">{lang}wcf.wio.userAgent{/lang}</p>
										</div>
									</th>
								{/if}
								
								<th class="columnLastActivity container-1">
									<div>
										<p class="smallFont">{lang}wcf.wio.lastActivity{/lang}</p>
									</div>
								</th>
						
							</tr>
						</thead>
						
						<tbody>
							{foreach from=$users item=user}
								<tr class="{cycle}">
									<td class="columnUsername" style="width: 20%"><p><a href="index.php?page=User&amp;userID={@$user.userID}{@SID_ARG_2ND}">{@$user.username}</a></p></td>
									{if $canViewIpAddress}
									<td class="columnIP"><p>{$user.ipAddress}</p></td>
									<td class="columnUserAgent" style="width: 30%"><p>{$user.userAgent}</p></td>
									{/if}
									<td class="columnLastActivity"><p>{@$user.lastActivityTime|shorttime}</p></td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			{/if}
		</div>

	</div>
	
	{include file='footer' sandbox=false}
	
	</body>
</html>