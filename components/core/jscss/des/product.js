$(function(){
   if($('.contlnk').length && $('.contable').length)  {
       $('.contlnk a').click(function(){
           $('.contlnk a').addClass('grbt').removeClass('wt');
           $(this).addClass('wt').removeClass('grbt');
           $('.contable .tab').addClass('hide');
           $('#tab_'+$(this).attr('id')).removeClass('hide');
           return false;
       });
   }
});
$(function() {
    if($('a.lightbox').length) {
        $('a.lightbox').lightBox({
            imageLoading: SITE_URL + 'image.php?m=core&p=original&f=des/lightbox/lightbox-ico-loading.gif',
            imageBtnClose: SITE_URL + 'image.php?m=core&p=original&f=des/lightbox/lightbox-btn-close.gif',
            imageBtnPrev: SITE_URL + 'image.php?m=core&p=original&f=des/lightbox/lightbox-btn-prev.gif',
            imageBtnNext: SITE_URL + 'image.php?m=core&p=original&f=des/lightbox/lightbox-btn-next.gif',
            txtImage: RAD_CATALOG_TRANSLATIONS.image,
            txtOf: RAD_CATALOG_TRANSLATIONS.of
        });
    }
});
$(function() {
    if($('#slider-range').length) {
        $( "#slider-range" ).slider({
            range: true,
            min: PRICE_MIN,
            max: PRICE_MAX,
            values: [ CURRENT_COSTFROM, CURRENT_COSTTO ],
            slide: function( event, ui ) {
                $( "#amount-min" ).val(ui.values[0]);
                $( "#amount-max" ).val(ui.values[1]);
            }
        });
        $( "#amount-min" ).val($( "#slider-range" ).slider( "values", 0 ));
        $( "#amount-max" ).val($( "#slider-range" ).slider( "values", 1 ));
        $( "#amount-min" ).change(function(){
            $( "#slider-range" ).slider( "values", 0,  $( "#amount-min" ).val());
        });
        $( "#amount-max" ).change(function(){
            $( "#slider-range" ).slider( "values", 1,  $( "#amount-max" ).val());
        });
    }
    if($('#price-range').length) {
        $('#price-range').click(function(){
            location = COST_FILTER_URL.replace('&#8260;','?').replace('RAD_COST_FROM', $( "#slider-range" ).slider( "values", 0 )).replace('RAD_COST_TO', $( "#slider-range" ).slider( "values", 1 ));
        });
    }
});
$(function(){
    if($('#login_btn').length || $('#logout_btn').length) {
        $.getScript(SITE_URL + 'jscss.php?m=core&t=js&f=radloginpanel.js', function(){

        });
    }
});
$(function(){
    if($('#basket_order_data').length) {
        $.getScript(SITE_URL + 'jscss.php?m=corecatalog&t=js&f=radorder.js', function(){

        });
    }
});
$(function(){
    if($('#paginator').length) {
        $.getScript(SITE_URL + 'jscss.php?m=core&t=js&f=radpaginator.js', function(){
            RADPAGINATOR.init('paginator');
        });
    }
});
$(function(){
    if($('#sender_email').length) {
        $.getScript(SITE_URL + 'jscss.php?m=core&t=js&f=radfeedback.js', function(){

        });
    }
    if($('#capcha_img').length || $('#captcha_img').length) {
        $.getScript(SITE_URL + 'jscss.php?m=corecatalog&t=js&f=radcaptcha.js', function(){

        });
    }
    if($('.regform').length) {
        $.getScript(SITE_URL + 'jscss.php?m=coresession&t=js&f=radreg.js', function(){

        });
    }
});

$(function(){
    if($('#product_comments_count_link').length) {
        $.getScript(SITE_URL + 'jscss.php?m=coreresource&t=js&f=radcomments.js', function(){
            product = new product_object(CAT_ID);
        });
        $('#product_comments_count_link').click(function(){
            $('.contlnk a').addClass('grbt').removeClass('wt');
            $('#comments').addClass('wt').removeClass('grbt');
            $('.contable .tab').addClass('hide');
            $('#tab_'+$('#comments').attr('id')).removeClass('hide');
            scrollToDiv($('#comments'), 40);
            return false;
        });
    }
});

$(function(){
    if($('#peopleB').length) {
        $('#peopleB').change(function(){
            $.post(
                    URL_SYSXML,
                    {'cur_id':$('#peopleB>option:selected').val(),'a':'changeCurrency'},
                    function(data){eval(data);}
            );
        });
    }
});

$(function(){
    if ($('.buyBtn').length && $('.goods_pic').length){
        $('.buyBtn').click(function(){
            if ($('.card').length){
                var pic = $(this).parents('.card').find('.goods_pic');
            } else {
                var pic = $('.goods_pic');
            }
            var img = jQuery('<div class="gpic_wrapper"><img src="'+pic.attr('src')+'"></div>');
            pic.before(img);
            img.offset(function(i,val){
                var speed=((val.top-50)/500)*700;
                if (speed<700) speed=700;
                img.animate({
                    top: -val.top,
                    left: 500,
                    opacity: 0.0
                }, speed, function(){
                    $('.gpic_wrapper').remove();
                });
            });
        });
    }
});

/*
 Callback button functionality: show popup, check data by javascript, send ajax to server
 if no errors show complete message, else show error message
 */
$(function(){
    if (!SHOW_CALLBACK)
        return;
    $('.d-popup-open').on('click', function(e){
        $('.fieldwrapper a.captcha').trigger('click');
        $('.b-d-popup').bPopup({
            fadeSpeed: 'slow',
            followSpeed: 1500,
            positionStyle: 'absolute',
            modalClose: false,
            closeClass: "b-d-popup-close",
            onClose: function(){
                $('.b-d-popup-container .fieldwrapper input[type="text"]').each(function(){
                    $(this).val('');
                    $('.b-quest-form').show();
                    $('.b-callback-complete').hide();
                });
            }
        });
    });
    $('.b-d-popup-container .phone-number-mask').mask("+7(999)999-99-99");
    $('.b-d-popup-container #quest_form').submit(function(e){
        e.preventDefault();
        var phone_regexp = new RegExp('^[+]7[(]\\d{3}[)]\\d{3}-\\d{2}-\\d{2}$');
        var is_errors = false;
        var $error_msg = $('.fieldwrapper .feedback-errors .feedback-errors-content');
        if (!phone_regexp.test($('.b-d-popup-container input.phone-number-mask').val()))
            is_errors = true;
        if ($('.b-d-popup-container input.fio').val().length < 3)
            is_errors = true;
        if ($('.b-d-popup-container input.captcha-input').val().length == 0)
            is_errors = true;
        if (is_errors){
            $error_msg.show();
            return false;
        }
        $error_msg.hide();
        $.ajax({
            type: "post",
            url: submitURL,
            data: $('#quest_form').serialize(),
            success: function(data){
                if (data.error_message !== 'error_none')
                    $('.fieldwrapper .feedback-errors .feedback-errors-content').html(data.error_message).show();
                else {
                    $('.b-quest-form').hide();
                    $('.b-callback-complete').show();
                }
            },
            dataType: "json"
        });
        return false;
    });
});