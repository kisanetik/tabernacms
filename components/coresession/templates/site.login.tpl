{if empty($user->u_id)}
<h2>{lang code="enteremailpass.session.title" ucf=true}:</h2>
<center>
    <form action="{url href='alias=login.html&fromsite=true'}" method="post">
        <table cellpadding="0" cellspacing="0" border="0" width="400">
           {if !empty($message_error)}
            <tr>
                <td colspan="2" align="center"><span style="color:red;">{$message_error}</span></td>
            </tr>
           {/if}
            <tr>
                <td align="right" nowrap="nowrap" width="30%">
                   {lang code="email.session.text" ucf=true}:
                </td>
                <td align="left"><input class="user" name="login" type="text" value=""/></td>
            </tr>
            <tr>
                <td align="right" nowrap="nowrap" width="30%">
                   {lang code="password.session.text" ucf=true}:
                </td>
                <td align="left"><input class="user" name="pass" type="password" value=""/></td>
            </tr>
            <tr>
                <td align="right" nowrap="nowrap" width="30%"></td>
                <td align="left">&nbsp;&nbsp;&nbsp;<a href="{url href="alias=rempass.html"}">{lang code ="recoverpassword.sesion.title" ucf=true}</a></td>  
            </tr>
        {if !empty($params->is_facebook) or !empty($params->is_twitter)}
            <tr>
                <td></td>
                <td align="left">
                    <div style="padding-top:15px;">
                    {if $params->is_facebook}
                        <a href="javascript:RADSocials.socLogin('facebook');" style="text-decoration: none;"><img src="{url module="core" file="des/socials/FaceBook_24x24.png" type="image" preset="original"}" border="0" align="middle"/> <span style="font-size:13px;">Facebook</span></a>
                        <br/>
                    {/if}
                    {if $params->is_twitter}
                        <a href="javascript:RADSocials.socLogin('twitter');" style="text-decoration: none;"><img src="{url module="core" file="des/socials/Twitter_24x24.png" type="image" preset="original"}" border="0" align="middle"/> <span style="font-size:13px;">Twitter</span></a>
                    {/if}
                    </div>
                </td>
           </tr>
        {/if}
            <tr>
                <td></td>
                <td align="left">
                    <input type="hidden" name="hash" value="{$hash}"/>
                    <input type="submit" class="btnblue tx wt enter" value="{lang code ='enter.session.title' ucf=true}"/>
                </td>
           </tr>
        </table>
    </form>
</center>
{/if}