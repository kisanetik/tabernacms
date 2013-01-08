{strip}
{if isset($header)}{$header}{/if}
<body>
  <div id="global_div">
    <table id="main">
        <tr>
            <td class="main">
                <div id="main_inn">
                    <table class="main_tbl">
                    {if isset($top)}
                        <tr>
                            <td class="header">
                                {$top}
                            </td>
                        </tr>
                    {/if}
                        <tr>
                            <td class="center" id="center_wrap_parent">
                                {if isset($center)}
                                <div class="wrap" id="center_wrap">
                                    <div class="right_col" id="center_right_col">
                                        {$center}
                                    </div>
                                </div>
                                {/if}
                                {if isset($left)}
                                <div class="left_col" id="left_menu_wrapper">
                                    {$left}
                                </div>
                                {/if}
								<div class="clear"></div>
								<div class="clear_footer"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
  </div>
  <div class="footer">
    {if isset($bottom)}
        {$bottom}
    {/if}
  </div>
</body>
{if isset($footer)}{$footer}{/if}
{/strip}