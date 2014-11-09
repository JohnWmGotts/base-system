window.Modernizr=(function(H,o,L){var u="2.6.2",h={},w=true,C=o.documentElement,F="modernizr",E=o.createElement(F),e=E.style,s=o.createElement("input"),J=":)",t={}.toString,x=" -webkit- -moz- -o- -ms- ".split(" "),d="Webkit Moz O ms",M=d.split(" "),f=d.toLowerCase().split(" "),b={svg:"http://www.w3.org/2000/svg"},m={},v={},A={},j=[],B=j.slice,q,k=function(X,U,Q,R){var S,V,N,P,O=o.createElement("div"),W=o.body,T=W||o.createElement("body");if(parseInt(Q,10)){while(Q--){N=o.createElement("div");N.id=R?R[Q]:F+(Q+1);O.appendChild(N)}}S=["­",'<style id="s',F,'">',X,"</style>"].join("");O.id=F;(W?O:T).innerHTML+=S;T.appendChild(O);if(!W){T.style.background="";T.style.overflow="hidden";P=C.style.overflow;C.style.overflow="hidden";C.appendChild(T)}V=U(O,X);if(!W){T.parentNode.removeChild(T);C.style.overflow=P}else{O.parentNode.removeChild(O)}return !!V},l=function(O){var P=H.matchMedia||H.msMatchMedia;if(P){return P(O).matches}var N;k("@media "+O+" { #"+F+" { position: absolute; } }",function(Q){N=(H.getComputedStyle?getComputedStyle(Q,null):Q.currentStyle)["position"]=="absolute"});return N},g=(function(){var O={select:"input",change:"input",submit:"form",reset:"form",error:"img",load:"img",abort:"img"};function N(P,Q){Q=Q||o.createElement(O[P]||"div");P="on"+P;var R=P in Q;if(!R){if(!Q.setAttribute){Q=o.createElement("div")}if(Q.setAttribute&&Q.removeAttribute){Q.setAttribute(P,"");R=a(Q[P],"function");if(!a(Q[P],"undefined")){Q[P]=L}Q.removeAttribute(P)}}Q=null;return R}return N})(),K=({}).hasOwnProperty,p;if(!a(K,"undefined")&&!a(K.call,"undefined")){p=function(O,N){return K.call(O,N)}}else{p=function(O,N){return((N in O)&&a(O.constructor.prototype[N],"undefined"))}}if(!Function.prototype.bind){Function.prototype.bind=function D(O){var P=this;if(typeof P!="function"){throw new TypeError()}var Q=B.call(arguments,1),N=function(){if(this instanceof N){var S=function(){};S.prototype=P.prototype;var T=new S();var R=P.apply(T,Q.concat(B.call(arguments)));if(Object(R)===R){return R}return T}else{return P.apply(O,Q.concat(B.call(arguments)))}};return N}}function r(N){e.cssText=N}function i(N,O){return r(x.join(N+";")+(O||""))}function a(O,N){return typeof O===N}function y(O,N){return !!~(""+O).indexOf(N)}function c(Q,O){for(var N in Q){var P=Q[N];if(!y(P,"-")&&e[P]!==L){return O=="pfx"?P:true}}return false}function n(R,Q,O){for(var P in R){var N=Q[R[P]];if(N!==L){if(O===false){return R[P]}if(a(N,"function")){return N.bind(O||Q)}return N}}return false}function G(N,P,Q){var O=N.charAt(0).toUpperCase()+N.slice(1),R=(N+" "+M.join(O+" ")+O).split(" ");if(a(P,"string")||a(P,"undefined")){return c(R,P)}else{R=(N+" "+(f).join(O+" ")+O).split(" ");return n(R,P,Q)}}m.flexbox=function(){return G("flexWrap")};m.flexboxlegacy=function(){return G("boxDirection")};m.canvas=function(){var N=o.createElement("canvas");return !!(N.getContext&&N.getContext("2d"))};m.canvastext=function(){return !!(h.canvas&&a(o.createElement("canvas").getContext("2d").fillText,"function"))};m.webgl=function(){return !!H.WebGLRenderingContext};m.touch=function(){var N;if(("ontouchstart" in H)||H.DocumentTouch&&o instanceof DocumentTouch){N=true}else{k(["@media (",x.join("touch-enabled),("),F,")","{#modernizr{top:9px;position:absolute}}"].join(""),function(O){N=O.offsetTop===9})}return N};m.geolocation=function(){return"geolocation" in navigator};m.postmessage=function(){return !!H.postMessage};m.websqldatabase=function(){return !!H.openDatabase};m.indexedDB=function(){return !!G("indexedDB",H)};m.hashchange=function(){return g("hashchange",H)&&(o.documentMode===L||o.documentMode>7)};m.history=function(){return !!(H.history&&history.pushState)};m.draganddrop=function(){var N=o.createElement("div");return("draggable" in N)||("ondragstart" in N&&"ondrop" in N)};m.websockets=function(){return"WebSocket" in H||"MozWebSocket" in H};m.rgba=function(){r("background-color:rgba(150,255,150,.5)");return y(e.backgroundColor,"rgba")};m.hsla=function(){r("background-color:hsla(120,40%,100%,.5)");return y(e.backgroundColor,"rgba")||y(e.backgroundColor,"hsla")};m.multiplebgs=function(){r("background:url(https://),url(https://),red url(https://)");return(/(url\s*\(.*?){3}/).test(e.background)};m.backgroundsize=function(){return G("backgroundSize")};m.borderimage=function(){return G("borderImage")};m.borderradius=function(){return G("borderRadius")};m.boxshadow=function(){return G("boxShadow")};m.textshadow=function(){return o.createElement("div").style.textShadow===""};m.opacity=function(){i("opacity:.55");return(/^0.55$/).test(e.opacity)};m.cssanimations=function(){return G("animationName")};m.csscolumns=function(){return G("columnCount")};m.cssgradients=function(){var P="background-image:",O="gradient(linear,left top,right bottom,from(#9f9),to(white));",N="linear-gradient(left top,#9f9, white);";r((P+"-webkit- ".split(" ").join(O+P)+x.join(N+P)).slice(0,-P.length));return y(e.backgroundImage,"gradient")};m.cssreflections=function(){return G("boxReflect")};m.csstransforms=function(){return !!G("transform")};m.csstransforms3d=function(){var N=!!G("perspective");if(N&&"webkitPerspective" in C.style){k("@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}",function(O,P){N=O.offsetLeft===9&&O.offsetHeight===3})}return N};m.csstransitions=function(){return G("transition")};m.fontface=function(){var N;k('@font-face {font-family:"font";src:url("https://")}',function(R,O){var P=o.getElementById("smodernizr"),S=P.sheet||P.styleSheet,Q=S?(S.cssRules&&S.cssRules[0]?S.cssRules[0].cssText:S.cssText||""):"";N=/src/i.test(Q)&&Q.indexOf(O.split(" ")[0])===0});return N};m.generatedcontent=function(){var N;k(["#",F,"{font:0/0 a}#",F,':after{content:"',J,'";visibility:hidden;font:3px/1 a}'].join(""),function(O){N=O.offsetHeight>=3});return N};m.video=function(){var O=o.createElement("video"),P=false;try{if(P=!!O.canPlayType){P=new Boolean(P);P.ogg=O.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,"");P.h264=O.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,"");P.webm=O.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,"")}}catch(N){}return P};m.audio=function(){var O=o.createElement("audio"),P=false;try{if(P=!!O.canPlayType){P=new Boolean(P);P.ogg=O.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,"");P.mp3=O.canPlayType("audio/mpeg;").replace(/^no$/,"");P.wav=O.canPlayType('audio/wav; codecs="1"').replace(/^no$/,"");P.m4a=(O.canPlayType("audio/x-m4a;")||O.canPlayType("audio/aac;")).replace(/^no$/,"")}}catch(N){}return P};m.localstorage=function(){try{localStorage.setItem(F,F);localStorage.removeItem(F);return true}catch(N){return false}};m.sessionstorage=function(){try{sessionStorage.setItem(F,F);sessionStorage.removeItem(F);return true}catch(N){return false}};m.webworkers=function(){return !!H.Worker};m.applicationcache=function(){return !!H.applicationCache};m.svg=function(){return !!o.createElementNS&&!!o.createElementNS(b.svg,"svg").createSVGRect};m.inlinesvg=function(){var N=o.createElement("div");N.innerHTML="<svg/>";return(N.firstChild&&N.firstChild.namespaceURI)==b.svg};m.smil=function(){return !!o.createElementNS&&/SVGAnimate/.test(t.call(o.createElementNS(b.svg,"animate")))};m.svgclippaths=function(){return !!o.createElementNS&&/SVGClipPath/.test(t.call(o.createElementNS(b.svg,"clipPath")))};function z(){h.input=(function(P){for(var O=0,N=P.length;O<N;O++){A[P[O]]=!!(P[O] in s)}if(A.list){A.list=!!(o.createElement("datalist")&&H.HTMLDataListElement)}return A})("autocomplete autofocus list placeholder max min multiple pattern required step".split(" "));h.inputtypes=(function(O){for(var Q=0,P,R,N,S=O.length;Q<S;Q++){s.setAttribute("type",R=O[Q]);P=s.type!=="text";if(P){s.value=J;s.style.cssText="position:absolute;visibility:hidden;";if(/^range$/.test(R)&&s.style.WebkitAppearance!==L){C.appendChild(s);N=o.defaultView;P=N.getComputedStyle&&N.getComputedStyle(s,null).WebkitAppearance!=="textfield"&&(s.offsetHeight!==0);C.removeChild(s)}else{if(/^(search|tel)$/.test(R)){}else{if(/^(url|email)$/.test(R)){P=s.checkValidity&&s.checkValidity()===false}else{P=s.value!=J}}}}v[O[Q]]=!!P}return v})("search tel url email datetime date month week time datetime-local number range color".split(" "))}for(var I in m){if(p(m,I)){q=I.toLowerCase();h[q]=m[I]();j.push((h[q]?"":"no-")+q)}}h.input||z();h.addTest=function(O,N){if(typeof O=="object"){for(var P in O){if(p(O,P)){h.addTest(P,O[P])}}}else{O=O.toLowerCase();if(h[O]!==L){return h}N=typeof N=="function"?N():N;if(typeof w!=="undefined"&&w){C.className+=" "+(N?"":"no-")+O}h[O]=N}return h};r("");E=s=null;(function(N,ab){var R=N.html5||{};var ac=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i;var S=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i;var Q;var T="_html5shiv";var P=0;var O={};var ad;(function(){try{var ag=ab.createElement("a");ag.innerHTML="<xyz></xyz>";Q=("hidden" in ag);ad=ag.childNodes.length==1||(function(){(ab.createElement)("a");var ah=ab.createDocumentFragment();return(typeof ah.cloneNode=="undefined"||typeof ah.createDocumentFragment=="undefined"||typeof ah.createElement=="undefined")}())}catch(af){Q=true;ad=true}}());function aa(ah,ai){var af=ah.createElement("p"),ag=ah.getElementsByTagName("head")[0]||ah.documentElement;af.innerHTML="x<style>"+ai+"</style>";return ag.insertBefore(af.lastChild,ag.firstChild)}function Z(){var af=Y.elements;return typeof af=="string"?af.split(" "):af}function V(af){var ag=O[af[T]];if(!ag){ag={};P++;af[T]=P;O[P]=ag}return ag}function X(af,ag,ai){if(!ag){ag=ab}if(ad){return ag.createElement(af)}if(!ai){ai=V(ag)}var ah;if(ai.cache[af]){ah=ai.cache[af].cloneNode()}else{if(S.test(af)){ah=(ai.cache[af]=ai.createElem(af)).cloneNode()}else{ah=ai.createElem(af)}}return ah.canHaveChildren&&!ac.test(af)?ai.frag.appendChild(ah):ah}function ae(af,ag){if(!af){af=ab}if(ad){return af.createDocumentFragment()}ag=ag||V(af);var ak=ag.frag.cloneNode(),ah=0,ai=Z(),aj=ai.length;for(;ah<aj;ah++){ak.createElement(ai[ah])}return ak}function W(af,ag){if(!ag.cache){ag.cache={};ag.createElem=af.createElement;ag.createFrag=af.createDocumentFragment;ag.frag=ag.createFrag()}af.createElement=function(ah){if(!Y.shivMethods){return ag.createElem(ah)}return X(ah,af,ag)};af.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+Z().join().replace(/\w+/g,function(ah){ag.createElem(ah);ag.frag.createElement(ah);return'c("'+ah+'")'})+");return n}")(Y,ag.frag)}function U(af){if(!af){af=ab}var ag=V(af);if(Y.shivCSS&&!Q&&!ag.hasCSS){ag.hasCSS=!!aa(af,"article,aside,figcaption,figure,footer,header,hgroup,nav,section{display:block}mark{background:#FF0;color:#000}")}if(!ad){W(af,ag)}return af}var Y={elements:R.elements||"abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup mark meter nav output progress section summary time video",shivCSS:(R.shivCSS!==false),supportsUnknownElements:ad,shivMethods:(R.shivMethods!==false),type:"default",shivDocument:U,createElement:X,createDocumentFragment:ae};N.html5=Y;U(ab)}(this,o));h._version=u;h._prefixes=x;h._domPrefixes=f;h._cssomPrefixes=M;h.mq=l;h.hasEvent=g;h.testProp=function(N){return c([N])};h.testAllProps=G;h.testStyles=k;h.prefixed=function(O,P,N){if(!P){return G(O,"pfx")}else{return G(O,P,N)}};C.className=C.className.replace(/(^|\s)no-js(\s|$)/,"$1$2")+(w?" js "+j.join(" "):"");return h})(this,this.document);(function(Z,X,Y){function ac(b){return"[object Function]"==U.call(b)}function ad(b){return"string"==typeof b}function aa(){}function ab(b){return !b||"loaded"==b||"complete"==b||"uninitialized"==b}function R(){var b=J.shift();K=1,b?b.t?W(function(){("c"==b.t?C.injectCss:C.injectJs)(b.s,0,b.a,b.x,b.e,1)},0):(b(),R()):K=0}function S(h,b,n,p,m,v,s){function t(c){if(!w&&ab(x.readyState)&&(q.r=w=1,!K&&R(),x.onload=x.onreadystatechange=null,c)){"img"!=h&&W(function(){N.removeChild(x)},50);for(var a in G[b]){G[b].hasOwnProperty(a)&&G[b][a].onload()}}}var s=s||C.errorTimeout,x=X.createElement(h),w=0,g=0,q={t:n,s:b,e:m,a:v,x:s};1===G[b]&&(g=1,G[b]=[]),"object"==h?x.data=b:(x.src=b,x.type=h),x.width=x.height="0",x.onerror=x.onload=x.onreadystatechange=function(){t.call(this,g)},J.splice(p,0,q),"img"!=h&&(g||2===G[b]?(N.insertBefore(x,I?null:T),W(t,s)):G[b].push(x))}function P(i,g,h,e,j){return K=0,g=g||"j",ad(i)?S("c"==g?L:O,i,g,this.i++,h,e,j):(J.splice(this.i++,0,i),1==J.length&&R()),this}function Q(){var b=C;return b.loader={load:P,i:0},b}var V=X.documentElement,W=Z.setTimeout,T=X.getElementsByTagName("script")[0],U={}.toString,J=[],K=0,H="MozAppearance" in V.style,I=H&&!!X.createRange().compareNode,N=I?V:T.parentNode,V=Z.opera&&"[object Opera]"==U.call(Z.opera),V=!!X.attachEvent&&!V,O=H?"object":V?"script":"img",L=V?"script":O,M=Array.isArray||function(b){return"[object Array]"==U.call(b)},F=[],G={},E={timeout:function(d,c){return c.length&&(d.timeout=c[0]),d}},D,C;C=function(d){function c(j){var j=j.split("!"),h=F.length,i=j.pop(),p=j.length,i={url:i,origUrl:i,prefixes:j},q,l,o;for(l=0;l<p;l++){o=j[l].split("="),(q=E[o.shift()])&&(i=q(i,o))}for(l=0;l<h;l++){i=F[l](i)}return i}function e(b,p,l,o,r){var s=c(b),q=s.autoCallback;s.url.split(".").pop().split("?").shift(),s.bypass||(p&&(p=ac(p)?p:p[b]||p[o]||p[b.split("/").pop().split("?")[0]]),s.instead?s.instead(b,p,l,o,r):(G[s.url]?s.noexec=!0:G[s.url]=1,l.load(s.url,s.forceCSS||!s.forceJS&&"css"==s.url.split(".").pop().split("?").shift()?"c":Y,s.noexec,s.attrs,s.timeout),(ac(p)||ac(q))&&l.load(function(){Q(),p&&p(s.origUrl,r,o),q&&q(s.origUrl,r,o),G[s.url]=2})))}function k(p,g){function o(h,b){if(h){if(ad(h)){b||(q=function(){var i=[].slice.call(arguments);r.apply(this,i),v()}),e(h,q,g,0,s)}else{if(Object(h)===h){for(u in w=function(){var i=0,a;for(a in h){h.hasOwnProperty(a)&&i++}return i}(),h){h.hasOwnProperty(u)&&(!b&&!--w&&(ac(q)?q=function(){var i=[].slice.call(arguments);r.apply(this,i),v()}:q[u]=function(i){return function(){var a=[].slice.call(arguments);i&&i.apply(this,a),v()}}(r[u])),e(h[u],q,g,u,s))}}}}else{!b&&v()}}var s=!!p.test,t=p.load||p.both,q=p.callback||aa,r=q,v=p.complete||aa,w,u;o(s?p.yep:p.nope,!!t),t&&o(t)}var m,f,n=this.yepnope.loader;if(ad(d)){e(d,0,n,0)}else{if(M(d)){for(m=0;m<d.length;m++){f=d[m],ad(f)?e(f,0,n,0):M(f)?C(f):Object(f)===f&&k(f,n)}}else{Object(d)===d&&k(d,n)}}},C.addPrefix=function(d,c){E[d]=c},C.addFilter=function(b){F.push(b)},C.errorTimeout=10000,null==X.readyState&&X.addEventListener&&(X.readyState="loading",X.addEventListener("DOMContentLoaded",D=function(){X.removeEventListener("DOMContentLoaded",D,0),X.readyState="complete"},0)),Z.yepnope=Q(),Z.yepnope.executeStack=R,Z.yepnope.injectJs=function(f,b,g,h,p,m){var n=X.createElement("script"),r,q,h=h||C.errorTimeout;n.src=f;for(q in g){n.setAttribute(q,g[q])}b=m?R:b||aa,n.onreadystatechange=n.onload=function(){!r&&ab(n.readyState)&&(r=1,b(),n.onload=n.onreadystatechange=null)},W(function(){r||(r=1,b(1))},h),p?n.onload():T.parentNode.insertBefore(n,T)},Z.yepnope.injectCss=function(f,b,k,l,h,n){var l=X.createElement("link"),m,b=n?R:b||aa;l.href=f,l.rel="stylesheet",l.type="text/css";for(m in k){l.setAttribute(m,k[m])}h||(T.parentNode.insertBefore(l,T),W(b,0))}})(this,document);Modernizr.load=function(){yepnope.apply(window,[].slice.call(arguments,0))};Modernizr.addTest("adownload","download" in document.createElement("a"));Modernizr.addTest("blobconstructor",function(){try{return !!new Blob()}catch(a){return false}});Modernizr.addTest("lowbattery",function(){var b=0.2,a=Modernizr.prefixed("battery",navigator);return !!(a&&!a.charging&&a.level<=b)});Modernizr.addTest("audiodata",!!(window.Audio));Modernizr.addTest("battery",!!Modernizr.prefixed("battery",navigator));Modernizr.addTest("webaudio",!!(window.webkitAudioContext||window.AudioContext));(function(){if(!Modernizr.canvas){return false}var c=new Image(),b=document.createElement("canvas"),a=b.getContext("2d");c.onload=function(){a.drawImage(c,0,0);Modernizr.addTest("todataurljpeg",function(){return b.toDataURL("image/jpeg").indexOf("data:image/jpeg")===0});Modernizr.addTest("todataurlwebp",function(){return b.toDataURL("image/webp").indexOf("data:image/webp")===0})};c.src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACklEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg=="}());Modernizr.addTest("contenteditable","contentEditable" in document.documentElement);Modernizr.addTest("contentsecuritypolicy","SecurityPolicy" in document);Modernizr.addTest("cookies",function(){if(navigator.cookieEnabled){return true}document.cookie="cookietest=1";var a=document.cookie.indexOf("cookietest=")!=-1;document.cookie="cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";return a});Modernizr.addTest("contextmenu",("contextMenu" in document.documentElement&&"HTMLMenuItemElement" in window));Modernizr.addTest("cors",!!(window.XMLHttpRequest&&"withCredentials" in new XMLHttpRequest()));(function(){var a=document.createElement("a"),b=a.style,c="right 10px bottom 10px";Modernizr.addTest("bgpositionshorthand",function(){b.cssText="background-position: "+c+";";return(b.backgroundPosition===c)})}());Modernizr.addTest("bgpositionxy",function(){return Modernizr.testStyles("#modernizr {background-position: 3px 5px;}",function(b){var a=window.getComputedStyle?getComputedStyle(b,null):b.currentStyle;var d=(a.backgroundPositionX=="3px")||(a["background-position-x"]=="3px");var c=(a.backgroundPositionY=="5px")||(a["background-position-y"]=="5px");return d&&c})});(function(){function a(b){return(window.getComputedStyle?getComputedStyle(b,null).getPropertyValue("background"):b.currentStyle.background)}Modernizr.testStyles(" #modernizr { background-repeat: round; } ",function(b,c){Modernizr.addTest("bgrepeatround",a(b)=="round")});Modernizr.testStyles(" #modernizr { background-repeat: space; } ",function(b,c){Modernizr.addTest("bgrepeatspace",a(b)=="space")})})();Modernizr.testStyles("#modernizr{background-size:cover}",function(a){var b=window.getComputedStyle?window.getComputedStyle(a,null):a.currentStyle;Modernizr.addTest("bgsizecover",b.backgroundSize=="cover")});Modernizr.addTest("boxsizing",function(){return Modernizr.testAllProps("boxSizing")&&(document.documentMode===undefined||document.documentMode>7)});Modernizr.addTest("csscalc",function(){var a="width:";var c="calc(10px);";var b=document.createElement("div");b.style.cssText=a+Modernizr._prefixes.join(c+a);return !!b.style.length});Modernizr.addTest("cubicbezierrange",function(){var a=document.createElement("div");a.style.cssText=Modernizr._prefixes.join("transition-timing-function:cubic-bezier(1,0,0,1.1); ");return !!a.style.length});Modernizr.testStyles(" #modernizr { display: run-in; } ",function(b,a){var c=(window.getComputedStyle?getComputedStyle(b,null).getPropertyValue("display"):b.currentStyle.display);Modernizr.addTest("display-runin",c=="run-in")});Modernizr.addTest("display-table",function(){var e=window.document,f=e.documentElement,c=e.createElement("div"),a=e.createElement("div"),b=e.createElement("div"),d;c.style.cssText="display: table";a.style.cssText=b.style.cssText="display: table-cell; padding: 10px";c.appendChild(a);c.appendChild(b);f.insertBefore(c,f.firstChild);d=a.offsetLeft<b.offsetLeft;f.removeChild(c);return d});Modernizr.addTest("cssfilters",function(){var a=document.createElement("div");a.style.cssText=Modernizr._prefixes.join("filter:blur(2px); ");return !!a.style.length&&((document.documentMode===undefined||document.documentMode>9))});(function(){if(!document.body){window.console&&console.warn("document.body doesn't exist. Modernizr hyphens test needs it.");return}function a(){try{var d=document.createElement("div"),f=document.createElement("span"),h=d.style,i=0,l=0,k=false,j=document.body.firstElementChild||document.body.firstChild;d.appendChild(f);f.innerHTML="Bacon ipsum dolor sit amet jerky velit in culpa hamburger et. Laborum dolor proident, enim dolore duis commodo et strip steak. Salami anim et, veniam consectetur dolore qui tenderloin jowl velit sirloin. Et ad culpa, fatback cillum jowl ball tip ham hock nulla short ribs pariatur aute. Pig pancetta ham bresaola, ut boudin nostrud commodo flank esse cow tongue culpa. Pork belly bresaola enim pig, ea consectetur nisi. Fugiat officia turkey, ea cow jowl pariatur ullamco proident do laborum velit sausage. Magna biltong sint tri-tip commodo sed bacon, esse proident aliquip. Ullamco ham sint fugiat, velit in enim sed mollit nulla cow ut adipisicing nostrud consectetur. Proident dolore beef ribs, laborum nostrud meatball ea laboris rump cupidatat labore culpa. Shankle minim beef, velit sint cupidatat fugiat tenderloin pig et ball tip. Ut cow fatback salami, bacon ball tip et in shank strip steak bresaola. In ut pork belly sed mollit tri-tip magna culpa veniam, short ribs qui in andouille ham consequat. Dolore bacon t-bone, velit short ribs enim strip steak nulla. Voluptate labore ut, biltong swine irure jerky. Cupidatat excepteur aliquip salami dolore. Ball tip strip steak in pork dolor. Ad in esse biltong. Dolore tenderloin exercitation ad pork loin t-bone, dolore in chicken ball tip qui pig. Ut culpa tongue, sint ribeye dolore ex shank voluptate hamburger. Jowl et tempor, boudin pork chop labore ham hock drumstick consectetur tri-tip elit swine meatball chicken ground round. Proident shankle mollit dolore. Shoulder ut duis t-bone quis reprehenderit. Meatloaf dolore minim strip steak, laboris ea aute bacon beef ribs elit shank in veniam drumstick qui. Ex laboris meatball cow tongue pork belly. Ea ball tip reprehenderit pig, sed fatback boudin dolore flank aliquip laboris eu quis. Beef ribs duis beef, cow corned beef adipisicing commodo nisi deserunt exercitation. Cillum dolor t-bone spare ribs, ham hock est sirloin. Brisket irure meatloaf in, boudin pork belly sirloin ball tip. Sirloin sint irure nisi nostrud aliqua. Nostrud nulla aute, enim officia culpa ham hock. Aliqua reprehenderit dolore sunt nostrud sausage, ea boudin pork loin ut t-bone ham tempor. Tri-tip et pancetta drumstick laborum. Ham hock magna do nostrud in proident. Ex ground round fatback, venison non ribeye in.";document.body.insertBefore(d,j);h.cssText="position:absolute;top:0;left:0;width:5em;text-align:justify;text-justification:newspaper;";i=f.offsetHeight;l=f.offsetWidth;h.cssText="position:absolute;top:0;left:0;width:5em;text-align:justify;text-justification:newspaper;"+Modernizr._prefixes.join("hyphens:auto; ");k=(f.offsetHeight!=i||f.offsetWidth!=l);document.body.removeChild(d);d.removeChild(f);return k}catch(g){return false}}function c(m,h){try{var d=document.createElement("div"),g=document.createElement("span"),k=d.style,n=0,l=false,i=false,f=false,o=document.body.firstElementChild||document.body.firstChild;k.cssText="position:absolute;top:0;left:0;overflow:visible;width:1.25em;";d.appendChild(g);document.body.insertBefore(d,o);g.innerHTML="mm";n=g.offsetHeight;g.innerHTML="m"+m+"m";i=(g.offsetHeight>n);if(h){g.innerHTML="m<br />m";n=g.offsetWidth;g.innerHTML="m"+m+"m";f=(g.offsetWidth>n)}else{f=true}if(i===true&&f===true){l=true}document.body.removeChild(d);d.removeChild(g);return l}catch(j){return false}}function b(f){try{var i=document.createElement("input"),d=document.createElement("div"),g="lebowski",k=false,h,l=document.body.firstElementChild||document.body.firstChild;d.innerHTML=g+f+g;document.body.insertBefore(d,l);document.body.insertBefore(i,d);if(i.setSelectionRange){i.focus();i.setSelectionRange(0,0)}else{if(i.createTextRange){h=i.createTextRange();h.collapse(true);h.moveEnd("character",0);h.moveStart("character",0);h.select()}}if(window.find){k=window.find(g+g)}else{try{h=window.self.document.body.createTextRange();k=h.findText(g+g)}catch(j){k=false}}document.body.removeChild(d);document.body.removeChild(i);return k}catch(j){return false}}Modernizr.addTest("csshyphens",function(){if(!Modernizr.testAllProps("hyphens")){return false}try{return a()}catch(d){return false}});Modernizr.addTest("softhyphens",function(){try{return c("­",true)&&c("​",false)}catch(d){return false}});Modernizr.addTest("softhyphensfind",function(){try{return b("­")&&b("​")}catch(d){return false}})})();Modernizr.addTest("lastchild",function(){return Modernizr.testStyles("#modernizr div {width:100px} #modernizr :last-child{width:200px;display:block}",function(a){return a.lastChild.offsetWidth>a.firstChild.offsetWidth},2)});Modernizr.addTest("cssmask",Modernizr.testAllProps("mask-repeat"));Modernizr.addTest("mediaqueries",Modernizr.mq("only all"));Modernizr.addTest("object-fit",!!Modernizr.prefixed("objectFit"));Modernizr.addTest("overflowscrolling",function(){return Modernizr.testAllProps("overflowScrolling")});Modernizr.addTest("pointerevents",function(){var a=document.createElement("x"),d=document.documentElement,c=window.getComputedStyle,b;if(!("pointerEvents" in a.style)){return false}a.style.pointerEvents="auto";a.style.pointerEvents="x";d.appendChild(a);b=c&&c(a,"").pointerEvents==="auto";d.removeChild(a);return !!b});Modernizr.addTest("csspositionsticky",function(){var b="position:";var d="sticky";var c=document.createElement("modernizr");var a=c.style;a.cssText=b+Modernizr._prefixes.join(d+";"+b).slice(0,-b.length);return a.position.indexOf(d)!==-1});Modernizr.addTest("cssremunit",function(){var a=document.createElement("div");try{a.style.fontSize="3rem"}catch(b){}return(/rem/).test(a.style.fontSize)});Modernizr.addTest("regions",function(){var g=Modernizr.prefixed("flowFrom"),d=Modernizr.prefixed("flowInto");if(!g||!d){return false}var i=document.createElement("div"),f=document.createElement("div"),e=document.createElement("div"),h="modernizr_flow_for_regions_check";f.innerText="M";i.style.cssText="top: 150px; left: 150px; padding: 0px;";e.style.cssText="width: 50px; height: 50px; padding: 42px;";e.style[g]=h;i.appendChild(f);i.appendChild(e);document.documentElement.appendChild(i);var a,c,b=f.getBoundingClientRect();f.style[d]=h;a=f.getBoundingClientRect();c=a.left-b.left;document.documentElement.removeChild(i);f=e=i=undefined;return(c==42)});Modernizr.addTest("cssresize",Modernizr.testAllProps("resize"));Modernizr.addTest("cssscrollbar",function(){var a,b="#modernizr{overflow: scroll; width: 40px }#"+Modernizr._prefixes.join("scrollbar{width:0px} #modernizr::").split("#").slice(1).join("#")+"scrollbar{width:0px}";Modernizr.testStyles(b,function(c){a="scrollWidth" in c&&c.scrollWidth==40});return a});Modernizr.addTest("subpixelfont",function(){var a,b="#modernizr{position: absolute; top: -10em; visibility:hidden; font: normal 10px arial;}#subpixel{float: left; font-size: 33.3333%;}";Modernizr.testStyles(b,function(d){var c=d.firstChild;c.innerHTML="This is a text written in Arial";a=window.getComputedStyle?window.getComputedStyle(c,null).getPropertyValue("width")!=="44px":false},1,["subpixel"]);return a});Modernizr.addTest("supports","CSSSupportsRule" in window);Modernizr.addTest("userselect",function(){return Modernizr.testAllProps("user-select")});Modernizr.addTest("cssvhunit",function(){var a;Modernizr.testStyles("#modernizr { height: 50vh; }",function(c,b){var d=parseInt(window.innerHeight/2,10),e=parseInt((window.getComputedStyle?getComputedStyle(c,null):c.currentStyle)["height"],10);a=(e==d)});return a});Modernizr.addTest("cssvmaxunit",function(){var a;Modernizr.testStyles("#modernizr { width: 50vmax; }",function(c,b){var f=window.innerWidth/100,d=window.innerHeight/100,e=parseInt((window.getComputedStyle?getComputedStyle(c,null):c.currentStyle)["width"],10);a=(parseInt(Math.max(f,d)*50,10)==e)});return a});Modernizr.addTest("cssvminunit",function(){var a;Modernizr.testStyles("#modernizr { width: 50vmin; }",function(c,b){var f=window.innerWidth/100,d=window.innerHeight/100,e=parseInt((window.getComputedStyle?getComputedStyle(c,null):c.currentStyle)["width"],10);a=(parseInt(Math.min(f,d)*50,10)==e)});return a});Modernizr.addTest("customprotocolhandler",function(){return !!navigator.registerProtocolHandler});Modernizr.addTest("cssvwunit",function(){var a;Modernizr.testStyles("#modernizr { width: 50vw; }",function(c,b){var d=parseInt(window.innerWidth/2,10),e=parseInt((window.getComputedStyle?getComputedStyle(c,null):c.currentStyle)["width"],10);a=(e==d)});return a});Modernizr.addTest("dataview",(typeof DataView!=="undefined"&&"getFloat64" in DataView.prototype));Modernizr.addTest("classlist","classList" in document.documentElement);Modernizr.addTest("createelement-attrs",function(){try{return document.createElement("<input name='test' />").getAttribute("name")=="test"}catch(a){return false}});Modernizr.addTest("dataset",function(){var a=document.createElement("div");a.setAttribute("data-a-b","c");return !!(a.dataset&&a.dataset.aB==="c")});Modernizr.addTest("microdata",!!(document.getItems));Modernizr.addTest("datalistelem",Modernizr.input.list);Modernizr.addTest("details",function(){var d=document,c=d.createElement("details"),a,e,b;if(!("open" in c)){return false}e=d.body||(function(){var f=d.documentElement;a=true;return f.insertBefore(d.createElement("body"),f.firstElementChild||f.firstChild)}());c.innerHTML="<summary>a</summary>b";c.style.display="block";e.appendChild(c);b=c.offsetHeight;c.open=true;b=b!=c.offsetHeight;e.removeChild(c);a&&e.parentNode.removeChild(e);return b});Modernizr.addTest("outputelem","value" in document.createElement("output"));Modernizr.addTest("progressbar",function(){return document.createElement("progress").max!==undefined});Modernizr.addTest("meter",function(){return document.createElement("meter").max!==undefined});Modernizr.addTest("ruby",function(){var b=document.createElement("ruby"),h=document.createElement("rt"),d=document.createElement("rp"),a=document.documentElement,f="display",e="fontSize";b.appendChild(d);b.appendChild(h);a.appendChild(b);if(c(d,f)=="none"||c(b,f)=="ruby"&&c(h,f)=="ruby-text"||c(d,e)=="6pt"&&c(h,e)=="6pt"){g();return true}else{g();return false}function c(i,k){var j;if(window.getComputedStyle){j=document.defaultView.getComputedStyle(i,null).getPropertyValue(k)}else{if(i.currentStyle){j=i.currentStyle[k]}}return j}function g(){a.removeChild(b);b=null;h=null;d=null}});Modernizr.addTest("time","valueAsDate" in document.createElement("time"));Modernizr.addTest({texttrackapi:(typeof(document.createElement("video").addTextTrack)==="function"),track:("kind" in document.createElement("track"))});Modernizr.addTest("emoji",function(){if(!Modernizr.canvastext){return false}var a=document.createElement("canvas"),b=a.getContext("2d");b.textBaseline="top";b.font="32px Arial";b.fillText("\ud83d\ude03",0,0);return b.getImageData(16,16,1,1).data[0]!==0});Modernizr.addTest("strictmode",function(){return(function(){return !this})()});Modernizr.addTest("devicemotion",("DeviceMotionEvent" in window));Modernizr.addTest("deviceorientation",("DeviceOrientationEvent" in window));(function(){var a=new Image();a.onerror=function(){Modernizr.addTest("exif-orientation",function(){return false})};a.onload=function(){Modernizr.addTest("exif-orientation",function(){return a.width!==2})};a.src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/4QAiRXhpZgAASUkqAAgAAAABABIBAwABAAAABgASAAAAAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAIDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+/iiiigD/2Q=="})();Modernizr.addTest("filereader",function(){return !!(window.File&&window.FileList&&window.FileReader)});Modernizr.addTest("fileinput",function(){var a=document.createElement("input");a.type="file";return !a.disabled});Modernizr.addTest("formattribute",function(){var f=document.createElement("form"),e=document.createElement("input"),b=document.createElement("div"),a="formtest"+(new Date().getTime()),d,c=false;f.id=a;if(document.createAttribute){d=document.createAttribute("form");d.nodeValue=a;e.setAttributeNode(d);b.appendChild(f);b.appendChild(e);document.documentElement.appendChild(b);c=f.elements.length===1&&e.form==f;b.parentNode.removeChild(b)}return c});Modernizr.addTest("filesystem",!!Modernizr.prefixed("requestFileSystem",window));Modernizr.addTest("placeholder",function(){return !!("placeholder" in (Modernizr.input||document.createElement("input"))&&"placeholder" in (Modernizr.textarea||document.createElement("textarea")))});Modernizr.addTest("speechinput",function(){var a=document.createElement("input");return"speech" in a||"onwebkitspeechchange" in a});(function(a,b){b.formvalidationapi=false;b.formvalidationmessage=false;b.addTest("formvalidation",function(){var h=a.createElement("form");if(!("checkValidity" in h)){return false}var g=a.body,d=a.documentElement,e=false,c=false,f;b.formvalidationapi=true;h.onsubmit=function(i){if(!window.opera){i.preventDefault()}i.stopPropagation()};h.innerHTML='<input name="modTest" required><button></button>';h.style.position="absolute";h.style.top="-99999em";if(!g){e=true;g=a.createElement("body");g.style.background="";d.appendChild(g)}g.appendChild(h);f=h.getElementsByTagName("input")[0];f.oninvalid=function(i){c=true;i.preventDefault();i.stopPropagation()};b.formvalidationmessage=!!f.validationMessage;h.getElementsByTagName("button")[0].click();g.removeChild(h);e&&d.removeChild(g);return c})})(document,window.Modernizr);Modernizr.addTest("fullscreen",function(){for(var a=0;a<Modernizr._domPrefixes.length;a++){if(document[Modernizr._domPrefixes[a].toLowerCase()+"CancelFullScreen"]){return true}}return !!document.cancelFullScreen||false});Modernizr.addTest("gamepads",!!Modernizr.prefixed("getGamepads",navigator));Modernizr.addTest("getusermedia",!!Modernizr.prefixed("getUserMedia",navigator));Modernizr.addTest("ie8compat",function(){return(!window.addEventListener&&document.documentMode&&document.documentMode===7)});Modernizr.addTest("sandbox","sandbox" in document.createElement("iframe"));(function(){if(!Modernizr.canvas){return false}var c=new Image(),b=document.createElement("canvas"),a=b.getContext("2d");c.onload=function(){Modernizr.addTest("apng",function(){if(typeof b.getContext=="undefined"){return false}else{a.drawImage(c,0,0);return a.getImageData(0,0,1,1).data[3]===0}})};c.src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACGFjVEwAAAABAAAAAcMq2TYAAAANSURBVAiZY2BgYPgPAAEEAQB9ssjfAAAAGmZjVEwAAAAAAAAAAQAAAAEAAAAAAAAAAAD6A+gBAbNU+2sAAAARZmRBVAAAAAEImWNgYGBgAAAABQAB6MzFdgAAAABJRU5ErkJggg=="}());(function(){var a=new Image();a.onerror=function(){Modernizr.addTest("webp",false)};a.onload=function(){Modernizr.addTest("webp",function(){return a.width==1})};a.src="data:image/webp;base64,UklGRiwAAABXRUJQVlA4ICAAAAAUAgCdASoBAAEAL/3+/3+CAB/AAAFzrNsAAP5QAAAAAA=="}());Modernizr.addTest("seamless","seamless" in document.createElement("iframe"));Modernizr.addTest("srcdoc","srcdoc" in document.createElement("iframe"));Modernizr.addTest("json",!!window.JSON&&!!JSON.parse);Modernizr.addTest("olreversed","reversed" in document.createElement("ol"));Modernizr.addTest("mathml",function(){var c=false;if(document.createElementNS){var a="http://www.w3.org/1998/Math/MathML",d=document.createElement("div");d.style.position="absolute";var b=d.appendChild(document.createElementNS(a,"math")).appendChild(document.createElementNS(a,"mfrac"));b.appendChild(document.createElementNS(a,"mi")).appendChild(document.createTextNode("xx"));b.appendChild(document.createElementNS(a,"mi")).appendChild(document.createTextNode("yy"));document.body.appendChild(d);c=d.offsetHeight>d.offsetWidth}return c});Modernizr.addTest("lowbandwidth",function(){var a=navigator.connection||{type:0};return a.type==3||a.type==4||/^[23]g$/.test(a.type)});Modernizr.addTest("eventsource",!!window.EventSource);Modernizr.addTest("xhr2","FormData" in window);Modernizr.addTest("notification",!!Modernizr.prefixed("Notifications",window));Modernizr.addTest("performance",!!Modernizr.prefixed("performance",window));Modernizr.addTest("pointerlock",!!Modernizr.prefixed("pointerLockElement",document));Modernizr.addTest("quotamanagement",function(){var a=Modernizr.prefixed("StorageInfo",window);return !!(a&&"TEMPORARY" in a&&"PERSISTENT" in a)});Modernizr.addTest("scriptdefer","defer" in document.createElement("script"));Modernizr.addTest("raf",!!Modernizr.prefixed("requestAnimationFrame",window));Modernizr.addTest("scriptasync","async" in document.createElement("script"));Modernizr.addTest("stylescoped","scoped" in document.createElement("style"));Modernizr.addTest("unicode",function(){var b,c=document.createElement("span"),a=document.createElement("span");Modernizr.testStyles("#modernizr{font-family:Arial,sans;font-size:300em;}",function(d){c.innerHTML="ᝣ";a.innerHTML="☆";d.appendChild(c);d.appendChild(a);b="offsetWidth" in c&&c.offsetWidth!==a.offsetWidth});return b});Modernizr.addTest("svgfilters",function(){var b=false;try{b=typeof SVGFEColorMatrixElement!==undefined&&SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE==2}catch(a){}return b});(function(){var a=new Image();a.onerror=function(){Modernizr.addTest("datauri",function(){return false})};a.onload=function(){Modernizr.addTest("datauri",function(){return(a.width==1&&a.height==1)})};a.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="})();Modernizr.addTest("userdata",function(){return !!document.createElement("div").addBehavior});Modernizr.addTest("vibrate",!!Modernizr.prefixed("vibrate",navigator));Modernizr.addTest("webintents",function(){return !!Modernizr.prefixed("startActivity",navigator)});(function(){if(!Modernizr.webgl){return}var b,f,a;try{b=document.createElement("canvas");f=b.getContext("webgl")||b.getContext("experimental-webgl");a=f.getSupportedExtensions()}catch(d){return}if(f===undefined){Modernizr.webgl=new Boolean(false)}else{Modernizr.webgl=new Boolean(true)}for(var g=-1,c=a.length;++g<c;){Modernizr.webgl[a[g]]=true}if(window.TEST&&TEST.audvid){TEST.audvid.push("webgl")}b=undefined})();Modernizr.addTest("websocketsbinary",!!(window.WebSocket&&(new WebSocket("ws://.")).binaryType));Modernizr.addTest("framed",function(){return window.location!=top.location});(function(){try{var g=window.MozBlobBuilder||window.WebKitBlobBuilder||window.MSBlobBuilder||window.OBlobBuilder||window.BlobBuilder,b=window.MozURL||window.webkitURL||window.MSURL||window.OURL||window.URL;var c="Modernizr",h=new g();h.append("this.onmessage=function(e){postMessage(e.data)}");var f=b.createObjectURL(h.getBlob()),a=new Worker(f);h=null;a.onmessage=function(i){a.terminate();b.revokeObjectURL(f);Modernizr.addTest("blobworkers",c===i.data);a=null};a.onerror=function(){Modernizr.addTest("blobworkers",false);a=null};setTimeout(function(){Modernizr.addTest("blobworkers",false)},200);a.postMessage(c)}catch(d){Modernizr.addTest("blobworkers",false)}}());(function(){try{var c="Modernizr",b=new Worker("data:text/javascript;base64,dGhpcy5vbm1lc3NhZ2U9ZnVuY3Rpb24oZSl7cG9zdE1lc3NhZ2UoZS5kYXRhKX0=");b.onmessage=function(d){b.terminate();Modernizr.addTest("dataworkers",c===d.data);b=null};b.onerror=function(){Modernizr.addTest("dataworkers",false);b=null};setTimeout(function(){Modernizr.addTest("dataworkers",false)},200);b.postMessage(c)}catch(a){Modernizr.addTest("dataworkers",false)}}());Modernizr.addTest("sharedworkers",function(){return !!window.SharedWorker});