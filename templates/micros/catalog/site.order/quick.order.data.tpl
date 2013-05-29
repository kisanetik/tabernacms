{strip}
{if $showcaptha}
{url type="js" file="jscss/components/radcaptcha.js"}
{/if}
    <div class="reg_form">
	   <p class="formfeedback" >{lang code="qoyourdata.basket.title" ucf=true}</p>
	   <p class="formfeedback nm" >{lang code="markedfields.catalog.text" ucf=true}</p>
	</div>
		<form id="user_data_form" method="post" action="{url href="alias=order.html"}">
			<input type="hidden" name="action" value="order" />
			<input type="hidden" name="hash" value="{$hash}" />
			{if !empty($delivery)}
			<input type="hidden" name="delivery" id="hid_delivery" value="0" />
			{/if}
			<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#eff5fa" class="tabreg">
				<tr>
					<td align="right" width="25%" nowrap="nowrap">
						<span id="span_fio">{lang code='fio.basket.text' ucf=true}</span>&nbsp;<span style="color: red;">*</span>
					</td>
					<td align="left" width="75%">
						<div class="element">
							<input class="user" type="text" maxlength="100" name="fio" id="fio" value="{if isset($userInfo->u_fio)}{$userInfo->u_fio}{/if}" x-webkit-speech="" speech="" onwebkitspeechchange="return void(0);" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap">
						<span id="span_contact_phone">{lang code='contact_phone.basket.text' ucf=true}</span>&nbsp;<span style="color: red;">*</span>
					</td>
					<td align="left" width="100%">
						<div class="element">
							<input class="user" type="text" name="contact_phone" id="contact_phone" value="{if isset($userInfo->u_phone)}{$userInfo->u_phone}{/if}" maxlength="64" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap">
						<span id="span_email">{lang code='email.basket.text' ucf=true}&nbsp;<span style="color: red;">*</span></span>
					</td>
					<td align="left" width="100%">
						<div class="element">
							<input class="user" type="text" maxlength="100" name="email" id="email" value="{if isset($userInfo->u_email)}{$userInfo->u_email}{/if}" />
						</div>
					</td>
				</tr>
                <tr>
                    <td align="right" nowrap="nowrap">
                        <span id="span_address">{lang code='address.basket.text' ucf=true}</span>
                    </td>
                    <td align="left" width="100%">
                    	<div class="element">
                        	<input class="user"  type="text" maxlength="256" name="address" id="address" value="{if isset($userInfo->u_address)}{$userInfo->u_address}{/if}" x-webkit-speech="" speech="" onwebkitspeechchange="return void(0);" />
                        </div>
                    </td>
                </tr>

				<tr>
					<td align="right" nowrap="nowrap">
						{lang code="order_comments.basket.text" ucf=true}
					</td>
					<td align="left" width="100%">
						<div class="element">
							<textarea class="user lng" name="order_comment" id="order_comment"  rows="4"></textarea>
						</div>
					</td>
				</tr>

			</table>
				<div class="reg_form_bottom">
					{if $showcaptha}
						<p class="input_symbols" id="enter_capcha">
							{lang code="entercapcha.session.text" ucf=true}&nbsp;<span style="color: red;">*</span>
						</p>
						<div class="capcha_pic">
						<input type="text" id="captcha_text"  maxlength="8" name="captcha_text" class="user smll" style="width: 150px; margin: 4px;" >
							{if isset($wrong_capcha) and $wrong_capcha}<span class="required">{lang code="wrongcapcha.session.error" ucf=true}</span><br />{/if}
							<a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)">
	                            <img id="captcha_img"  src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" alt="{lang code="entercaptcha.session.text" ucf=true}" />
	                        </a><br />
	                        <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)" class="captcha_link_refresh_text">{lang code="dontseechars.system.link" ucf=true}</a><br />
						</div>
                    <input type="button" name="send_order" class="btnorge  treb wt order feedbackbt" value="{lang code='doorder.catalog.text'}" onclick="if(RADOrderForm.validate()) $('#user_data_form').submit();" />
                    {else}
                    	<p class="input_symbols" id="enter_capcha">&nbsp;</p>
                    	<input type="button" name="send_order" class="btnorge  treb wt order feedbackbt" style="margin-right:240px;" value="{lang code="doorder.catalog.text" ucf=true}" onclick="if(RADOrderForm.validate()) $('#user_data_form').submit();" />
                    {/if}
                </div>
		</form>

{/strip}
