{strip}
<script type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs"}"></script>
<link rel="stylesheet" type="text/css" href="{const SITE_URL}jscss/components/datepicker/datepicker.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{const SITE_URL}jscss/components/datepicker/datepicker_vista.css" media="screen" />
<script type="text/javascript" src="{const SITE_URL}jscss/components/datepicker/datepicker.js"></script>
<h1 id="manageReferalsTitle">{lang code='manareferals.session.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" id="reflist_block" class="tb_cont_block" style="height:auto;width:100%;">
    <tr>
        <td class="corner_lt"></td>
        <td class="header_top"></td>
        <td class="corner_rt"></td>
    </tr>
    <tr>
        <td class="left_border"></td>
        <td class="header_bootom">
            <div class="hb">
                <div class="hb_inner">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <div class="block_header_title">{lang code='reflist.session.title' ucf=true}</div>
                            </td>
                            <td>
                                <div class="block_header_title" style="text-align: right;">
                                    <span class="red_color" id="RefListMessage"></span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table class="item_ico">
                        <tr>
                            <td>
                                <a href="javascript:rad_referals.refresh();">
                                    <img src="{const SITE_URL}img/backend/arrow_rotate_clockwise.png" alt="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0">
                                    <span class="text" style="width:50px;">
                                        {lang code='-refresh' ucf=true}
                                    </span>
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div class="tb_line_ico">
                        <table class="item_ico" align="left" align="left;" style="float:left;margin-top:10px;">
                           <tr>
                               <td height="100%" valign="bottom" nowrap="nowrap">
                                    <form method="post" id="searchRefForm" action="{url href="action=search"}" onsubmit="return false;">
                                        <div style="float:left;">
                                            <div style="float:left;">
                                                {lang code='-search.title' ucf=true}
                                                <br />
                                                <input type="text" name="searchword" id="searchword" value="{lang code="-search.title" ucf=true}" />
                                            </div>
                                            <div style="float:left;margin-top:14px;">
                                                <a>
                                                    <input type="image" src="{const SITE_URL}img/backend/zoom.png" alt="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-submit' ucf=true|replace:'"':'&quot;'}"  onclick="rad_referals.filter();" />
                                                </a>
                                            </div>
                                        </div>
                                        <div style="float:left;">
                                            <div style="float:left;">
                                                {lang code='date.system.title' ucf=true}&nbsp;{lang code="costsfrom.catalog.label"}
                                                <br />
                                                <input type="text" class="demo_vista" name="date_from" id="date_from" value="{$date_from|date:'datecal'}" style="width:100px" />
                                            </div>
                                        </div>
                                        <div style="float:left;">
                                            <div style="float:left;">
                                                {lang code='date.system.title' ucf=true}&nbsp;{lang code="coststo.catalog.text"}
                                                <br />
                                                <input type="text" class="demo_vista" name="date_to" id="date_to" value="{$date_to|date:'datecal'}" style="width:100px" />
                                            </div>
                                        </div>
                                    </form>
                               </td>
                           </tr>
                        </table>
                        <div class="clear_rt"></div>
                    </div>
                </div>
            </div>
        </td>
        <td class="right_border"></td>
    </tr>
    <tr>
        <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
        <td align="left" id="panel_reflist">

        </td>
        <td class="right_border" style="width:3px;" nowrap="nowrap"></td>
    </tr>
     <tr>
        <td class="left_border"></td>
        <td class="gray_line">

        </td>
        <td class="right_border"></td>
    </tr>
    <tr>
        <td class="corner_lb"></td>
        <td class="tb_bottom"></td>
        <td class="corner_rb"></td>
    </tr>
</table>
{/strip}