function scrollToDiv(element,navheight){
	var offset = element.offset();
	var offsetTop = offset.top;
	var totalScroll = offsetTop-navheight;
	$('body,html').animate({
	scrollTop: totalScroll
	}, 500);
}

/* === COMMENTS Objects definitions */
function product_object(productId)
{
    /* --- Properties */
    this.comment = new comment_object(productId);
    /* --- Methods */
    this.image_click = function() {
        $('a.lightbox:first').click();
    } /* product_object.image_click() */
    this.image_3d_click = function() {
    	$('.3dbin-dialog').dialog('open');
    }
} /* product_object() */

function comment_object(productId)
{
    /* --- Properties */
    this.productId = productId;
    this.url       = URL_ADDCOMMENT;
    this.get_url   = URL_GETCOMMENTS;
    var self       = this;
    this.fck 	   = null; 

    /* --- Methods */
    this.form_toggle = function(parent_id) {
        $('#product_comment_form').toggle('slow');
        var state = $('#product_comment_form').css('display');
        switch (state) {
            case 'none':
                break;
            case 'block':
            default: // block
                $('#product_comment_text').val('');
                $('#product_comment_text').focus();
                $('#product_comment_captcha').val();
                $('#parent_id').val(parent_id);
                RADCaptcha.renew('capcha_img');
        }
    } /* comment_object.form_toggle() */

    this.update_view = function(serverResponce) {

        /* @TODO: Нужен более оптимальней способ находить число комментов. */
        var count =  parseInt($('.comments_total:last').text())+1;
        this.update_count(count);
        this.update_comments(serverResponce);
    } /* comment_object.update() */

    this.update_count = function(count) {
        $('.comments_total').text(count);
    } /* comment_object.update_count() */

    this.page = function(pageNumber) {
        if (typeof pageNumber == 'undefined') {
            pageNumber = parseInt(pageNumber);
            $pageNumber = pageNumber < 1 ? 1 : pageNumber;
        }
        $.ajax({
            type: "POST",
            url: this.get_url+pageNumber,
            data: {
                'p':            this.productId,
                'page':         pageNumber,
            },
            success: function(responce) {
                $('#comment_preloader').hide();
                $('#comment_preloader').hide('slow');
                self.update_view(responce);
            },
            error: function() {
                //
            }
        });

    } /* comment_object.update_count() */

    this.update_comments = function(comments) {
        console.log(comments);
        //$('table.comment tbody').html(comments);
        $('div.specifications.comment').html(comments);
    } /* comment_object.update_comments() */

    this.add = function()
    {   
        var comment = $('#product_comment_text').val();
        comment = comment.replace(/^\s+/, '').replace(/\s+$/, ''); /* trim */
        if (comment.length == 0) {
            alert(RAD_CATALOG_TRANSLATIONS.comment);
            $('#product_comment_text').focus();
            return false;
        }
        var nickname_text = $('#product_comment_nickname').val();
        if (typeof nickname_text != 'undefined' && nickname_text.length == 0) {
            alert(RAD_CATALOG_TRANSLATIONS.nickname);
            $('#product_comment_nickname').focus();
            return false;
        }
        var captcha_text = $('#product_comment_captcha').val();
        var hash = $('#product_comment_hash').val();
        if (typeof captcha_text != 'undefined' && captcha_text.length == 0) {
            alert(RAD_CATALOG_TRANSLATIONS.captcha);
            $('#product_comment_captcha').focus();
            return false;
        }
        var parent_id = $('#parent_id').val();

        $('#comment_preloader').show();
        $('#product_comment_form').hide();

        $.ajax({
            type: "POST",
            url: this.url,
            data: {
                'txt':              comment,
                'p':                this.productId,
                'hash':             hash,
                'captcha':          captcha_text,
                'nickname':         nickname_text,
                'parent_id':        parent_id
            },
            success: function(responce) {
                $('#comment_preloader').hide();
                $('#comment_preloader').hide('slow');
                self.update_view(responce);
            },
            error: function() {
                //
            }
        });
    } /* comment_object.add() */
} /* comment_object() */

/*Comments for the articles & news*/
tcomments = {
	    item: 0,
	    typ: 'n',
	    fck:null,
	    'loadItems': function()
	    {
	    },
        'reply': function(e)
        {
            if ('#parent_id') {
                $('#parent_id').remove();
            }
            $('#f_addComment .comments').append('<input type="hidden" id="parent_id" value="'+ e +'" style="display:none">');
            FCKeditorAPI.GetInstance('text_comments').Focus();
        },
	    'init_short': function(item,typ)
	    {
	    	tcomments.item = item;
	    	tcomments.typ = typ;
	        this.fck = new FCKeditor('text_comments');
	        this.fck.BasePath = '/jscss/fckeditor/';
	        this.fck.Config['SkinPath'] = '/jscss/fckeditor/editor/skins/office2003/';
	        this.fck.Height = '150px';
	        this.fck.Width = '100%';
	        this.fck.ToolbarSet = 'Basic';
	        this.fck.ReplaceTextarea() ;
	        $('#f_addComment').submit(function(){
                if ('#parent_id') {
                    var parent_id = $('#parent_id').val();
                    $('#parent_id').remove();
                }
	        	tcomments.showLoad(true);
	        	var messages = new Array();
	        	if(FCKeditorAPI.GetInstance('text_comments').GetHTML().length < 2) {
	        		messages.push(COMMENTS_ISEMPTY);
	        	}
	        	if($('#captcha_text').length && $('#captcha_text').val().length < 4) {
	        		messages.push(FDO_ENTER_CAPTCHA);
	        		$('#captcha_text').css('border', '1px solid red');
	        		$('#captcha_text').focus();
	        	} else {
	        		$('#captcha_text').css('border', '1px solid #B7BABE');
	        	}
	        	if(!messages.length) {
		        	$.post(ADD_COMMENT_URL, 
		        			{'hash':HASH, 
		        			 'txt':FCKeditorAPI.GetInstance('text_comments').GetHTML(), 
		        			 'i':tcomments.item, 
		        			 't':tcomments.typ, 
                             'parent_id':parent_id, 
		        			 'captcha_fld':$('#captcha_text').val()}, 
		        			function(txt) {
		        				if(txt=='captcha') {
		        					RADCaptcha.renew('captcha_img', SITE_ALIAS);
		        					alert(FDO_ENTER_CAPTCHA);
		        					$('#captcha_text').css('border', '1px solid red').css('color', 'red');
		        	        		$('#captcha_text').focus();
		        				} else {
		        					$('#captcha_text').css('border', '1px solid #B7BABE').css('color', '#787880');
		        				}
		        				$('#commentsItems').html(txt);
		        				tcomments.showLoad(false);
		        			}
		        	);
	        	} else {
	        		var mes = '';
	        		for(var i=0;i < messages.length; i++) {
	        			mes += messages[i]+String.fromCharCode(10,13);
	        		}
	        		alert(mes);
	        		tcomments.showLoad(false);
	        	}
	        	return false;
	        });
	    },
	    'showLoad': function(show)
	    {
	        if(show) {
	            $('#comments_loader').css('display', 'block');
	        } else {
	            $('#comments_loader').css('display', 'none');
	    	}
	    }
	}