{include file='header'}
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/Suggestion.class.js"></script>
<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/TabMenu.class.js"></script>
<script type="text/javascript">
	//<![CDATA[
	var tabMenu = new TabMenu();
	onloadEvents.push(function() { tabMenu.showSubTabMenu('{if $minorUpdates|count > 0 || $majorUpdates|count > 0}updates{elseif $news|count > 0}news{else}system{/if}') });
	//]]>
</script>

<div class="mainHeadline">
	<img src="{@RELATIVE_WCF_DIR}icon/acpL.png" alt="" />
	<div class="headlineContainer">
		<h2>{lang}c4w.acp.index{/lang}</h2>
	</div>
</div>

{if $this->user->getPermission('admin.user.canEditUser')}
	<form method="post" action="index.php?form=UserSearch">
		<fieldset>
			<legend>{lang}c4w.acp.index.searchUsers{/lang}</legend>
			
			<div class="formElement">
				<div class="formFieldLabel">
					<label for="username">{lang}wcf.user.username{/lang}</label>
				</div>
				<div class="formField">
					<input type="text" class="inputText" id="username" name="staticParameters[username]" value="" />
					<script type="text/javascript">
						//<![CDATA[
						suggestion.enableMultiple(false);
						suggestion.init('username');
						//]]>
					</script>
					<label><input type="checkbox" name="matchExactly[username]" value="1" /> {lang}wcf.global.search.matchesExactly{/lang}</label>
				</div>
			</div>
			
			{if $this->user->getPermission('admin.user.canMailUser')}
				<div class="formElement">
					<div class="formFieldLabel">
						<label for="email">{lang}wcf.user.email{/lang}</label>
					</div>
					<div class="formField">	
						<input type="text" class="inputText" id="email" name="staticParameters[email]" value="" />
						<label><input type="checkbox" name="matchExactly[email]" value="1" /> {lang}wcf.global.search.matchesExactly{/lang}</label>
					</div>
				</div>
			{/if}
			
			{if $additionalSearchFields|isset}{@$additionalSearchFields}{/if}
		</fieldset>
		<div class="formSubmit">
			<input type="submit" accesskey="s" value="{lang}wcf.global.button.submit{/lang}" />
			<input type="reset" accesskey="r" value="{lang}wcf.global.button.reset{/lang}" />
			<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
	 		{@SID_INPUT_TAG}
		</div>
	</form>
{/if}

{if $additionalFields|isset}{@$additionalFields}{/if}

<div class="tabMenu">
	<ul>
		{if $minorUpdates|count > 0 || $majorUpdates|count > 0}<li id="updates"><a onclick="tabMenu.showSubTabMenu('updates');"><span>{lang}c4w.acp.index.updates{/lang}</span></a></li>{/if}
		{if $news|count > 0}<li id="news"><a onclick="tabMenu.showSubTabMenu('news');"><span>{lang}c4w.acp.index.news{/lang}</span></a></li>{/if}
		<li id="system"><a onclick="tabMenu.showSubTabMenu('system');"><span>{lang}c4w.acp.index.system{/lang}</span></a></li>
		<li id="stat"><a onclick="tabMenu.showSubTabMenu('stat');"><span>{lang}c4w.acp.index.stat{/lang}</span></a></li>
		<li id="credits"><a onclick="tabMenu.showSubTabMenu('credits');"><span>{lang}c4w.acp.index.credits{/lang}</span></a></li>
		{if $additionalTabs|isset}{@$additionalTabs}{/if}
	</ul>
</div>
<div class="subTabMenu">
	<div class="containerHead"><div> </div></div>
</div>

{if $minorUpdates|count > 0 || $majorUpdates|count > 0}
	<div class="border tabMenuContent hidden" id="updates-content">
		<div class="container-1">
			{if $minorUpdates|count > 0}
				<h3 class="subHeadline">{lang}c4w.acp.index.minorUpdates{/lang}</h3>
				
				<form method="post" action="index.php?form=PackageUpdate">
					<p class="description">{lang}c4w.acp.index.minorUpdates.description{/lang}</p>
					
					<ul>
						{foreach from=$minorUpdates item=update}
							<li{if $update.version.updateType == 'security'} class="formError"{/if}>
								{lang}c4w.acp.index.updates.update{/lang}
								<input type="hidden" name="updates[{@$update.packageID}]" value="{$update.version.packageVersion}" />
							</li>
						{/foreach}
					</ul>
					
					<p><input type="submit" value="{lang}c4w.acp.index.updates.startUpdate{/lang}" /></p>
					<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
					{@SID_INPUT_TAG}
				</form>
			{/if}
			{if $majorUpdates|count > 0}
				<h3 class="subHeadline">{lang}c4w.acp.index.majorUpdates{/lang}</h3>
				
				<form method="post" action="index.php?form=PackageUpdate">
					<p class="description">{lang}c4w.acp.index.majorUpdates.description{/lang}</p>
					
					<ul>
						{foreach from=$majorUpdates item=update}
							<li{if $update.version.updateType == 'security'} class="formError"{/if}>
								{lang}c4w.acp.index.updates.update{/lang}
								<input type="hidden" name="updates[{@$update.packageID}]" value="{$update.version.packageVersion}" />
							</li>
						{/foreach}
					</ul>
					
					<p><input type="submit" value="{lang}c4w.acp.index.updates.startUpdate{/lang}" /></p>
					<input type="hidden" name="packageID" value="{@PACKAGE_ID}" />
					{@SID_INPUT_TAG}
				</form>
			{/if}
		</div>
	</div>
{/if}

