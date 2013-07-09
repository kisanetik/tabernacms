/**
 * Requirez JQuery
 * @author Denys Yackushev
 * @depcreated jquery
 * @package Taberna eCommerce
 */
RADBIN = {
    'addToBin': function(cat_id,obj)
    {
        var count = 1;
        $.post(URL_ADDTOBIN, {'cat_id':cat_id,'count':count}, function(data){
            RADBIN.refresh();
            $.post(URL_SHOWBINWINDOW, {}, function(data){
                var winc = jQuery(data);
                var window=winc.find('div.binwindow');
                winc.prependTo($(obj).parent('div.servfon'));
                window.show(100, function(){
                    window.hover(function () {
                        window.stop().css('opacity', 100);
                    }, function () {
                        window.fadeOut(30000, function () {winc.remove();});
                    });
                    window.fadeOut(30000, function () {winc.remove();});
                });
            });
        });
    },
    'message':function(mes,cat_text)
    {
        cat_text = cat_text || '';
        alert(mes+'   '+cat_text);
    },
    'refresh':function()
    {
        $('#prebasket').load(URL_REFRESHBIN , function () {
            $('.upl2').show();
        });
    },
    'refreshOrder':function()
    {
        $('#basket_content_list').load(URL_REFRESHORDER);
    },
    'hide': function()
    {
       $('.upl2').hide();
    },
    'changeCount': function(bin_id,count_plus)
    {
        if( $('#count_bp'+bin_id).val() == 1 && count_plus == -1) {
            if(!confirm(CONFIRM_DELETTING)) {
                RADBIN.refresh();
                return;
            }
        }
        $.post(URL_CHANGEBINCOUNT, {'bin_id':bin_id,'cnt_op':count_plus}, function(data){eval(data);});
        $('#count_bp'+bin_id).val( parseFloat($('#count_bp'+bin_id).val())+parseFloat(count_plus));
    },
    'setCount': function(bin_id,count_set)
    {
        if(count_set == 0) {
            if(!confirm(CONFIRM_DELETTING)) {
                RADBIN.refresh();
                return;
            }
        }
        $.post(URL_CHANGEBINCOUNT, {'bin_id':bin_id,'cnt_set':count_set}, function(data){eval(data);});
        $('#count_bp'+bin_id).val( parseFloat(count_set) );
    },
    'deleteFromBin': function(bin_id){
        if(confirm(CONFIRM_DELETTING)) {
            $.post(URL_DELFROMBIN,{'bin_id':bin_id});
            RADBIN.refreshOrder();
            this.hide();
            this.refresh();
        }
    },
    'doOrder': function()
    {
        location = URL_ORDER;
    }
}