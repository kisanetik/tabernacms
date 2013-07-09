var RADRegForm = function(initObject) {
    
    this.docRoot = SITE_URL;
    this.checkEmailURI = URL_CHECK_EMAIL;
    this.RemindPasswordURI = this.docRoot+"rempass.html";

    this.elementIdEmail = 'u_email';
    this.elementIdPassword1 = 'u_pass1';
    this.elementIdPassword2 = 'u_pass2';
    this.elementIdSubmit = 'registration_submit';

    this.messageRequiredField = REQUIRED_FIELD;
    this.messageEmailEmpty = EMPTY_EMAIL_FIELD;
    this.messageEmailCorrect = EMAIL_CORRECT;
    this.messageEmailIncorrect = EMAIL_INCORRECT;
    this.messageEmailExists = EMAIL_EXSISTS;
    this.messageLostPassword = LOST_PASSWORD;

    // List of required
    this.RequiredFields = ['u_email', 'u_fio', 'u_login', 'u_pass1', 'u_pass2', 'captcha'];
    this.MinEmailLength    = 3;
    this.CSSMessageClass   = 'message';
    this.CSSIncorrectClass = 'error';
    this.CSSCorrectClass   = 'green';

    if (typeof initObject != 'undefined') this.init(initObject);

    this.init = function(initObject)
    {
        if (typeof initObject == 'undefined') initObject = {};

        this.docRoot = typeof initObject.docRoot == 'undefined' ? this.docRoot : initObject.docRoot;
        this.checkEmailURI = typeof initObject.checkEmailURI == 'undefined' ? this.checkEmailURI : initObject.checkEmailURI;
        this.RemindPasswordURI = typeof initObject.RemindPasswordURI == 'undefined' ? this.RemindPasswordURI : initObject.RemindPasswordURI;

        this.elementIdEmail = typeof initObject.elementIdEmail == 'undefined' ? this.elementIdEmail : initObject.elementIdEmail;
        this.elementIdSubmit = typeof initObject.elementIdSubmit == 'undefined' ? this.elementIdSubmit : initObject.elementIdSubmit;

        this.messageEmailCorrect = typeof initObject.messageEmailCorrect == 'undefined' ? this.messageEmailCorrect : initObject.messageEmailCorrect;
        this.messageEmailIncorrect = typeof initObject.messageEmailIncorrect == 'undefined' ? this.messageEmailIncorrect : initObject.messageEmailIncorrect;
        this.messageEmailExists = typeof initObject.messageEmailExists == 'undefined' ? this.messageEmailExists : initObject.messageEmailExists;
        this.messageLostPassword = typeof initObject.messageLostPassword == 'undefined' ? this.messageLostPassword : initObject.messageLostPassword;
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
    this.setCorrect = function(elementId, message)
    {
        $('#'+elementId).css('border', '1px solid #0f0');
        this.setIcon(elementId, 'ico_good');
        this.setMessage(elementId, message, this.CSSCorrectClass);
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

    this.checkEmail = function()
    {
        var email = $('#'+this.elementIdEmail).val();
        if (email.length > 0) {
            if (this.validateEmail()) {
                var parent = this;
                $.ajax({
                    url: this.checkEmailURI,
                    type: "POST",
                    dataType: "json",
                    data: {
                        email: email
                    },
                    success: function(userId){
                        if (userId > 0) {
                            var errorMessage  = parent.messageEmailExists;
                                errorMessage += ' ';
                                errorMessage += '<a href="'+parent.RemindPasswordURI+'">';
                                errorMessage += parent.messageLostPassword;
                                errorMessage += '</a>';
                                errorMessage += '?';
                                parent.setError(parent.elementIdEmail, errorMessage);
                        } else {
                            parent.setCorrect(parent.elementIdEmail, parent.messageEmailCorrect)
                        }
                    }
                });
            } else {
                this.setError(this.elementIdEmail, this.messageEmailIncorrect);
            }
        } else {
            this.setError(this.elementIdEmail, this.messageRequiredField);
        }
    };
    this.validateRequired = function (fieldId) 
    {
        var value = $('#'+fieldId).val();
        if (value.length > 0) {
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
    this.validatePassword = function ()
    {
        var pass1 = $('#'+this.elementIdPassword1).val();
        var pass2 = $('#'+this.elementIdPassword2).val();
        if(pass1.length < 6) {
            this.setError(this.elementIdPassword1, PASSWORDS_IS_SHORT);
            return false;
        }
        if(pass1 != pass2) {
            this.setError(this.elementIdPassword1, PASSWORDS_NOT_MATCH);
            this.setError(this.elementIdPassword2, PASSWORDS_NOT_MATCH);
            return false;
        }
        return true;
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
        var pass  = this.validatePassword();
        if ( req && email && pass ) {
            $('#'+this.elementIdSubmit).attr('disabled', '');
            return true;
        }
        $('#'+this.elementIdSubmit).attr('disabled', 'disabled');
        return false;
    };
};

var RADRegForm = new RADRegForm();