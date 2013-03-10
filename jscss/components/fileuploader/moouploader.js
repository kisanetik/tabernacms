var FileUploader = function(conf) {
    var self = this;
    var fieldPrefixName = conf.multiImage;
    var  urlDir = conf.urlDir;
    var widgetName = conf.containerId;
    var container = $(conf.containerId);
    var widgetForm = $(conf.containerId + '_form');
    var multiImage = conf.multiImage;
/*
    self.init = function() {
        var imagesExists = $(container).getElement('.upload_gallery ul').children().length;
        if (imagesExists && !self.multiImage) {
            $(self.containerId).find('.upload_form').css('display', 'none');
        }
        $(container).getElements('.upload_item img.upload_delete_trigger').addEvent('click', removeHandler);
    }
*/
    $(container).getElement('.upload_button').addEvent('click',  function() {
        $(widgetForm).getElement('.upload_file_field').click();
    });

    $(widgetForm).getElement('.upload_file_field').addEvent('change', function() {
        if($(widgetForm).getElement('.upload_file_field').value) {
            widgetForm.submit();
            startUpload();
        }
    });

    startUpload = function() {
        $(container).getElement('div.upload_progress_bar').setStyle('display', 'block');
        $(container).getElement('.upload_form').setStyle('display', 'none');
    }

    removeHandler = function(event) {
        //prevent the page from changing
        var clickEvent = event;
        //make the ajax call
        var req = new Request.JSON({
            method: 'post',
            url: '/ru/CATmanageCatalog/action/removefile/',
            data: {file :  $(event.target).getParent().getParent().getElement("input[type='hidden']").value, path : $(widgetForm).getElement('input[name="filePathForSave"]').value},
            onComplete: function(response) {
                 if (response) {
                    if (response.success == true) {
                        $(clickEvent.target).getParent().getParent().dispose();
                        $(container).getElement('.upload_form').setStyle('display', '');
                    } else {
                        alert("Error");
                    }
                 }
            }
        }).send();
    };

    self.stopUpload = function (responce) {
        var result = '';
        if (responce.success == true) {
            var imageList = $(container).getElement('.upload_gallery ul');
            imageList.set("html", imageList.get("html") + _getHtmlResult(responce));
            $(container).getElement('.upload_progress_bar').setStyle('display', 'none');
            if (multiImage) {
                $(container).getElement('.upload_form').setStyle('display', '');
            }
        } else {
            $(container).getElement('.upload_form').setStyle('display', '');
            $(container).getElement('.upload_progress_bar').setStyle('display', 'none');
            alert(responce.errors);
        }
        $(container).getElements('.upload_item img.upload_delete_trigger').addEvent('click', removeHandler);
        return true;
    }

    _getHtmlResult = function(responce) {

        return '<li class="upload_item">' +
            '<input type="hidden" name="' + fieldPrefixName + widgetName + '[]" value="' + responce.fileName + '" class="input_fileuploader" />' +
            '<a target="_blank" href="' + SITE_URL + '/image.php?m=' + urlDir + '&f=' + responce.fileName +
            '"><img src="' + SITE_URL + '/image.php?m=' + urlDir + '&w=150&h=100&f=' + responce.fileName +
            '"  alt="" /></a>' +
            '<div style="clear:both"/><img class="upload_delete_trigger" src="' + SITE_URL +  '/jscss/components/fileuploader/delete.png" /></li>';
    }
};