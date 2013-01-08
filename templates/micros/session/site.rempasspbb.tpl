{strip}
{if isset($code_sent)}
    <center>{lang code="codesent.session.title" ucf=true}</center>
{elseif isset($pass_sent)}
    <center>{lang code="passsent.session.title" ucf=true}</center>
    <br />
    <center>
        <a href="{url href="alias=login.html"}">{lang code="gologin.session.title" ucf=true}</a>
    </center>
{else}
<center>{lang code="enteremail.session.title" ucf=true}:</center>
<center>
    <form action="{url href='alias=rempass.html&a=checkandsend'}" method="post">
        <table cellpadding="0" cellspacing="0" border="0" width="400">
           {if !empty($message)}
            <tr>
                <td colspan="2" align="center">
                    <span style="color:red;">{$message}</span>
                </td>
            </tr>
           {/if}
            <tr>
                <td align="right" nowrap="nowrap" width="30%">
                   {lang code="email.session.text" ucf=true}:
                </td>
                <td align="left">
                    <input class="user" name="u_email" type="text" value=""/>
                </td>  
            </tr>
            <tr>
                <td></td>
                <td align="left">
                    <input type="hidden" name="hash" value="{$hash}"/>
                    <input type="submit" class="btnblue tx wt enter" value="{lang code ='send.session.title' ucf=true}"/>
                </td>
           </tr>
        </table>
    </form>
</center>
{/if}
{/strip}