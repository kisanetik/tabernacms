var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';
var TREE_PID = '{$PID}';
{*var SYSXML_URL = '{url href="alias=SYSXML"}';*}

var LOAD_TYPES_URL = '{url href="action=getProductTypes"}';
var GET_REMOTE_IMG = '{url href="action=getRemoteImg"}';
var GET_CATEGORIES_URL =  '{url href="action=getcats"}';
var GET_TYPES_URL =  '{url href="action=gettypesed"}';
var SITE_URL_XML = '{url href="alias=SITE_ALIAS"}';

var FAILED_REQUEST = "{lang code='requestisfiled.catalog.text' ucf=true|replace:'"':'&quot;'}";
var DELETEIMAGE_LINK = "{lang code='deleteimage.catalog.link' ucf=true|replace:'"':'&quot;'}";
var DEFAULT_IMAGE = "{lang code='defaultimage.catalog.text' ucf=true|replace:'"':'&quot;'}";
var DELETEFILE_LINK = "{lang code='deletefile.catalog.link' ucf=true|replace:'"':'&quot;'}";

var ENTER_PRODUCT_NAME = "{lang code='enterproductname.catalog.message' ucf=true|replace:'"':'&quot;'}";
var ENTER_PRODUCT_COST = "{lang code='enterproductcost.catalog.message' ucf=true|replace:'"':'&quot;'}";
var CHOOSE_NODE_PLEASE = "{lang code='enterproductcategory.catalog.error' ucf=true|replace:'"':'&quot;'}";
var ERROR_3D_WITHOUT_FILES = "{lang code='cantgenere3dmodelwf.catalog.error' ucf=true|replace:'"':'&quot;'}";
var CHANGE_PRODUCT_TYPE_CONFIRM = "{lang code='changeproducttypeconfirm.catalog.query' ucf=true|replace:'"':'&quot;'}";
var WRONG_IMAGE_URL = "{lang code='wrongimageurl.catalog.error' ucf=true|replace:'"':'&quot;'}";

var HASH = '{$hash}';

var PARAMS_PREVIEW_IMAGE = '{$params->showPreloadImages}';

