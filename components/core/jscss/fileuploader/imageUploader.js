var Widgets = (function(){

    /**
     * Функция для организации наследовния
     * @param subClass
     * @param superClass
     */
    function extend(subClass, superClass) {
        var F = function() {};
        F.prototype = superClass.prototype;
        subClass.prototype = new F();
        subClass.prototype.constructor = subClass;
        subClass.superclass = superClass.prototype;
        if (superClass.prototype.constructor == Object.prototype.constructor) {
            superClass.prototype.constructor = superClass;
        }
    }

    /*
     Виджет загрузки картинок
     var conf = {
     containerId : '#containerId', // required Контейнер виджета
     multiImage : false, // возможность загружать несколько изображений
     withConfirm : true // подтверждение при удалении
     }
     */

    function fileUploadWidget(conf) {
        // Конструктор объекта
        var self = this;
        self.containerId = '#' + conf.containerId;
        self.widgetName = conf.containerId;
        self.widgetForm = $(conf.containerId + '_form');
        self.withConfirm = conf.withConfirm | true;
        self.urlDir = conf.urlDir;
        self.multiImage = conf.multiImage | false;
        self.fieldPrefixName = conf.fieldPrefixName;

        self.startUpload = function() {
            $(self.containerId).find('div.upload_progress_bar').css('display', 'block');
            $(self.containerId).find('.upload_form').css('display', 'none');
            return true;
        }

        self.stopUpload = function (responce) {
            var result = '';
            if (responce.success == true) {
                result =  self._getHtmlResult(responce);
                $(self.containerId).find('.upload_gallery ul').append(result);
                $(self.containerId).find('.upload_gallery a').lightBox();
                $(self.containerId).find('.upload_progress_bar').css('display', 'none');
                if (self.multiImage) {
                    $(self.containerId).find('.upload_form').css('display', '');
                }
            } else {
                $(self.containerId).find('.upload_form').css('display', '');
                $(self.containerId).find('.upload_progress_bar').css('display', 'none');
                alert(responce.errors);
            }
            return true;
        }


        self.init = function() {
            var imagesExists = $(self.containerId).find('.upload_gallery ul').children().length;
            if (imagesExists && !self.multiImage) {
                $(self.containerId).find('.upload_form').css('display', 'none');
            }
            //$(self.containerId).find('.upload_gallery a').lightBox();
        }

        self._getHtmlResult = function(responce) {

            return '<li class="upload_item">' +
                '<input type="hidden" name="' + this.fieldPrefixName + self.widgetName + '[]" value="' + responce.fileName + '" class="input_fileuploader" />' +
                '<a target="_blank" href="' + SITE_URL + '/image.php?th=~~~THEMENAME~~~&m=' + self.urlDir + '&f=' + responce.fileName +
                '"><img src="' + SITE_URL + '/image.php?th=~~~THEMENAME~~~&m=' + self.urlDir + '&w=150&h=100&f=' + responce.fileName +
                '"  alt="" /></a>' +
                '<div style="clear:both"/><img class="upload_delete_trigger" src="~~~URL~~type=image~~module=core~~preset=original~~file=fileuploader/delete.png~~~" /></li>';
        }

        // действия по инициализации объекта
        self.widgetForm.submit(
            function() {
                self.startUpload();
            });



        self.widgetForm.find('.upload_file_field').change(function() {
            self.widgetForm.submit();
        });

        $(self.containerId).find('.upload_button').click(function() {
            self.widgetForm.find('.upload_file_field').click();
        });



        $(self.containerId).find('.upload_item img.upload_delete_trigger').live('click', function(event) {
            if (!event.isPropagationStopped()) {
                event.stopPropagation();
                if (confirm(i18nWidgets.confirmRemoveImage + "?")) {
                    $.ajax({
                        url: "/ru/personalcabinet/action/removeFile/",
                        dataType: 'json',
                        type: "POST",
                        data: {file :  $(event.target).parent().find("input[type='hidden']")[0].value, token: $('#token').val(), path : self.widgetForm.find('input[name="filePathForSave"]').val()},
                        success: function(responce) {
                            if (responce) {
                                if (responce.success == true) {
                                    $(event.target).parent().fadeOut(function() {
                                        $(event.target).parent().empty();
                                        $(self.containerId).find('.upload_form').css('display', '')
                                    });
                                } else {
                                    alert("Error");
                                }
                            }
                        }
                    });
                }
            }
            return false;
        });
    }

    return new function() {
        this.createImageUploadWidget = function(params) {
            return new fileUploadWidget(params);
        }
    }
})();