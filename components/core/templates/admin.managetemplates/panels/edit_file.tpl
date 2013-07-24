{strip}
{if !empty($fcontent)}
    <form id="edit_file_form">
        <input type="hidden" name="f" value="" id="edif_file_hid" />
        <input type="hidden" name="hash" value="{$hash|default:''}" id="hash" />
        <textarea style="width:99%;font-size:10pt;" rows="26" id="w_code" name="w_code">{$fcontent}</textarea><br />
        <div align="center" id="bitton_w">
          <input type="button" value="{lang code='-save' ucf=true htmlchars=true}" onclick="RADFolders.saveWindowClick();" />
          &nbsp;
          <input type="button" value="{lang code='-cancel' ucf=true htmlchars=true}" onclick="RADFolders.cancelWindowClick();" />
        </div>
    </form>
{else}
    Content not found! some error!
{/if}
{/strip}