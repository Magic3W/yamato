depend(["m3/hid/gestures/swipe","m3/hid/gestures/pinch"],function(e,f){var d=function(a,g){this.element=a;this.blocked=!1;this._end=this._follow=this._init=this.meta=this.started=void 0;var c=this;switch(g){case "swipe":this.backend=e;break;case "pinch":this.backend=f;break;default:throw"Unsupported manipulator";}c=this;a.addEventListener("touchstart",function(b){c.start(b)});a.addEventListener("touchmove",function(b){c.move(b)});a.addEventListener("touchend",function(b){c.terminate(b)});window.visualViewport&&
window.visualViewport.addEventListener("resize",function(b){c.blocked=1!==event.target.scale})};d.prototype={start:function(a){this.blocked||(a.touches.length!==this.backend.fingers?(this.started=void 0,this.backend.end(this.meta,a.touches)):(this.meta=this.backend.start(a.touches),a.stopPropagation(),a.preventDefault(),this.started=+new Date,this._init&&this._init(this.meta)))},move:function(a){this.blocked||+new Date-this.started<this.backend.duration||(this.meta=this.backend.update(this.meta,a.touches),
this._follow&&this._follow(this.meta,function(){a.stopPropagation();a.preventDefault()}))},terminate:function(a){this.blocked||+new Date-this.started<this.backend.duration||(this.meta=this.backend.end(this.meta,a.touches),this._end&&this._end(this.meta,function(){a.stopPropagation();a.preventDefault()}),this.started=this.meta=void 0)},init:function(a){this._init=a},follow:function(a){this._follow=a},end:function(a){this._end=a}};return d});
