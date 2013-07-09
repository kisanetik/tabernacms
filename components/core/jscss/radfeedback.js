var RADFeedbackForm = function(initObject) {
    
    this.docRoot = SITE_URL;

    this.elementIdFio = 'sender_fio';
    this.elementIdEmail = 'sender_email';
    this.elementIdText = 'message_body';

    this.messageRequiredField = REQUIRED_FIELD;
    this.messageEmailEmpty = EMPTY_EMAIL_FIELD;
    this.messageEmailIncorrect = EMAIL_INCORRECT;

    // List of required
    this.RequiredFields = ['sender_fio', 'sender_email', 'message_body', 'captcha_text'];
    this.MinEmailLength    = 3;
    this.CSSMessageClass   = 'message';
    this.CSSIncorrectClass = 'error';

    if (typeof initObject != 'undefined') this.init(initObject);

    this.init = function(initObject)
    {
        if (typeof initObject == 'undefined') initObject = {};
        this.docRoot = typeof initObject.docRoot == 'undefined' ? this.docRoot : initObject.docRoot;
        this.elementIdEmail = typeof initObject.elementIdEmail == 'undefined' ? this.elementIdEmail : initObject.elementIdEmail;
        this.messageEmailIncorrect = typeof initObject.messageEmailIncorrect == 'undefined' ? this.messageEmailIncorrect : initOmessageLostPassword;
    };
    this.clearError = function(elementId)
    {
        $('#'+elementId).css('border', '1px solid #b7babe');
        this.clearIcon(elementId);
        this.clearMessages(elementId);
    };
    this.setError = function(elementId, message)
    {
        $('#'+elementId).css('border', '1px solid #f00');
        this.setIcon(elementId, 'ico_error');
        this.setMessage(elementId, message, this.CSSIncorrectClass);
    };
    this.setMessage = function(elementId, message, messageClass)
    {
        if (typeof messageClass == 'undefined') messageClass = '';
        var myMessage  = '<div class="' + this.CSSMessageClass + ' ' + messageClass + '">' + message + '</div>';
        $('#'+elementId).parent().after(myMessage);
    };
    this.clearMessages = function(elementId)
    {
        $('#'+elementId).parent().parent().find('.'+this.CSSMessageClass).detach();
    };
    this.setIcon = function(elementId, iconClass)
    {
        this.clearIcon(elementId);
        $('#'+elementId).after('<div class="icon ' + iconClass + '"></div>');
    };
    this.clearIcon = function(elementId)
    {
        $('#'+elementId).parent().find('.icon').detach();
    };
    this.validateRequired = function (fieldId) 
    {
        var value = $('#'+fieldId).val();
        if (value.length > 0) {
            this.clearError(fieldId);
            return true;
        }
        this.setError(fieldId, this.messageRequiredField);
        return false;
    };
    this.validateEmail = function () 
    {
        var email = $('#'+this.elementIdEmail).val();
        return /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email);
    };
    
    this.validate = function () 
    {
        $('.message').detach();
        var req = true;
        for(var i in this.RequiredFields) {
            var elementId = this.RequiredFields[i];
            var currentResult = this.validateRequired(elementId);
            req = req && currentResult;
        }
        var email = this.validateEmail();

        if ( req && email ) {
            return true;
        }

        if(!email) {
            this.setError(this.elementIdEmail, this.messageEmailIncorrect);
        }
        return false;
    };
};
var RADFeedbackForm = new RADFeedbackForm();