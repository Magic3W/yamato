depend(["m3/core/collection"],function(f){function g(a,b,d){this.element=a;this.name=b;this.value=d;this.adapters=this.makeAdapters();this.view=void 0;this.setData=function(c){for(var e=0;e<this.adapters.length;e++)this.adapters[e].setValue(c[this.adapters[e].getName()])};this.replace=function(){for(var c="",e=0;e<this.adapters.length;e++)c+=this.adapters[e].replace();return c}}function h(a,b){var d=null;this.setValue=function(c){d=c};this.getValue=function(){return d};this.getName=function(){return-1!==
a.indexOf("?")?a.substr(0,a.indexOf("?")):a};this.isReadOnly=function(){return b};this.replace=function(){if(b)return a;if(-1!==a.indexOf("?")){var c=a.substr(a.indexOf("?")+1).split(":");return d?c[0]:c[1]}return d}}g.prototype={hasLysine:function(){return-1!==this.name.search(/^data-lysine-/)},getAttributeName:function(){return this.name.replace(/^data-lysine-/,"").toLowerCase()},makeAdapters:function(){if(!this.hasLysine())return[];for(var a=/\{\{([A-Za-z0-9\.\s\?\-:_]+)\}\}/g,b=[],d=this.value.split(/\{\{[A-Za-z0-9\.\s\?\-:_]+\}\}/g),
c=a.exec(this.value);c;)b.push(new h(d.shift(),!0)),b.push(new h(c[1],!1)),c=a.exec(this.value);0<d.length&&b.push(new h(d.shift(),!0));return b},for:function(){var a=f([]);f(this.adapters).each(function(b){b.isReadOnly()||a.push(b.getName())});return a.raw()},parent:function(a){this.view=a;return this},refresh:function(){var a=this;f(this.adapters).each(function(b){b.isReadOnly()||b.setValue(a.view.get(b.getName()))});this.element.setAttribute(this.getAttributeName(),this.replace())}};return{AttributeAdapter:g,
find:function(a){var b=a.attributes,d,c=f([]);if(!b)return c;for(d=0;d<b.length;d++)c.push(new g(a,b[d].name,b[d].value));return c.filter(function(e){return e.hasLysine()})}}});
