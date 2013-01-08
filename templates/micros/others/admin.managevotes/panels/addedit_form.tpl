{strip}
<script type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs_addedit"}"></script>
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/fckeditor/fckeditor.js"></script>

<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code='managevotes.others.title' ucf=true}</h1>
<form enctype="multipart/form-data" id="addedit_form" method="post" onsubmit="return false;">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
{if $action eq 'additem'}
<input type="hidden" id="action_sub" name="action_sub" value="add" />
{else}
<input type="hidden" name="action_sub" id="action_sub" value="edit" />
<input type="hidden" name="vt_treid" value="{$cat_id}" id="cat_id" />
<input type="hidden" name="vt_id" id="vt_id" value="{$item->vt_id}" />
{/if}

<div style="margin: 20px 0px 0px 0px;">
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
                            <div class="block_header_title">{if $action eq 'additem'}{lang code='addvote.others.title' ucf=true}{else}{lang code='editvote.others.title' ucf=true}{/if}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="addeditItemMessage"></span></div>
                        </td>
                    </tr>
                    </table>

                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADAddEditVotes.cancelClick();">
                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-cancel' ucf=true}" title="{lang code='-cancel' ucf=true}" />
                                <span class="text">{lang code='-cancel' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if $action ne 'additem'}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADAddEditVotes.deleteClick();">
                                <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-delete' ucf=true}" title="{lang code='-delete' ucf=true}" />
                                <span class="text">{lang code='-delete' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {/if}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADAddEditVotes.applyClick();">
                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply' ucf=true}" title="{lang code='-apply' ucf=true}" />
                                <span class="text">{lang code='-apply' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADAddEditVotes.saveClick();">
                                <img src="{const SITE_URL}img/backend/disk.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-save' ucf=true}" title="{lang code='-save' ucf=true}" />
                                <span class="text">{lang code='-save' ucf=true}</span>
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
                                <td class="left_column">{lang code='votesquestion.others.text'}:</td>
                                <td><input type="text" class="long_text" name="vt_question" id="vt_question" value="{$item->vt_question|replace:'"':'&quot;'}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='position.others.text' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="vt_position" id="vt_position" value="{$item->vt_position}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='category.others.text' ucf=true}:</td>
                                <td>
                                    <select name="vt_treid" id="vt_treid">
                                        <option value="{$ROOT_PID}">{lang code='rootnode.others.text'}</option>
                                        {if $action ne 'additem'}
                                            {assign var=selected value=$item->vt_treid}
                                        {else}
                                            {assign var=selected value=$cat_id}
                                        {/if}
                                        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/tree_recursy.tpl" elements=$categories selected=$selected nbsp=3}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='itemactive.others.text'}:</td>
                                <td><input type="checkbox" name="vt_active" id="vt_active"{if $item->vt_active} checked="checked"{/if} /></td>
                            </tr>
                            </table>
                    </td>
                    <td width="99%">
                        <table class="tbl_w100_inn" style="margin-left:10px;">
                            <tr>
                                <td width="25%" align="left">

                                </td>
                                <td width="75%">
                                    <div class="kord_con_in_td">
                                        {if $action ne 'additem'}
                                        <!-- gray circle block -->
                                        <div class="gr_cir_bl margin_bot_none">
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <div>
                                                                    <div>
                                                                        <div class="main_cont">
                                                                            <div class="name_info">{lang code='-infoblock'}</div>
                                                                            <div>{lang code='votesadded.others.text'}: {$item->vt_datecreated}</div>
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / gray circle block -->
                                        {/if}
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <div class="inn_components_out">
            <div class="inn_components">
                <!-- vkladki -->
                <div class="vkladki" id="TabsPanel">
                    {*if $params->hasfulldesc or $params->hasshortdesc*}
                    <!-- vkladka -->
                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
                        <div>
                            <div>
                                <div>{lang code='answers.others.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <!-- / vkladka -->
                    {*/if*}
                    {*
                    <!-- vkladka -->
                    <div class="vkladka " id="imagesTab" onclick="RADTabs.change('imagesTab');">
                        <div>
                            <div>
                                <div>{lang code='images.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <!-- / vkladka -->
                    *}
                    <!-- vkladka -->
                    <div class="vkladka " id="metatagsTab" onclick="RADTabs.change('metatagsTab');">
                        <div>
                            <div>
                                <div>{lang code='-metatags' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <!-- / vkladka -->

                    <div class="clear"></div>
                </div>
                <!-- / vkladki -->
                <!-- under vkladki -->
                <div class="und_vkladki">
                    <div class="wrap" id="TabsWrapper">
{****  ANSWERS    *****}
                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter" style="margin:0px;">
                            <div class="kord_lf_col">
                            {if $action eq 'additem'}
                               {lang code='forstsavethevote.others.text' ucf=true}
                            {else}


                              <table id="answerslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
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
                                                          <div class="block_header_title">{lang code='voteslist.resource.title' ucf=true}</div>
                                                      </td>
                                                      <td>
                                                          <div class="block_header_title" style="text-align: right;"><span class="red_color" id="VotesListMessage"></span></div>
                                                      </td>
                                                  </tr>
                                                  </table>
                                                  <div class="tb_line_ico">
                                                       <table class="item_ico">
                                                  <tr>
                                                      <td>
                                                      <a href="javascript:RADVotesQuestions.refresh();">
                                                          <img src="{const SITE_URL}img/backend/arrow_rotate_clockwise.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply' ucf=true}" title="{lang code='-apply' ucf=true}" />
                                                          <span class="text">{lang code='-refresh' ucf=true}</span>
                                                      </a>
                                                      </td>
                                                  </tr>
                                                  </table>
                                                  <table class="item_ico">
                                                  <tr>
                                                      <td>
                                                      <a href="javascript:RADAddEditVotes.applyClick();">
                                                          <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply' ucf=true}" title="{lang code='-apply' ucf=true}" />
                                                          <span class="text">{lang code='-apply' ucf=true}</span>
                                                      </a>
                                                      </td>
                                                  </tr>
                                                  </table>
                                                  <table class="item_ico">
                                                  <tr>
                                                      <td>
                                                      <a href="javascript:RADVotesQuestions.saveAnswerDialog();">
                                                          <img src="{const SITE_URL}img/backend/add.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply' ucf=true}" title="{lang code='-apply' ucf=true}" />
                                                          <span class="text">{lang code='-add' ucf=true}</span>
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
                                      <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                                      <td align="left" id="questions_list">
                                                    {***  ANSWERS LIST HERE ****}
                                                    <script type="text/javascript">{literal}window.onload = function(){RADVotesQuestions.refresh();}{/literal}</script>
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
                    {/if}
                            </div>
                        </div>
{****  END ANSWERS    *****}
                        <div class="lf_col tabcenter" id="metatagsTab_tabcenter" style="display:none;margin:0px;">
                            <div class="kord_lf_col">
                                <!-- group box -->
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='-metatags'}</span>
                                    <div class="kord_cont">
                                        <div>
                                            <table cellpadding="0" cellspacing="3" border="0">
                                                <tr>
                                                    <td width="10%" nowrap="nowrap">
                                                        {lang code='-metakeywords'}
                                                    </td>
                                                    <td width="90%" align="left">
                                                        <input type="text" name="vt_metakeywords" id="vt_metakeywords" value="{$item->vt_metakeywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="vt_metatitle" id="vt_metatitle" value="{$item->vt_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="vt_metadescription" id="vt_metadescription" value="{$item->vt_metadescription}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- / group box -->
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- / under vkladki -->
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
    {* ############# // TREE BLOCK ################# *}
</div>
</form>
    </div>
</div>
{/strip}