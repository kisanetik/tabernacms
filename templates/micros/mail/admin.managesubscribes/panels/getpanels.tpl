{strip}
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/fckeditor/fckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs"}"></script>
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code="subscibes.mail.title" ucf=true}</h1>
        <form enctype="multipart/form-data" id="subscribe_form" method="post">
        	<input type="hidden" name="action" value="send"/>
        	<input type="hidden" name="hash" value="{$hash}"/>
        	<input type="hidden" id="mailformat" name="mailformat" value="0"/>
			<table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height: auto; width: 99%;">
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
			                            <div class="block_header_title">{lang code='managesubscribe.mail.title' ucf=true}</div>
			                        </td>
			                    </tr>
			                    </table>
								<span id="infoMessage" class="red_color">{if isset($message)}{$message}{/if}</span>
			                    <div class="tb_line_ico">
			                        {*
			                        <table class="item_ico">
			                        <tr>
			                            <td>
			                            <a href="javascript:RADMailSubscribes.cancelClick();">
			                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-cancel"}" title="{lang code="-cancel"}" />
			                                <span class="text">{lang code="-cancel" ucf=true}</span>
			                            </a>
			                            </td>
			                        </tr>
			                        </table>
			                        *}
			                        <table class="item_ico">
			                        <tr>
			                            <td>
			                            <a href="javascript:RADMailSubscribes.applyClick();">
			                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-submit"}" title="{lang code="-submit"}" />
			                                <span class="text">{lang code="-submit" ucf=true}</span>
			                            </a>
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
			        <td class="left_border"></td>
			        <td>
			            <table class="tbl_w100">
			                <tr>
			                    <td nowrap="nowrap">
			                            <table cellpadding="0" cellspacing="0" border="0" class="tb_add">
										<tr>
			                                <td class="left_column">{lang code='fromname.mail.title' ucf=true}:</td>
			                                <td><input type="text" class="long_text" name="mailfromname" id="mailfromname" value="" style="width:430px" /></td>
			                            </tr>
			                            <tr>
			                                <td class="left_column">{lang code='fromemail.mail.title' ucf=true}:</td>
			                                <td><input type="text" class="long_text" name="mailfromemail" id="mailfromemail" value="" style="width:430px" /></td>
			                            </tr>
			                            <tr>
			                                <td class="left_column">{lang code='subject.mail.title' ucf=true}:</td>
			                                <td><input type="text" class="long_text" name="mailsubject" id="mailsubject" value="" style="width:430px" /></td>
			                            </tr>
			                            <tr>
			                                <td class="left_column">{lang code='smtp.mail.title' ucf=true}:</td>
			                                <td><input type="checkbox" name="mailsmtp" id="mailsmtp" onclick="RADMailSubscribes.smtpCheck();"/></td>
			                            </tr>
			                            </table>
			                            <div id="smtpconfig" style="display:none;">
											<table cellpadding="0" cellspacing="0" border="0" class="tb_add">
				                            <tr>
				                                <td class="left_column">{lang code='smtphost.mail.title' ucf=true}:</td>
				                                <td><input type="text" class="long_text" name="smtphost" id="smtphost" value="" style="width:230px" /></td>
				                            </tr>
				                            <tr>
				                                <td class="left_column">{lang code='smtpport.mail.title' ucf=true}:</td>
				                                <td><input type="text" class="long_text" name="smtpport" id="smtpport" value="25" style="width:230px" /></td>
				                            </tr>
				                            <tr>
				                                <td class="left_column">{lang code='smtpsecurity.mail.title' ucf=true}:</td>
				                                <td>
				                                	<select id="smtpsecurity" name="smtpsecurity">
				                                		<option value="none" selected>NONE</option>
				                                		<option value="ssl">SSL</option>
				                                		<option value="tls">TLS</option>
				                                	</select>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td class="left_column">{lang code='smtpuser.mail.title' ucf=true}:</td>
				                                <td><input type="text" class="long_text" name="smtpuser" id="smtpuser" value="" style="width:230px" /></td>
				                            </tr>
				                            <tr>
				                                <td class="left_column">{lang code='smtppass.mail.title' ucf=true}:</td>
				                                <td><input type="text" class="long_text" name="smtppass" id="smtppass" value="" style="width:230px" /></td>
				                            </tr>
				                            </table>
			                            </div>
			                    </td>
			                    <td width="45%">
			                        <table class="tbl_w100_inn" style="margin-left:10px;">
			                            <tr>
			                                <td width="100%">
			                                    <div class="kord_con_in_td">
			                                        <div class="gr_cir_bl margin_bot_none">
			                                            <div>
			                                                <div>
			                                                    <div>
			                                                        <div>
			                                                            <div>
			                                                                <div>
			                                                                    <div>
			                                                                        <div class="main_cont">
			                                                                            <div class="name_info">{lang code='groups.mail.title' ucf=true}:</div>
			                                                                            <div>
			                                                                            <select id="groups_tree" name="mailgroups[]" multiple="multiple" style="width:100%">
			                                                                            {if count($users_groups)}
			                                                                            	{foreach from=$users_groups item=ug}
			                                                                            		<option value="{$ug->tre_id}">{$ug->tre_name}</option>
			                                                                            	{/foreach}
			                                                                            {/if}
			                                                                            </select>
			                                                                            </div>
			                                                                        </div>
			                                                                    </div>
			                                                                </div>
			                                                            </div>
			                                                        </div>
			                                                    </div>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
			                                </td>
			                            </tr>
			                        </table>
			
			                    </td>
			                </tr>
			            </table>
		
		            <div class="inn_components_out">
		            <div class="inn_components">
		                <div class="vkladki" id="TabsPanel">
		                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
		                        <div>
		                            <div>
		                                <div>{lang code='body.mail.title' ucf=true}</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="clear"></div>
		                </div>
		                <div class="und_vkladki">
		                    <div class="wrap" id="TabsWrapper">
		                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter" style="width:100%">
		                            <div class="kord_lf_col">
		                                <div class="group_box margin_bottom" >
		                                    <span class="tit">{lang code='body.mail.title' ucf=true}</span>
		                                    <div class="kord_cont" style="height:250px;">
		                                        <textarea id="FCKeditorMailBody" name="FCKeditorMailBody" style="width:100%;height:100%;"></textarea>
		                                        <script language="JavaScript" type="text/javascript">
		                                        	addWEditor('FCKeditorMailBody');
		                                        </script>                                  
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="clear"></div>
		                </div>
		            </div>
		            </div>
		
			        </td>
			        <td class="right_border"></td>
			    </tr>
			    <tr>
			        <td class="corner_lb"></td>
			        <td class="tb_bottom"></td>
			        <td class="corner_rb"></td>
			    </tr>
			</table>
	</form>
    </div>
</div>
{/strip}