{literal}
RADAddEditProduct = {
    selectedType: 0,
    applyClick: function()
    {
       if(this.validateForm()) {
           var parent_id = $('product_tree').getSelected().get('value');
           var reg = /parent_id\/(\d+)$/; // example: parent_id/123
           if( !reg.test(document.location) ){
               $('addedit_form').action += 'parent_id/'+parent_id;
           }
           $('returntorefferer').value='1';
           $('addedit_form').submit();
       }
    },
    saveClick: function()
    {
       if (this.validateForm()) {
           var parent_id = $('product_tree').getSelected().get('value');
            var reg = /parent_id\/(\d+)$/;
            if( !reg.test(document.location) ){
                $('addedit_form').action += 'parent_id/'+parent_id;
            }
           $('addedit_form').submit();
       }
    },
    cancelClick: function()
    {
        var parent_id = $('product_tree').getSelected().get('value');
        location = BACK_URL+'#nic/'+parent_id;
    },
    deleteClick: function(element)
    {
        if(confirm('{/literal}{lang code="reallydeleteproduct.catalog.query"}{literal}')) {
            var parent_id = $('product_tree').getSelected().get('value');
            var href = element.href;
            href = href.replace("deleteproductnojs", "deleteproductnojs/parent_id/" + parent_id);
            element.href = href;
            return true;
        }
        return false;
    },
    validateForm: function()
    {
        var messages = new Array();
        if($('productname').value.length==0)
            messages.push(ENTER_PRODUCT_NAME);
        if($('cost').value.length==0)
           messages.push(ENTER_PRODUCT_COST);
        var have_selected = false;
        for(var i=0;i<$('product_tree').options.length;i++){
            if($('product_tree').options[i].selected)
                have_selected = true;
        }
        if(!have_selected)
           messages.push(CHOOSE_NODE_PLEASE);
        if(messages.length>0){
            var s = '';
            for(var i=0;i < messages.length;i++){
                s += messages[i]+String.fromCharCode(10)+String.fromCharCode(13);
            }
            alert(s);
            return false;
        }
        return true;
    },
    changeType: function(obj, pr_id)
    {
        if(this.selectedType == 0) {
            this.selectedType = pr_id;
        }
        if($('action_sub').value=='edit') {
            if(confirm(CHANGE_PRODUCT_TYPE_CONFIRM)) {
                var toSelect = obj.options[obj.selectedIndex].value;
                if(this.selectedType > 0 && this.selectedType == pr_id) {
                    this.selectedType = toSelect;
                } else if(toSelect == pr_id && this.selectedType != pr_id) {
                    this.selectedType = pr_id;
                }
                this.loadTypes(obj);
            } else {
                selectSel(obj, this.selectedType);
            }
        } else {
            this.loadTypes(obj);
        }
    },
    loadTypes: function(obj)
    {
       var si = obj.selectedIndex;
       if(si>=0){
           var id = obj.options[si].value;
           $cid_t = '';
           if($('action_sub').value=='edit'){
               $cid_t = 'cat_id/'+$('cat_id').value+'/';
           }
           if(id==0){
              $('typesDiv').set('html','');
           } else {
              var req = new Request({
                 url: LOAD_TYPES_URL+'node_id/'+id+'/'+$cid_t,
                 onSuccess: function(txt) {
                    $('typesDiv').set('html',txt);
                 },
                 onFailure: function(){
                     alert(FAILED_REQUEST);
                 }
              }).send();
           }
       }//si>0
    },
    remoteImgPreview: function()
    {
        $('remoteImgError').set('text', '');
        obj = $('product_image_url');
        if (obj.value.length>0 && obj.value.substr(0,4) == 'http'){
            var req = new Request.JSON({
                url: GET_REMOTE_IMG+'url/'+escape(encodeURIComponent(obj.value)),
                onSuccess: function(result) {
                    if(result.is_success == true && result.filename.length > 0) {
                        var is_loaded = false;
                        for(i=0; i < RADCATImages.iterator; i++) {
                            if($('remote_image_'+i) && $('remote_image_'+i).value == result.filename) {
                                is_loaded = true;
                            }
                        }
                        if(!is_loaded) {
                            var div = new Element('div',{'id':'remoteimage_'+RADCATImages.iterator});
                            div.set("html", '<img src="'+SITE_URL+'image.php?f=tmp/'+result.filename+'&p=product_box&m=core" style="max-width:100%;"/><input type="hidden" name="remote_image['+RADCATImages.iterator+']" id="remote_image_'+RADCATImages.iterator+'" value="'+result.filename+'"/><br/><input type="radio" value="'+RADCATImages.iterator+'" id="default_image_'+RADCATImages.iterator+'" name="default_image" /><label for="default_image_'+RADCATImages.iterator+'">'+DEFAULT_IMAGE+'</label><a href="javascript:RADAddEditProduct.remoteImgRemove('+RADCATImages.iterator+');">'+DELETEIMAGE_LINK+'</a><div style="width:100%;height:1px;border-bottom:1px solid #D9D9D9;margin-bottom:25px;"></div>');
                            RADCATImages.iterator += 1;
                            $('remote_imgages_preview').adopt(div);
                        }
                    } else {
                        if(result.msg != '') {
                            RADAddEditProduct.remoteImgError(result.msg);
                        } else {
                            RADAddEditProduct.remoteImgError('Some error while loading image!');
                        }
                    }
                },
                onFailure: function(){
                    RADAddEditProduct.remoteImgError(FAILED_REQUEST);
                }
            }).get();
        } else {
            this.remoteImgError(WRONG_IMAGE_URL);
        }
    },
    remoteImgRemove: function(id)
    {
        if(id >= 0 && $('remoteimage_'+id)) {
            RADCATImages.findAndSetNextDefault(id);
            $('remoteimage_'+id).dispose();
        }
    },
    remoteImgError: function(msg)
    {
        $('remoteImgError').set('text', msg);
        $('remoteImgError').set('styles', {display:'block'});
    },
    recAddSelItems: function(sn,items,nbsp)
    {
        for(var i=0;i < items.length;i++){
           if(items[i].child.length)
              this.recAddSelItems(sn,items[i].child,nbsp+6);
           var s = '';
           if(nbsp) {
               for(var k=0;k < (nbsp/2);k++) {
                   s += ' ';
               }
           }
           addSel(sn, s+items[i].tre_name, items[i].tre_id);
           sn.options[sn.options.length-1].style.marginLeft = nbsp+'px';
        }
    },
    getNewRubrics: function(lang_id)
    {
       $('product_tree').selectedIndex = -1;
       clearSel($('product_tree'));
       var req = new Request({
           url: GET_CATEGORIES_URL+'i/'+lang_id+'/',
           onSuccess: function(txt){
              var items = eval(txt);
              RADAddEditProduct.recAddSelItems($('product_tree'),items,0);
           },
           onFailure: function(){
               alert(FAILED_REQUEST);
           }
       }).send();
    },
    getTypesList: function(lang_id)
    {
       $('typeproduct').selectedIndex = -1;
       clearSel($('typeproduct'));
       var req = new Request({
           url: GET_TYPES_URL+'i/'+lang_id+'/',
           onSuccess: function(txt) {
              var items = eval(txt);
              $('typeproduct').options[0] = new Option('{/literal}{lang code='-pleaseselect'}{literal}',0,false,false);
              RADAddEditProduct.recAddSelItems($('typeproduct'),items,0);
              selectSel($('typeproduct'),PRODUCT_CT_ID);
              RADAddEditProduct.loadTypes($('typeproduct'));
           },
           onFailure: function() {
               alert(FAILED_REQUEST);
           }
       }).send();
    },
    changeContentLang: function(lngid,lngcode)
    {
       this.getNewRubrics(lngid);
       this.getTypesList(lngid);
    },
    message: function(message){
       document.getElementById('addeditproductMessage').innerHTML=message;
       setTimeout("document.getElementById('addeditproductMessage').innerHTML='';",5000);
    }
}

