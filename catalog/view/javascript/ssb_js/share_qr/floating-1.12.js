var floatingMenu={hasInner:"number"==typeof window.innerWidth,hasElement:"object"==typeof document.documentElement&&"number"==typeof document.documentElement.clientWidth},floatingArray=[];
floatingMenu.add=function(a,b){var c,d;"string"===typeof a?c=a:d=a;void 0==b?floatingArray.push({id:c,menu:d,targetLeft:0,targetTop:0,distance:0.07,snap:!0,updateParentHeight:!1}):floatingArray.push({id:c,menu:d,targetLeft:b.targetLeft,targetRight:b.targetRight,targetTop:b.targetTop,targetBottom:b.targetBottom,centerX:b.centerX,centerY:b.centerY,prohibitXMovement:b.prohibitXMovement,prohibitYMovement:b.prohibitYMovement,distance:void 0!=b.distance?b.distance:0.07,snap:b.snap,ignoreParentDimensions:b.ignoreParentDimensions,
updateParentHeight:void 0==b.updateParentHeight?!1:b.updateParentHeight,scrollContainer:b.scrollContainer,scrollContainerId:b.scrollContainerId,confinementArea:b.confinementArea,confinementAreaId:void 0!=b.confinementArea&&"#"==b.confinementArea.substring(0,1)?b.confinementArea.substring(1):void 0,confinementAreaClassRegexp:void 0!=b.confinementArea&&"."==b.confinementArea.substring(0,1)?RegExp("(^|\\s)"+b.confinementArea.substring(1)+"(\\s|$)"):void 0})};
floatingMenu.findSingle=function(a){a.id&&(a.menu=document.getElementById(a.id));a.scrollContainerId&&(a.scrollContainer=document.getElementById(a.scrollContainerId))};floatingMenu.move=function(a){a.prohibitXMovement||(a.menu.style.left=a.nextX+"px",a.menu.style.right="");a.prohibitYMovement||(a.menu.style.top=a.nextY+"px",a.menu.style.bottom="")};
floatingMenu.scrollLeft=function(a){if(a.scrollContainer)return a.scrollContainer.scrollLeft;a=window.top;return this.hasInner?a.pageXOffset:this.hasElement?a.document.documentElement.scrollLeft:a.document.body.scrollLeft};floatingMenu.scrollTop=function(a){if(a.scrollContainer)return a.scrollContainer.scrollTop;a=window.top;return this.hasInner?a.pageYOffset:this.hasElement?a.document.documentElement.scrollTop:a.document.body.scrollTop};
floatingMenu.windowWidth=function(){return this.hasElement?document.documentElement.clientWidth:document.body.clientWidth};floatingMenu.windowHeight=function(){return floatingMenu.hasElement&&floatingMenu.hasInner?document.documentElement.clientHeight>window.innerHeight?window.innerHeight:document.documentElement.clientHeight:floatingMenu.hasElement?document.documentElement.clientHeight:document.body.clientHeight};
floatingMenu.documentHeight=function(){var a=document.body,b=document.documentElement;return Math.max(a.scrollHeight,a.offsetHeight,b.clientHeight,b.scrollHeight,b.offsetHeight,this.hasInner?window.innerHeight:0)};floatingMenu.documentWidth=function(){var a=document.body,b=document.documentElement;return Math.max(a.scrollWidth,a.offsetWidth,b.clientWidth,b.scrollWidth,b.offsetWidth,this.hasInner?window.innerWidth:0)};
floatingMenu.calculateCornerX=function(a){var b=a.menu.offsetWidth,c=this.scrollLeft(a)-a.parentLeft,c=a.centerX?c+(this.windowWidth()-b)/2:void 0==a.targetLeft?c+(this.windowWidth()-a.targetRight-b):c+a.targetLeft;document.body!=a.menu.parentNode&&c+b>=a.confinedWidthReserve&&(c=a.confinedWidthReserve-b);0>c&&(c=0);return c};
floatingMenu.calculateCornerY=function(a){var b=a.menu.offsetHeight,c=this.scrollTop(a)-a.parentTop,c=a.centerY?c+(this.windowHeight()-b)/2:void 0===a.targetTop?c+(this.windowHeight()-a.targetBottom-b):c+a.targetTop;document.body!=a.menu.parentNode&&c+b>=a.confinedHeightReserve&&(c=a.confinedHeightReserve-b);0>c&&(c=0);return c};floatingMenu.isConfinementArea=function(a,b){return void 0!=a.confinementAreaId&&b.id==a.confinementAreaId||void 0!=a.confinementAreaClassRegexp&&b.className&&a.confinementAreaClassRegexp.test(b.className)};
floatingMenu.computeParent=function(a){if(a.ignoreParentDimensions)a.confinedHeightReserve=this.documentHeight(),a.confinedWidthReserver=this.documentWidth(),a.parentLeft=0,a.parentTop=0;else{var b=a.menu.parentNode,c=this.offsets(b,a);a.parentLeft=c.left;a.parentTop=c.top;a.confinedWidthReserve=b.clientWidth;var d=this.offsets(b,a);if(void 0==a.confinementArea)for(;b.clientHeight+d.top<a.menu.scrollHeight+c.top||a.menu.parentNode==b&&a.updateParentHeight&&b.clientHeight+d.top==a.menu.scrollHeight+
c.top;)b=b.parentNode,d=this.offsets(b,a);else for(;void 0!=b.parentNode&&!this.isConfinementArea(a,b);)b=b.parentNode,d=this.offsets(b,a);a.confinedHeightReserve=b.clientHeight-(c.top-d.top)}};
floatingMenu.offsets=function(a,b){var c={left:0,top:0};if(a!==b.scrollContainer){for(;a.offsetParent&&a.offsetParent!=b.scrollContainer;)c.left+=a.offsetLeft,c.top+=a.offsetTop,a=a.offsetParent;if(window==window.top)return c;for(var d=window.top.document.body.getElementsByTagName("IFRAME"),e=0;e<d.length;e++)if(d[e].contentWindow==window)for(a=d[e];a.offsetParent;)c.left+=a.offsetLeft,c.top+=a.offsetTop,a=a.offsetParent;return c}};
floatingMenu.doFloatSingle=function(a){this.findSingle(a);a.updateParentHeight&&(a.menu.parentNode.style.minHeight=a.menu.scrollHeight+"px");var b,c;this.computeParent(a);c=this.calculateCornerX(a);b=(c-a.nextX)*a.distance;if(0.5>Math.abs(b)&&a.snap||1>=Math.abs(c-a.nextX))b=c-a.nextX;var d=this.calculateCornerY(a);c=(d-a.nextY)*a.distance;if(0.5>Math.abs(c)&&a.snap||1>=Math.abs(d-a.nextY))c=d-a.nextY;if(0<Math.abs(b)||0<Math.abs(c))a.nextX+=b,a.nextY+=c,this.move(a)};floatingMenu.fixTargets=function(){};
floatingMenu.fixTarget=function(a){};floatingMenu.doFloat=function(){this.fixTargets();for(var a=0;a<floatingArray.length;a++)this.fixTarget(floatingArray[a]),this.doFloatSingle(floatingArray[a]);setTimeout("floatingMenu.doFloat()",20)};floatingMenu.insertEvent=function(a,b,c){if(void 0!=a.addEventListener)a.addEventListener(b,c,!1);else if(b="on"+b,void 0!=a.attachEvent)a.attachEvent(b,c);else{var d=a[b];a[b]=function(a){a=a?a:window.event;var b=c(a);return void 0!=d&&!0==d(a)&&!0==b}}};
floatingMenu.init=function(){floatingMenu.fixTargets();for(var a=0;a<floatingArray.length;a++)floatingMenu.initSingleMenu(floatingArray[a]);setTimeout("floatingMenu.doFloat()",100)};floatingMenu.initSingleMenu=function(a){this.findSingle(a);this.computeParent(a);this.fixTarget(a);a.nextX=this.calculateCornerX(a);a.nextY=this.calculateCornerY(a);this.move(a)};floatingMenu.insertEvent(window,"load",floatingMenu.init);
"undefined"!==typeof jQuery&&function(a){a.fn.addFloating=function(a){return this.each(function(){floatingMenu.add(this,a)})}}(jQuery);