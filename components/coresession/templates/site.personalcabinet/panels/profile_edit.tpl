{strip}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
<script type="text/javascript">
$('#profile').addClass('act');
$('#profile').removeAttr('href');
</script>
<style>
    .errormsg {
        color:#f00;
        margin-left:15px;
        display:none;
    }
</style>
<h2>{lang code='editprofile.session.title' ucf=true}</h2>
{if !empty($userInfo)}
    {if isset($form_saved)}
    <div class="reg_form" style="margin-top:10px;font-weight:normal;text-align:center;padding-top:20px;">
        {if isset($activation_required)}{lang code="activation_code_sent.session.message" find="@email@" replace=$activation_required ucf=true}
        {else}{lang code="-saved" ucf=true}
        {/if}
    </div>
    {/if}
<br/>
<center>
    <h3>{lang code="markedfieldsrequired.others.text" ucf=true}</h3>
</center>

<form id="editprofile_form" action="" method="post">
    <table cellpadding="0" cellspacing="0" border="0" width="400">
       {if isset($message)}
        <tr>
            <td colspan="2" align="center"><span style="color:red;">{$message}</span></td>
        </tr>
       {/if}
        <tr>
            <td align="right" nowrap="nowrap" width="30%">
               {lang code="nickname.session.text"}&nbsp;<span style="color:red;">*</span>
            </td>
            <td align="left">
               <input id="u_login" class="user" name="u_login" type="text" value="{$userInfo->u_login|default:''|escape}"/>
               <br/>
               <span class="errormsg" id="u_login_error"></span>
           </td>
        </tr>
        <tr>
            <td align="right" nowrap="nowrap" width="35%">
               {lang code="email.session.text"}&nbsp;<span style="color:red;">*</span>
            </td>
            <td align="left">
                <input id="u_email" class="user" name="u_email" type="text" value="{$userInfo->u_email|default:''|escape}"/>
                <br/>
                <span class="errormsg" id="u_email_error"></span>
            </td>
        </tr>
        <tr>
            <td align="right" nowrap="nowrap" width="35%">
               {lang code="fio.session.text"}
            </td>
            <td align="left"><input id="u_fio" class="user" name="u_fio" type="text" value="{$userInfo->u_fio|default:''|escape}"/></td>
        </tr>
        <tr>
            <td align="right" nowrap="nowrap" width="35%">
               {lang code="phone.session.text"}
            </td>
            <td align="left"><input id="u_phone" class="user" name="u_phone" type="text" value="{$userInfo->u_phone|default:''|escape}"/></td>
        </tr>
        <tr>
            <td align="right" nowrap="nowrap" width="35%">
               {lang code="address.session.text"}
            </td>
            <td align="left"><input id="u_address" class="user" name="u_address" type="text" value="{$userInfo->u_address|default:''|escape}"/></td>
        </tr>
        {if !empty($userInfo->u_pass) and empty($userInfo->u_facebook_id)}
        <tr>
            <td align="right" nowrap="nowrap" width="35%"></td>
            <td align="left">
               <br />&nbsp;&nbsp;&nbsp;
               <input id="changepass" name="changepass" type="checkbox"/>
               <label for="changepass">&nbsp;{lang code="changepass.session.text" ucf=true}</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table id="tab_pass" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="right" nowrap="nowrap" width="35%">{lang code="currentpassword.session.text"}&nbsp;<span style="color:red;">*</span></td>
                    <td align="left">
                        <input id="u_pass" class="user" name="u_pass" type="password" value=""/>
                        <br/>
                        <span class="errormsg" id="u_pass_error"></span>
                    </td>
                </tr>
                <tr>
                    <td align="right" nowrap="nowrap" width="35%">{lang code="newpassword.session.text"}&nbsp;<span style="color:red;">*</span></td>
                    <td align="left">
                        <input id="u_pass1" class="user" name="u_pass1" type="password" value=""/>
                        <br/>
                        <span class="errormsg" id="u_pass1_error"></span>
                    </td>
                </tr>
                <tr>
                    <td align="right" nowrap="nowrap" width="35%">{lang code="confirmpassword.session.text"}&nbsp;<span style="color:red;">*</span></td>
                    <td align="left">
                        <input id="u_pass2" class="user" name="u_pass2" type="password" value=""/>
                        <br/>
                        <span class="errormsg" id="u_pass2_error"></span>                        
                    </td>
                </tr>
                </table>
            </td>
        </tr>
        {/if}
        <tr>
           <td></td>
           <td align="left">
               <input type="hidden" name="hash" value="{$hash|default:''}"/>
               <input type="hidden" name="u_id" value="{$userInfo->u_id|default:''}"/>
               <input type="hidden" name="sub_action" value="edit"/>
               <input type="button" class="btnblue tx wt enter" onclick="javascript:rad_profile.editClick();" value="{lang code="-edit" ucf=true}"/>
           </td>
        </tr>
    </table>
</form>
{/if}
{/strip}