RADCHLangs.addContainer('RADAddEditProduct.changeContentLang');

RADTabs = {
    change: function(id)
    {
       $('TabsPanel').getElements('.vkladka').removeClass('activ');
       $(id).className += ' activ';
       $('TabsWrapper').getElements('div[id$=tabcenter]').setStyle('display', 'none');
       if($(id+'_tabcenter')){
           $(id+'_tabcenter').setStyle('display','block');
       }
    }
}

RADCATImages = {
    iterator: 1,
    treeLicense:false,
    req3Sended: 0,
    transaction:'',
    addNewImage: function()
    {
        var ts = '';
        if(PARAMS_PREVIEW_IMAGE) {
            ts = ' onchange="RADCATImages.showPreloadImage(this);"';
        }
        var div = new Element('div',{'id':'tabimage_'+this.iterator});
        div.set("html",'<input type="file" name="product_image['+this.iterator+']" id="product_image_'+this.iterator+'" value=""'+ts+' />&nbsp;&nbsp;<input type="radio" value="'+this.iterator+'" id="default_image_'+this.iterator+'" name="default_image" /><label for="default_image_'+this.iterator+'">'+DEFAULT_IMAGE+'</label>&nbsp;&nbsp;<a href="javascript:RADCATImages.deleteImage('+this.iterator+');">'+DELETEIMAGE_LINK+'</a><div id="tabimage_'+this.iterator+'_preview"></div>');
        this.iterator+=1;
        $('tables_images').adopt(div);
    },
    deleteImage: function(img_id)
    {
        if(img_id >= 0 && $('tabimage_'+img_id)) {
            $('tabimage_'+img_id).destroy();
            RADCATImages.findAndSetNextDefault(img_id);
        }
    },
    showPreloadImage: function(obj)
    {
        if(Browser.Engine.trident) {
            $(obj.parentNode.id+'_preview').set('html','<img src="file://'+obj.value+'" border="0" />');
        }
    },
    'treeDBinAuthorize': function(user)
    {
        if(user.u_email.length) {
            $('authorize_3dbin').setStyle('display', 'none');
            if(this.treeLicense) {
                $('license_3dbin').style.display = 'none';
                $('tables_3dimages').setStyle('display', '');
            } else {
                $('license_3dbin').setStyle('display', '');
            }
        }
    },
    'treeDBinLicense': function()
    {
        $('license_3dbin').style.display = 'none';
        $('tables_3dimages').style.display = '';
    },
    'loading3d': function(load)
    {
        if(load) {
            $('load_3d_bar').style.display = '';
        } else {
            $('load_3d_bar').style.display = 'none';
        }
    },
    'check3dfinish': function()
    {
        if(this.req3Sended==0) {
            this.req3Sended = 1;
            var req = new Request.JSON({
                url: SITE_URL_XML,
                method: 'post',
                data: {'action':'3dbin_check', 'transaction':RADCATImages.transaction, 'cat_id':$('cat_id').get('value'), 'hash':HASH},
                onSuccess: function(JSON, Text) {
                    if(JSON.progress >= 0 && JSON.progress <= 99) {
                        RADCATImages.req3Sended = 0;
                        $('load_3d_percent').set('html', JSON.progress+'%');
                        setTimeout("RADCATImages.check3dfinish();", 991);
                    } else if(JSON.progress < 0) {
                        alert('Some error! Write to admin or webmaster!');
                        RADCATImages.loading3d(false);
                        RADCATImages.req3Sended = 2;
                    } else {
                        RADCATImages.loading3d(false);
                        $('load_3d_percent').set('html', '');
                        RADCATImages.refresh3DViews();
                        RADCATImages.req3Sended = 2;
                    }
                },
                onFailure: function() {
                    RADCATImages.loading3d(false);
                    RADCATImages.req3Sended = 2;
                }
            }).send();
        } else if(this.req3Sended==1) {
            alert('Some dublicate timeout in line: 268 at getjs_addeditproduct.tpl');
        }
    },
    'refresh3DViews': function()
    {
        $('3dimages_done').set('html', $('load_3d_bar').get('html'));
        var req = new Request({
            url: SITE_URL_XML,
            method: 'post',
            data: {'action':'3dbin_refresh', 'cat_id':$('cat_id').get('value')},
            onSuccess: function(txt) {
                $('3dimages_done').set('html', txt);
            }
        }).send();
    },
    'findAndSetNextDefault': function(id)
    {
        defRadioList = document.getElementsByName('default_image');
        if(defRadioList.length > 1){
            for (var i = 0; i < defRadioList.length; i++) {
                if(defRadioList[i].id === ("default_image__ex_"+id)){
                    $("default_image__ex_"+id).set('checked',false);
                } else {
                    var newid = defRadioList[i].id.substr(18);
                    if (newid=='' || !$('del_img_' + newid).checked) {
                        $(defRadioList[i].id).set('checked',true);
                        break;
                    }
                }
            }
        }
    }
}