{if $news|count > 0}
	<div class="border tabMenuContent hidden" id="news-content">
		<div class="container-1">
			<h3 class="subHeadline">{lang}c4w.acp.index.news{/lang}</h3>
			
			{foreach from=$news item=newsItem}
				{*<div>
					<p class="smallFont">{if $newsItem.author}{$newsItem.author} | {/if}{@$newsItem.pubDate|time}</p>
					<h4><a href="{@RELATIVE_WCF_DIR}acp/dereferrer.php?url={$newsItem.link|rawurlencode}" class="externalURL">{@$newsItem.title}</a></h4>
					
					{@$newsItem.description}
				</div>*}
				<div class="message content">
					<div class="messageInner container-{cycle name='results' values='1,2'}">
						<p class="light smallFont">{if $newsItem.author}{$newsItem.author} - {/if}{@$newsItem.pubDate|time}</p>
						<h4><a href="{@RELATIVE_WCF_DIR}acp/dereferrer.php?url={$newsItem.link|rawurlencode}" class="externalURL">{@$newsItem.title}</a></h4>

						<div class="messageBody">
							{@$newsItem.description}
						</div>
						<hr />
					</div>
				</div>
			{/foreach}
		</div>
	</div>
{/if}

<div class="border tabMenuContent hidden" id="system-content">
	<div class="container-1">
		<h3 class="subHeadline">{lang}c4w.acp.index.system{/lang}</h3>
		
		<fieldset>
			<legend>{lang}c4w.acp.index.system.software{/lang}</legend>
		
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.c4w.version{/lang}</p>
				<p class="formField">{PACKAGE_VERSION}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.installationDate{/lang}</p>
				<p class="formField">{@INSTALL_DATE|time}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.wcf.version{/lang}</p>
				<p class="formField">{WCF_VERSION}</p>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>{lang}c4w.acp.index.system.server{/lang}</legend>
		
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.os{/lang}</p>
				<p class="formField">{$os}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.webserver{/lang}</p>
				<p class="formField">{$webserver}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.php{/lang}</p>
				<p class="formField">{PHP_VERSION}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.sql.type{/lang}</p>
				<p class="formField">{$sqlType} &quot;{$dbName}&quot;</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.sql.version{/lang}</p>
				<p class="formField">{$sqlVersion}</p>
			</div>
			<div class="formElement">
				<p class="formFieldLabel">{lang}c4w.acp.index.system.cache{/lang}</p>
				<p class="formField">{$cacheSource}</p>
			</div>
			{if $load}
				<div class="formElement">
					<p class="formFieldLabel">{lang}c4w.acp.index.system.load{/lang}</p>
					<p class="formField">{$load}</p>
				</div>
			{/if}
		</fieldset>
	</div>
</div>

<div class="border tabMenuContent hidden" id="stat-content">
	<div class="container-1">
		<h3 class="subHeadline">{lang}c4w.acp.index.stat{/lang}</h3>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.stat.members{/lang}</p>
			<p class="formField">{#$members}</p>
		</div>
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.stat.usersOnline{/lang}</p>
			<p class="formField">{#$usersOnline}</p>
		</div>
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.stat.database.entries{/lang}</p>
			<p class="formField">{#$databaseEntries}</p>
		</div>
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.stat.database.size{/lang}</p>
			<p class="formField">{@$databaseSize|filesize}</p>
		</div>
	</div>
</div>

<div class="border tabMenuContent hidden" id="credits-content">
	<div class="container-1">
		<h3 class="subHeadline">{lang}c4w.acp.index.credits{/lang}</h3>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.developedBy{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.developedBy.description{/lang}</p>
		</div>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.productManager{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.productManager.description{/lang}</p>
		</div>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.developer{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.developer.description{/lang}</p>
		</div>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.designer{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.designer.description{/lang}</p>
		</div>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.icons{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.icons.description{/lang}</p>
		</div>
		
		<div class="formElement">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.other{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.other.description{/lang}</p>
		</div>
		
		<div class="formElement" style="margin-top: 10px">
			<p class="formFieldLabel">{lang}c4w.acp.index.credits.copyright{/lang}</p>
			<p class="formField">{lang}c4w.acp.index.credits.copyright.description{/lang}</p>
		</div>
	</div>
</div>

{if $additionalTabContents|isset}{@$additionalTabContents}{/if}

{include file='footer'}
