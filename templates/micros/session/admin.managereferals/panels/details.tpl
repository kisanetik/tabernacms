{strip}
<form id="detailsForm_{$uid}">
<input type="hidden" name="datefrom" value="{$datefrom}" />
<input type="hidden" name="dateto" value="{$dateto}" />
<input type="hidden" name="uid" value="{$uid}" />
<table border="0" width=100%>
    <tr>
        <td>
            <div class="inn_components_out" style="padding:0px;height:100%;">
                <div class="inn_components">
                    <div id="TabsPanel" class="vkladki" style="position:static; margin:0 2px; height:31px;">
                        <div id="staticTab{$uid}" class="vkladka activ" onClick="RADTabs.change('staticTab{$uid}');">
                            <div>
                                <div>
                                    <div>
                                        {lang code="refstat.session.title"}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="paymentsTab{$uid}" class="vkladka" onClick="RADTabs.change('paymentsTab{$uid}');" style="display:none;">
                            <div>
                                <div>
                                    <div>
                                        {lang code="refpayments.session.title"}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="userTab{$uid}" class="vkladka" onClick="RADTabs.change('userTab{$uid}');" style="display:none;">
                            <div>
                                <div>
                                    <div>
                                        {lang code="refuser.session.title"}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="ordersTab{$uid}" class="vkladka" onClick="RADTabs.change('ordersTab{$uid}');" style="display:none;">
                            <div>
                                <div>
                                    <div>
                                        {lang code="reforders.session.title"}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="und_vkladki" style="padding-top:3px;">
                        <img style="height:100%;" />
                        <div id="TabsWrapper" class="wrap">
                            <div id="staticTab{$uid}_tabcenter" class="lf_col tabcenter" style="width:100%;">
                                staticCenter panel!
                            </div>
                            <div id="paymentsTab{$uid}_tabcenter" class="lf_col tabcenter" style="display:none;">
                                paymentsTab panel!
                            </div>
                            <div id="userTab{$uid}_tabcenter" class="lf_col tabcenter" style="display:none;">
                                paymentsTab panel!
                            </div>
                            <div id="ordersTab{$uid}_tabcenter" class="lf_col tabcenter" style="display:none;">
                                paymentsTab panel!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
</form>
{/strip}