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
        <img src="{@RELATIVE_WCF_DIR}icon/groupL.png" alt="" />
          <div class="headlineContainer">
            <h2>{lang}wcf.wio.title{/lang}</h2>
            <p>{lang}{PAGE_TITLE}{/lang}</p>
          </div>
      </div>

      {if $userMessages|isset}{@$userMessages}{/if}
      
{if $this->user->getPermission('user.wio.canSeeWio')}
      <div class="WhoIsOnline">
            {cycle values='container-1,container-2' print=false advance=false}
                {if $users|count == 0}
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
                {else}
                  <div class="border">
                       <div class="containerHead"><h3>{lang}wcf.wio.members{/lang}</h3></div>
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
    {/if}
	{if WIO_BRANDINGFREE != 1}<div style="text-align: center;">{lang}wcf.wio.poweredBy{/lang}</p>{/if}
</div>
{if WIO_OPEN_POPUP != 1}
{include file='footer' sandbox=false}
{/if}
</body>
</html>