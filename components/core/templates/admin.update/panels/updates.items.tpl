{strip}
{if !empty($response)}
<script type="text/javascript">
    RADUpdate.updateList = {$response|@json_encode};
</script>
    {$response->message}
    <br />
    <a href="#" onclick="return RADUpdate.installVersion();">
        <img src="{url type="image" module="core" preset="original" file="backend/icons/install.png"}" border="0" alt="{lang code="installupdates.system.text"|replace:'"':'&quot;'}" />
        <br />
        {lang code="installupdate.system.link" ucf=true}
    </div>
    <br />
    <a href="{lang code='-detail' ucf=true}" id="a_detail_update">{lang code='-detail' ucf=true}</a>
    <div style="width:100%;" id="detail_updates">
        {if !empty($response->files)}
            <div class="update_files">
                <h4>{lang code="filestoupdate.system.text" ucf=true}:</h4>
                <ul>
                {foreach from=$response->files item="file" key="filepath"}
                    {foreach from=$file item="entry"}
                        <li>{$entry|replace:'@':$smarty.const.DS}</li>
                    {/foreach}
                {/foreach}
                </ul>
            </div>
        {/if}
        {if !empty($response->sql)}
            <div class="update_sql">
                <h4>{lang code="execsql.system.text" ucf=true}:</h4>
                <ul>
                {foreach from=$response->sql item="sql"}
                    <li>
                        {if !empty($sql->inserted_id)}
                            inserted id assign to "@{$sql->inserted_id}@"; <br />
                        {/if}
                        SQL={$sql->sql|replace:'@RAD@':$smarty.const.RAD}
                    </li>
                {/foreach}
                </ul>
            </div>
        {/if}
        {if !empty($response->php)}
            <div class="update_php">
                <h4>{lang code="execphp.system.text" ucf=true}:</h4>
                <textarea id="update_php_source" style="width:100%;" rows="7" disabled="true">{$response->php}</textarea>
            </div>
        {/if}
    </div>
{else}
    <h4>{lang code="noupdates.system.text" ucf=true}</h4>
{/if}
{/strip}