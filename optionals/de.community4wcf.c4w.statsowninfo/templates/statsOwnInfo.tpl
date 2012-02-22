				<div class="{cycle values='container-1,container-2'}">
					<div class="containerIcon">
						<img src="{icon}{INDEX_STATSOWNINFO_ICON}M.png{/icon}" alt="" />
					</div>
					<div class="containerContent">
						{if INDEX_STATSOWNINFO_LINK_ENABLE}
						<h3><a href="{INDEX_STATSOWNINFO_LINK}">{lang}{INDEX_STATSOWNINFO_TITLE}{/lang}</a></h3>
						{else}
						<h3>{lang}{INDEX_STATSOWNINFO_TITLE}{/lang}</h3>
						{/if}
						<p class="smallFont">{lang}{@$message}{/lang}</p>
					</div>
				</div>