tabernalogin.addContainer('RADCATImages.treeDBinAuthorize');
tabernalogin.addLicenseContainer('RADCATImages.treeDBinLicense');

window.addEvent('domready', function() {
    $('advanced3dbinSlide').setStyle('display', 'none');
    $('advanced_3dbin').addEvent('click', function(event) {
        if($('advanced3dbinSlide').style.display=='') {
            $('advanced3dbinSlide').setStyle('display', 'none');
        } else {
            $('advanced3dbinSlide').setStyle('display', '');
        }
        event.stop();
    });
    $('submit3dButton').addEvent('click', function() {
        RADCATImages.loading3d(true);
        var tdParams_is360view = false;
        var tdParams_autoalign = false;
        var tdParams_сrop = false;
        if($('tdParams_is360view').get('checked')) {
            tdParams_is360view = true;
        }
        if($('tdParams_autoalign').get('checked')) {
            tdParams_autoalign = true;
        }
        if($('tdParams_сrop').get('checked')) {
            tdParams_сrop = true;
        }
        var params = {'tdParams_width':$('tdParams_width').get('value'), 
                      'tdParams_height':$('tdParams_height').get('value'),
                      'tdParams_name':$('tdParams_name').get('value'),
                      'tdParams_is360view':$('tdParams_is360view').get('value'),
                      'tdParams_logo':$('tdParams_logo').get('value'),
                      'tdParams_is360view':tdParams_is360view,
                      'tdParams_autoalign':tdParams_autoalign,
                      'tdParams_crop':tdParams_сrop,
                      'action':'3dbin_genere',
                      'files':new Array(),
                      'hash': HASH,
                      'cat_id':'new'
                    };
        
        $$('.input_fileuploader').each(function(el){
            params.files.push(el.value);
        });
        if($('cat_id')) {
            params.cat_id = $('cat_id').value;
        }
        if(!params.files.length) {
            alert(ERROR_3D_WITHOUT_FILES);
            RADCATImages.loading3d(false);
            return false;
        }
        var req = new Request.JSON({
                url: SITE_URL_XML,
                method: 'post',
                data: params,
                onSuccess: function(JSON, Text) {
                    $$('.upload_item').each(function(el){el.destroy();});
                    //RADCATImages.loading3d(false);
                    RADCATImages.transaction = JSON.transaction_id;
                    //$('3dimages_done').set('html', txt);
                    RADCATImages.loading3d(true);
                    RADCATImages.check3dfinish();
                },
                onFailure: function() {
                    RADCATImages.loading3d(false);
                }
            }).send();
        //Send all photos to 3dbin.tabernacms.com server to genere 3d-model
    });
});

RADCATFiles = {
    iterator: 1,
    addNew: function()
    {
        var ts = '';
        var div = new Element('div',{'id':'tabfile_'+this.iterator});
        div.set("html",'<input type="file" name="product_file['+this.iterator+']" id="product_file_'+this.iterator+'" value=""'+ts+' />&nbsp;&nbsp;<a href="javascript:RADCATFiles.deleteFile('+this.iterator+');">'+DELETEFILE_LINK+'</a>');
        this.iterator+=1;
        $('tables_files').adopt(div);
    },
    deleteFile: function(img_id)
    {
       $('tabfile_'+img_id).destroy();
    }
}
/*
window.onload = function() {
    RADAddEditProduct.loadTypes($('typeproduct'));
}
*/
{/literal}