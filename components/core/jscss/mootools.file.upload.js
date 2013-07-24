/*

name: [File.Upload, Request.File]
description: Ajax file upload with MooTools.
license: MIT-style license
author: Matthew Loberg
requires: [Request]
provides: [File.Upload, Request.File]
credits: Based off of MooTools-Form-Upload (https://github.com/arian/mootools-form-upload/) by Arian Stolwijk

 Added method File.Upload.addFormInputs (author: Roman Chertov)
*/

File.Upload = new Class({

	Implements: [Options, Events],
	
	options: {
		onComplete: function(){}
	},
	
	initialize: function(options){
		var self = this;
		this.setOptions(options);
		this.uploadReq = new Request.File({
			onComplete: function(){
				self.fireEvent('complete', arguments);
				this.reset();
			}
		});
		if(this.options.data) this.data(this.options.data);
		if(this.options.images) this.addMultiple(this.options.images);
        if(this.options.form) this.addFormInputs(this.options.form);
	},
	
	data: function(data){
		var self = this;
		if(this.options.url.indexOf('?') < 0) this.options.url += '?';
		Object.each(data, function(value, key){
			if(self.options.url.charAt(self.options.url.length - 1) != '?') self.options.url += '&';
			self.options.url += encodeURIComponent(key) + '=' + encodeURIComponent(value);
		});
	},

    addFormInputs: function(form){
        var self = this;
        $(form).getElements('input, select, textarea').each(function(el){
            var type = el.type;
            if (!el.name || el.disabled || type == 'submit' || type == 'reset' || type == 'file' || type == 'image') return;

            var value = (el.get('tag') == 'select') ? el.getSelected().map(function(opt){
                // IE
                return document.id(opt).get('value');
            }) : ((type == 'radio' || type == 'checkbox') && !el.checked) ? null : el.get('value');

            Array.from(value).each(function(val){
                if (typeof val != 'undefined') {
                    self.uploadReq.append(el.name, val);
                }
            });
        });
    },

	addMultiple: function(inputs){
		var self = this;
		inputs.each(function(input){
			self.add(input);
		});
	},
	
	add: function(input){
		var input = document.id(input),
			name = input.get('name'),
			file = input.files[0];
		this.uploadReq.append(name, file);
	},
	
	send: function(input){
		if(input) this.add(input);
		this.uploadReq.send({
			url: this.options.url
		});
	}

});

Request.File = new Class({

	Extends: Request,
	
	options: {
		emulation: false,
		urlEncoded: false
	},
	
	initialize: function(options){
		this.xhr = new Browser.Request();
		this.formData = new FormData();
		this.setOptions(options);
		this.headers = this.options.headers;
	},
	
	append: function(key, value){
		this.formData.append(key, value);
		return this.formData;
	},
	
	reset: function(){
		this.formData = new FormData();
	},
	
	send: function(options){
		var url = options.url || this.options.url;
		
		this.options.isSuccess = this.options.isSuccess || this.isSuccess;
		this.running = true;
		
		var xhr = this.xhr;
		xhr.open('POST', url, true);
		xhr.onreadystatechange = this.onStateChange.bind(this);
		
		Object.each(this.headers, function(value, key){
			try{
				xhr.setRequestHeader(key, value);
			}catch(e){
				this.fireEvent('exception', [key, value]);
			}
		}, this);
		
		this.fireEvent('request');
		xhr.send(this.formData);
		
		if(!this.options.async) this.onStateChange();
		if(this.options.timeout) this.timer = this.timeout.delay(this.options.timeout, this);
		return this;
	}

});