var iBox=function(){var _pub={close_label:"Close",inherit_frames:false,fade_in_speed:300,fade_out_speed:300,attribute_name:"rel",tags_to_hide:["select","embed","object"],default_width:450,version_number:"2.2",build_number:"1612",is_opera:navigator.userAgent.indexOf("Opera/9")!=-1,is_ie:navigator.userAgent.indexOf("MSIE ")!=-1,is_ie6:false
/*@cc_on || @_jscript_version < 5.7 @*/
,is_firefox:navigator.appName=="Netscape"&&navigator.userAgent.indexOf("Gecko")!=-1&&navigator.userAgent.indexOf("Netscape")==-1,is_mac:navigator.userAgent.indexOf("Macintosh")!=-1,base_url:"",setPath:function(path){_pub.base_url=path},checkTags:function(container,tag_name){if(!container){var container=document.body}if(!tag_name){var tag_name="a"}var els=container.getElementsByTagName(tag_name);for(var i=0;i<els.length;i++){if(els[i].getAttribute(_pub.attribute_name)){var t=els[i].getAttribute(_pub.attribute_name);if((t.indexOf("ibox")!=-1)||t.toLowerCase()=="ibox"){els[i].onclick=_pub.handleTag}}}},bind:function(fn){var args=[];for(var n=1;n<arguments.length;n++){args.push(arguments[n])}return function(e){return fn.apply(this,[e].concat(args))}},html:function(content,params){if(content===undefined){return els.content}if(params===undefined){var params={}}if(!active.is_loaded){return }_pub.clear();_pub.updateObject(els.wrapper.style,{display:"block",visibility:"hidden",left:0,top:0,height:"",width:""});if(typeof (content)=="string"){els.content.innerHTML=content}else{els.content.appendChild(content)}var pagesize=_pub.getPageSize();if(params.can_resize===undefined){params.can_resize=true}if(params.fade_in===undefined){params.use_fade=true}if(params.fullscreen){params.width="100%";params.height="100%"}offset.container=[els.wrapper.offsetLeft*2,els.wrapper.offsetTop*2];offset.wrapper=[els.wrapper.offsetWidth-els.content.offsetWidth,els.wrapper.offsetHeight-els.content.offsetHeight];offset.wrapper[1]+=4;if(params.width){var width=params.width}else{var width=_pub.default_width}if(params.height){var height=params.height}else{els.content.style.height="100%";var height=els.content.offsetHeight+12;els.content.style.height=""}active.dimensions=[width,height];active.params=params;_pub.reposition();for(var i=0;i<_pub.tags_to_hide.length;i++){showTags(_pub.tags_to_hide[i],els.content)}els.wrapper.style.visibility="visible"},clear:function(){els.loading.style.display="none";while(els.content.firstChild){els.content.removeChild(els.content.firstChild)}},show:function(text,title,params){showInit(title,params,function(){_pub.html(text,active.params)})},showURL:function(url,title,params,obj){showInit(title,params,function(){for(var i=0;i<_pub.plugins.list.length;i++){var plugin=_pub.plugins.list[i];if(plugin.match(url)){active.plugin=plugin;plugin.render(url,active.params);break}}},obj)},hide:function(){if(active.plugin){if(active.plugin.unload){active.plugin.unload()}}active={};_pub.clear();for(var i=0;i<_pub.tags_to_hide.length;i++){showTags(_pub.tags_to_hide[i])}els.loading.style.display="none";els.wrapper.style.display="none";_pub.fade(els.overlay,_pub.getOpacity(null,els.overlay),0,_pub.fade_out_speed,function(){els.overlay.style.display="none"});_pub.fireEvent("hide")},reposition:function(){if(!active.is_loaded){return }if(els.loading.style.display!="none"){_pub.center(els.loading)}if(active.dimensions){var pagesize=_pub.getPageSize();var width=active.dimensions[0];var height=active.dimensions[1];if(height.toString().indexOf("%")!=-1){els.wrapper.style.height=(Math.max(document.documentElement.clientHeight,document.body.clientHeight,pagesize.height)-offset.container[0])*(parseInt(height)/100)+"px"}else{if(height){els.content.style.height=height+"px";els.wrapper.style.height=els.content.offsetHeight+offset.wrapper[1]+"px"}else{els.wrapper.style.height=els.content.offsetHeight+offset.wrapper[1]+"px"}}var container_offset=(els.content.offsetHeight-els.content.firstChild.offsetHeight);if(width.toString().indexOf("%")!=-1){els.wrapper.style.width=(Math.max(document.documentElement.clientWidth,document.body.clientWidth,pagesize.width)-offset.container[1])*(parseInt(width)/100)+"px";var container_offset=0}else{els.content.style.width=width+"px";els.wrapper.style.width=els.content.offsetWidth+offset.wrapper[0]+"px"}_pub.updateObject(els.content.style,{width:"",height:""});var width=parseInt(els.wrapper.style.width);var height=parseInt(els.wrapper.style.height);if(active.params.can_resize){var x=pagesize.width;var y=pagesize.height;x-=offset.container[0];y-=offset.container[1];if(width>x){if(active.params.constrain){height=height*(x/width)}width=x}if(height>y){if(active.params.constrain){width=width*(y/height)}height=y}_pub.updateObject(els.wrapper.style,{width:width+"px",height:height+"px"})}els.content.style.height=height-offset.wrapper[1]+"px";if(active.dimensions!=["100%","100%"]){_pub.center(els.wrapper)}}els.overlay.style.height=Math.max(document.body.clientHeight,document.documentElement.clientHeight)+"px"},updateObject:function(obj,params){for(var i in params){obj[i]=params[i]}},center:function(obj){if(active.params){if(active.params.relative){if(active.event_obj){var offset=$(active.event_obj).offset();var y=offset.top+Math.round(active.params.rtop ? active.params.rtop : 0);var x=offset.left+Math.round(active.params.rleft ? active.params.rleft : 0);_pub.updateObject(obj.style,{top:y+"px",left:x+"px"});return;}}}var pageSize=_pub.getPageSize();var scrollPos=_pub.getScrollPos();var emSize=_pub.getElementSize(obj);var x=Math.round((pageSize.width-emSize.width)/2+scrollPos.scrollX);var y=Math.round((pageSize.height-emSize.height)/2+scrollPos.scrollY);if(obj.offsetLeft){x-=obj.offsetLeft}if(obj.offsetTop){y-=obj.offsetTop}if(obj.style.left){x+=parseInt(obj.style.left)}if(obj.style.top){y+=parseInt(obj.style.top)}x-=10;_pub.updateObject(obj.style,{top:y+"px",left:x+"px"})},getStyle:function(obj,styleProp){if(obj.currentStyle){return obj.currentStyle[styleProp]}else{if(window.getComputedStyle){return document.defaultView.getComputedStyle(obj,null).getPropertyValue(styleProp)}}},getScrollPos:function(){var docElem=document.documentElement;return{scrollX:document.body.scrollLeft||window.pageXOffset||(docElem&&docElem.scrollLeft),scrollY:document.body.scrollTop||window.pageYOffset||(docElem&&docElem.scrollTop)}},getPageSize:function(){return{width:window.innerWidth||(document.documentElement&&document.documentElement.clientWidth)||document.body.clientWidth,height:window.innerHeight||(document.documentElement&&document.documentElement.clientHeight)||document.body.clientHeight}},getElementSize:function(obj){return{width:obj.offsetWidth||obj.style.pixelWidth,height:obj.offsetHeight||obj.style.pixelHeight}},fade:function(obj,start,end,speed,callback){if(start===undefined||!(start>=0)||!(start<=100)){var start=0}if(end===undefined||!(end>=0)||!(end<=100)){var end=100}if(speed===undefined){var speed=0}if(obj.fader){clearInterval(obj.fader)}if(!speed){_pub.setOpacity(null,obj,end);if(callback){callback()}}var opacity_difference=end-start;var time_total=speed;var step_size=25;var steps=time_total/step_size;var increment=Math.ceil(opacity_difference/steps);obj.fader=setInterval(_pub.bind(function(e,obj,increment,end,callback){var opacity=_pub.getOpacity(e,obj)+increment;_pub.setOpacity(e,obj,opacity);if((increment<0&&opacity<=end)||(increment>0&&opacity>=end)){_pub.setOpacity(e,obj,end);clearInterval(obj.fader);if(callback){callback()}}},obj,increment,end,callback),step_size)},setOpacity:function(e,obj,value){value=Math.round(value);obj.style.opacity=value/100;obj.style.filter="alpha(opacity="+value+")"},getOpacity:function(e,obj){return _pub.getStyle(obj,"opacity")*100},createXMLHttpRequest:function(){var http;if(window.XMLHttpRequest){http=new XMLHttpRequest();if(http.overrideMimeType){http.overrideMimeType("text/html")}}else{if(window.ActiveXObject){try{http=new ActiveXObject("Msxml2.XMLHTTP")}catch(e){try{http=new ActiveXObject("Microsoft.XMLHTTP")}catch(e){}}}}if(!http){alert("Cannot create XMLHTTP instance");return false}return http},addEvent:function(obj,evType,fn){if(obj.addEventListener){obj.addEventListener(evType,fn,false);return true}else{if(obj.attachEvent){var r=obj.attachEvent("on"+evType,fn);return r}else{return false}}},addEventListener:function(name,callback){if(!events[name]){events[name]=new Array()}events[name].push(callback)},fireEvent:function(name){if(events[name]&&events[name].length){for(var i=0;i<events[name].length;i++){var args=[];for(var n=1;n<arguments.length;n++){args.push(arguments[n])}if(events[name][i](args)===false){break}}}},parseQuery:function(query){var params=new Object();if(!query){return params}var pairs=query.split(/[;&]/);var end_token;for(var i=0;i<pairs.length;i++){var keyval=pairs[i].split("=");if(!keyval||keyval.length!=2){continue}var key=unescape(keyval[0]);var val=unescape(keyval[1]);val=val.replace(/\+/g," ");if(val[0]=='"'){var token='"'}else{if(val[0]=="'"){var token="'"}else{var token=null}}if(token){if(val[val.length-1]!=token){do{i+=1;val+="&"+pairs[i]}while((end_token=pairs[i][pairs[i].length-1])!=token)}val=val.substr(1,val.length-2)}if(val=="true"){val=true}else{if(val=="false"){val=false}else{if(val=="null"){val=null}}}params[key]=val}return params},handleTag:function(e){var t=this.getAttribute("rel");var params=_pub.parseQuery(t.substr(5,999));if(params.target){var url=params.target}else{if(this.target&&!params.ignore_target){var url=this.target}else{var url=this.href}}var title=this.title;if(_pub.inherit_frames&&window.parent){window.parent.iBox.showURL(url,title,params,this)}else{_pub.showURL(url,title,params,this)}return false},plugins:{list:new Array(),register:function(func,last){if(last===undefined){var last=false}if(!last){_pub.plugins.list=[func].concat(_pub.plugins.list)}else{_pub.plugins.list.push(func)}}}};var active={};var events={};var els={};var offset={};var create=function(elem){pagesize=_pub.getPageSize();els.container=document.createElement("div");els.container.id="ibox";els.overlay=document.createElement("div");els.overlay.style.display="none";_pub.setOpacity(null,els.overlay,0);if(!_pub.is_firefox){els.overlay.style.background="#000000"}else{els.overlay.style.backgroundImage="url('"+_pub.base_url+"images/bg.png')"}els.overlay.id="ibox_overlay";params={position:"absolute",top:0,left:0,width:"100%"};_pub.updateObject(els.overlay.style,params);els.overlay.onclick=_pub.hide;els.container.appendChild(els.overlay);els.loading=document.createElement("div");els.loading.id="ibox_loading";els.loading.innerHTML="Loading...";els.loading.style.display="none";els.loading.onclick=_pub.hide;els.container.appendChild(els.loading);els.wrapper=document.createElement("div");els.wrapper.id="ibox_wrapper";_pub.updateObject(els.wrapper.style,{position:"absolute",top:0,left:0,display:"none"});els.content=document.createElement("div");els.content.id="ibox_content";_pub.updateObject(els.content.style,{overflow:"auto"});els.wrapper.appendChild(els.content);var child=document.createElement("div");child.id="ibox_footer_wrapper";var child2=document.createElement("a");child2.innerHTML=_pub.close_label;child2.href="javascript:void(0)";child2.onclick=_pub.hide;child.appendChild(child2);els.footer=document.createElement("div");els.footer.id="ibox_footer";els.footer.innerHTML="&nbsp;";child.appendChild(els.footer);els.wrapper.appendChild(child);els.container.appendChild(els.wrapper);elem.appendChild(els.container);_pub.updateObject(els.wrapper.style,{right:"",bottom:""});return els.container};var hideTags=function(tag,container){if(container===undefined){var container=document.body}var list=container.getElementsByTagName(tag);for(var i=0;i<list.length;i++){if(_pub.getStyle(list[i],"visibility")!="hidden"&&list[i].style.display!="none"){list[i].style.visibility="hidden";list[i].wasHidden=true}}};var showTags=function(tag,container){if(container===undefined){var container=document.body}var list=container.getElementsByTagName(tag);for(var i=0;i<list.length;i++){if(list[i].wasHidden){list[i].style.visibility="visible";list[i].wasHidden=null}}};var showInit=function(title,params,callback,obj){if(!_initialized){initialize()}if(params===undefined){var params={}}if(active.plugin){_pub.hide()}if(obj){active.event_obj=obj;}active.is_loaded=true;active.params=params;els.loading.style.display="block";_pub.center(els.loading);_pub.reposition();for(var i=0;i<_pub.tags_to_hide.length;i++){hideTags(_pub.tags_to_hide[i])}els.footer.innerHTML=title||"&nbsp;";els.overlay.style.display="block";if(!_pub.is_firefox){var amount=70}else{var amount=100}_pub.fade(els.overlay,_pub.getOpacity(null,els.overlay),amount,_pub.fade_in_speed,callback);_pub.fireEvent("show")};var drawCSS=function(){var core_styles="#ibox {z-index:1000000;text-align:left;} #ibox_overlay {z-index:1000000;} #ibox_loading {position:absolute;z-index:1000001;} #ibox_wrapper {margin:30px;position:absolute;top:0;left:0;z-index:1000001;} #ibox_content {z-index:1000002;margin:27px 5px 5px 5px;padding:2px;} #ibox_content object {display:block;} #ibox_content .ibox_image {width:100%;height:100%;margin:0;padding:0;border:0;display:block;} #ibox_footer_wrapper a {float:right;display:block;outline:0;margin:0;padding:0;} #ibox_footer_wrapper {text-align:left;position:absolute;top:5px;right:5px;left:5px;white-space:nowrap;overflow:hidden;}";var default_skin="#ibox_footer_wrapper {font-weight:bold;height:20px;line-height:20px;} #ibox_footer_wrapper a {line-height:16px;padding:0 5px;font-weight:normal;font-size:80%;} #ibox_content {background-color:#eee;border:1px solid #666;} #ibox_loading {padding:50px; background:#000;color:#fff;font-size:16px;font-weight:bold;}";var head=document.getElementsByTagName("head")[0];var htmDiv=document.createElement("div");htmDiv.innerHTML='<p>x</p><style type="text/css">'+default_skin+"</style>";head.insertBefore(htmDiv.childNodes[1],head.firstChild);htmDiv.innerHTML='<p>x</p><style type="text/css">'+core_styles+"</style>";head.insertBefore(htmDiv.childNodes[1],head.firstChild)};var _initialized=false;var initialize=function(){if(_initialized){return }_initialized=true;drawCSS();var els=document.getElementsByTagName("script");var src;for(var i=0,el=null;(el=els[i]);i++){if(!(src=el.getAttribute("src"))){continue}src=src.split("?")[0];if(src.substr(src.length-8)=="/ibox.js"){_pub.setPath(src.substr(0,src.length-7));break}}create(document.body);_pub.checkTags(document.body,"a");_pub.http=_pub.createXMLHttpRequest();_pub.fireEvent("load")};_pub.addEvent(window,"keypress",function(e){if(e.keyCode==(window.event?27:e.DOM_VK_ESCAPE)){iBox.hide()}});_pub.addEvent(window,"resize",_pub.reposition);_pub.addEvent(window,"load",initialize);_pub.addEvent(window,"scroll",_pub.reposition);var iBoxPlugin_Container=function(){var was_error=false;var original_wrapper=null;return{match:function(url){return url.indexOf("#")!=-1},unload:function(){if(was_error){return }var elemSrc=_pub.html().firstChild;if(elemSrc){elemSrc.style.display="none";original_wrapper.appendChild(elemSrc)}},render:function(url,params){was_error=false;var elemSrcId=url.substr(url.indexOf("#")+1);var elemSrc=document.getElementById(elemSrcId);if(!elemSrc){was_error=true;_pub.html(document.createTextNode("There was an error loading the document."),params)}else{original_wrapper=elemSrc.parentNode;elemSrc.style.display="block";_pub.html(elemSrc,params)}}}}();_pub.plugins.register(iBoxPlugin_Container,true);var iBoxPlugin_Image=function(){var image_types=/\.jpg|\.jpeg|\.png|\.gif/gi;return{match:function(url){return url.match(image_types)},render:function(url,params){var img=document.createElement("img");img.onclick=_pub.hide;img.className="ibox_image";img.style.cursor="pointer";img.onload=function(){_pub.html(img,{width:this.width,height:this.height,constrain:true})};img.onerror=function(){_pub.html(document.createTextNode("There was an error loading the document."),params)};img.src=url}}}();_pub.plugins.register(iBoxPlugin_Image);var iBoxPlugin_YouTube=function(){var youtube_url=/(?:http:\/\/)?(?:www\d*\.)?(youtube\.(?:[a-z]+))\/(?:v\/|(?:watch(?:\.php)?)?\?(?:.+&)?v=)([^&]+).*/;return{match:function(url){return url.match(youtube_url)},render:function(url,params){var _match=url.match(youtube_url);var domain=_match[1];var id=_match[2];params.width=425;params.height=355;params.constrain=true;var html='<span><object width="100%" height="100%" style="overflow: hidden; display: block;"><param name="movie" value="http://www.'+domain+"/v/"+id+'"/><param name="wmode" value="transparent"/><embed src="http://www.'+domain+"/v/"+id+'" type="application/x-shockwave-flash" wmode="transparent" width="100%" height="100%"></embed></object></span>';_pub.html(html,params)}}}();_pub.plugins.register(iBoxPlugin_YouTube);var iBoxPlugin_Document=function(){return{match:function(url){return true},render:function(url,params){_pub.http.open("get",url,true);_pub.http.onreadystatechange=function(){if(_pub.http.readyState==4){if(_pub.http.status==200||_pub.http.status==0){_pub.html(_pub.http.responseText,params)}else{_pub.html(document.createTextNode("There was an error loading the document."),params)}}};_pub.http.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");try{_pub.http.send(null)}catch(ex){_pub.html(document.createTextNode("There was an error loading the document."),params)}}}}();_pub.plugins.register(iBoxPlugin_Document,true);return _pub}();