/*!
   JW Player version 8.18.0
   Copyright (c) 2020, JW Player, All Rights Reserved
   This source code and its use and distribution is subject to the terms
   and conditions of the applicable license agreement.
   https://www.jwplayer.com/tos/
   This product includes portions of other software. For the full text of licenses, see
   https://ssl.p.jwpcdn.com/player/v/8.18.0/notice.txt
*/
(window.webpackJsonpjwplayer=window.webpackJsonpjwplayer||[]).push([[12],{181:function(e,t,a){"use strict";a.r(t);var i=a(3),r=a(0),n=a(9),s=a(1),c=function(e){var t=this,a=window.chrome.cast,c=a.media,d=window.cast.framework,o=d.CastContext.getInstance(),u=null,l=d.CastContextEventType.CAST_STATE_CHANGED,f=e||c.DEFAULT_MEDIA_RECEIVER_APP_ID;function v(e,a,i){var n=e.allSources.slice(0).sort((function(e,t){return!e.default&&t.default?1:0})),s=Object(r.l)(n,(function(e){var t=!Object(r.G)(e.mediaTypes)||!Object(r.e)(e.mediaTypes,'video/webm; codecs="vp9"'),a=!Object(r.G)(e.drm)||Object(r.b)(e.drm,(function(e,t){return"fairplay"!==t}));return t&&a}));if(s){var d=function(e){switch(e){case"mp4":case"webm":return"video/"+e;case"mpd":case"dash":return"application/dash+xml";case"m3u8":case"hls":return"application/x-mpegURL";case"aac":return"audio/x-aac";case"mp3":return"audio/mpeg";default:return e}}(s.type),o=T(s.file),u=e.image?T(e.image):null,l=s.drm,f=new c.MediaInfo(o,d);return f.metadata=new c.GenericMediaMetadata,f.metadata.title=e.title,f.metadata.subtitle=e.description,f.metadata.index=a||0,f.metadata.playerId=t.getPlayerId(),e.tracks&&e.tracks.length&&(f.tracks=e.tracks.filter((function(e){return e.kind&&!!c.TextTrackType[e.kind.toUpperCase()]})).map((function(e,t){var a=t+1,i=new c.Track(a,c.TrackType.TEXT);i.trackContentId=e.file,i.trackContentType="text/vtt",i.name=e.label||a;var r=i.subtype=c.TextTrackType[e.kind.toUpperCase()];return r!==c.TextTrackType.CAPTIONS&&r!==c.TextTrackType.SUBTITLES&&r!==c.TextTrackType.DESCRIPTION||(i.customData="side-loaded captions",i.language="en-US"),i}))),i&&(f.textTrackStyle=t.obtainTrackStyles(i)),u&&(f.metadata.images=[{url:u}]),l&&(f.customData={drm:l}),f}}function T(e){var t=document.createElement("a");return t.href=e,t.href}function m(){var e=o.getCastState()!==d.CastState.NO_DEVICES_AVAILABLE,a="";(u=o.getCurrentSession())&&(a=u.getCastDevice().friendlyName||a),t.trigger("castState",{available:e,active:!!u,deviceName:a})}function h(){var e=t.getMedia();e&&t.trigger("mediaUpdate",{field:"media",value:e})}function g(e){e.removeUpdateListener(h),e.addUpdateListener(h)}Object(r.j)(t,n.a),o.removeEventListener(l,m),o.addEventListener(l,m),o.setOptions({receiverApplicationId:f,autoJoinPolicy:a.AutoJoinPolicy.ORIGIN_SCOPED}),t.updateCastState=m,t.setPlaylist=function(e){var a=e.get("playlist"),r=e.get("item"),n=e.mediaModel.get("currentTime"),d=e.get("repeat"),o=e.get("captions"),l=u.getSessionObj();if("complete"===e.get("state")&&(r=0,n=0),1===a.length){var f=v(a[r],r,o),T=new c.LoadRequest(f);T.autoplay=!0,T.currentTime=n,l.loadMedia(T,t.loaded,t.error)}else{for(var m=[],h=1,g=0,k=r;k<a.length;k++){var p=v(a[k],k,o),y=void 0;if(p){y=new c.QueueItem(p),p.metadata.index===r&&(y.startTime=n,g=m.length);var _=JSON.stringify(y).length+1;if(!(h+_<32e3))break;m.push(y),h+=_}}if(m.length){var b=new c.QueueLoadRequest(m);b.startIndex=g,d&&(b.repeatMode=c.RepeatMode.ALL),l.queueLoad(b,t.queueLoaded,t.queueErrored)}else t.trigger(i.wb,new s.t(null,35e4,{info:"media not supported by Chromecast"}))}},t.queueLoaded=function(e){t.loaded(e)},t.queueErrored=function(e){t.error(e)},t.getPlayerId=function(){var e=t.getMedia();return e&&e.media?e.media.metadata.playerId:u?u.getSessionObj().playerId:null},t.setPlayerId=function(e){u&&(u.getSessionObj().playerId=e)},t.loaded=function(e){t.trigger("mediaUpdate",{field:"volume",value:{volume:u.getVolume(),isMute:u.isMute()}}),g(e),t.play()},t.addListeners=function(){var e;if(!u)return null;(e=u.getSessionObj()).removeUpdateListener(m),e.addUpdateListener(m),e.removeMediaListener(g),e.addMediaListener(g),u.addEventListener(d.SessionEventType.VOLUME_CHANGED,(function(e){t.trigger("mediaUpdate",{field:"volume",value:e})}))},t.reset=function(){t.removeListeners(),o&&o.removeEventListener(l,m)},t.removeListeners=function(){if(u){var e=u.getSessionObj();e.removeUpdateListener(m),e.media.forEach((function(e){e.removeUpdateListener(h)})),u.removeEventListener(d.SessionEventType.VOLUME_CHANGED)}},t.getMedia=function(){if(u){var e=u.getSessionObj().media;if(e&&e.length)return e[0]}return null},t.error=function(e){t.trigger(i.wb,new s.t(null,35e4,{errorCode:e})),t.disconnect()},t.item=function(e){var a=t.getMedia();if(a){var i=v(e),n=Object(r.l)(a.items,(function(e){return e.media.contentId===i.contentId&&e.media.index===i.index}));n?a.queueJumpToItem(n.itemId):t.trigger("setPlaylist")}else t.trigger("setPlaylist")},t.play=function(){var e=t.getMedia();e&&e.play()},t.pause=function(){var e=t.getMedia();e&&e.pause()},t.next=function(){var e=t.getMedia();e&&e.queueNext()},t.disconnect=function(){u&&u.endSession(!0)},t.seek=function(e,a){var i=t.getMedia();if(i){var r=new c.SeekRequest;r.currentTime=e,r.resumeState=c.ResumeState.PLAYBACK_START,i.seek(r,a)}},t.mute=function(e){u&&u.setMute(e)},t.volume=function(e){u&&u.setVolume(e/100)},t.editTracksInfo=function(e,a){var i=t.getMedia();if(i){var r=new c.EditTracksInfoRequest(e,a);i.editTracksInfo(r)}},t.extractEmbeddedCaptions=function(){var e=t.getMedia();if(e&&e.media.tracks){var a=/\.dfxp/,i=e.media.tracks.filter((function(e){return"TEXT"===e.type&&"side-loaded captions"!==e.customData&&!a.test(e.trackContentId)})).map((function(e,t){return e.mapId=t,e.kind="subtitles",e.cues=[],e}));i.length&&t.trigger("mediaUpdate",{field:"captions",value:{tracks:i}})}},t.obtainTrackStyles=function(e){var t=function(e){return Math.round(e/100*255).toString(16)},a=new c.TextTrackStyle,i=function(e,t){return e&&e+t||void 0};return a.foregroundColor=i(e.color,t(e.fontOpacity)),a.backgroundColor=i(e.backgroundColor,t(e.backgroundOpacity)),a.windowColor=i(e.windowColor,t(e.windowOpacity)),a.fontFamily=e.fontFamily,a.fontStyle=c.TextTrackFontStyle.NORMAL,a.fontScale=e.fontSize/14,a.edgeType=function(e){var t=c.TextTrackEdgeType;switch(e){case"dropShadow":return t.DROP_SHADOW;case"raised":return t.RAISED;case"depressed":return t.DEPRESSED;case"uniform":return t.OUTLINE;default:return t.NONE}}(e.edgeStyle),a.windowType=c.TextTrackWindowType.NORMAL,a}},d=a(8),o=a(57),u=a(96),l=a(84),f=function(e,t){var a,n,c,o=this,u=t.minDvrWindow;function f(){var e=window.chrome.cast.media.TextTrackType,t=n.getMedia(),a=0;if(!t)return a;var i=t.media.tracks;if(!i)return a;for(var r=0;r<i.length;r++){var s=i[r],c=s.subtype;if("TEXT"===s.type&&(c===e.CAPTIONS||c===e.SUBTITLES||c===e.DESCRIPTION)){a=r;break}}return a}function v(e){if(n){var t=Array.prototype.slice.call(arguments,1);n[e]&&n[e].apply(n,t)}}function T(e){if(n){var t=n.getMedia();return t?"currentTime"!==e||t.liveSeekableRange?t[e]||(t.media?t.media[e]:null):t.getEstimatedTime():null}}o.destroy=function(){clearInterval(o.timeInterval)},o.setService=function(e){n=e,o.updateScreen()},o.setup=function(e){o.setState(i.kb),v("setup",e)},o.init=function(e){c!==e&&(c=e,v("item",e))},o.load=function(e){o.init(e),o.play()},o.play=function(){v("play")},o.pause=function(){v("pause")},o.seek=function(e){(o.trigger(i.Q,{position:o.getPosition(),offset:e}),e<0)&&(e+=o.getSeekRange().end);v("seek",e,(function(){o.trigger(i.R)}))},o.next=function(e){v("next",e)},o.volume=function(e){v("volume",e)},o.mute=function(e){v("mute",e)},o.setSubtitlesTrack=function(e){e>0&&n.editTracksInfo([e+f()])},o.updateScreen=function(e,t){Object(d.q)(a,function(e,t){return'<div class="jw-cast jw-reset jw-preview" style="'+(t?'background-image:url("'+t+'")':"")+'"><div class="jw-cast-container"><div class="jw-cast-text jw-reset">'+(e||"")+"</div></div></div>"}(e,t))},o.setContainer=function(e){a=e},o.getContainer=function(){return a},o.remove=function(){clearInterval(o.timeInterval)},o.getPosition=function(){var e=T("currentTime")||0,t=o.getDuration();if(T("liveSeekableRange")||t<0){var a=o.getSeekRange(),i=a.end,r=i-a.start;if(Object(l.a)(r,u))return e-i}return e},o.getDuration=function(){var e=T("duration")||0;if(T("liveSeekableRange")||e<0){var t=o.getSeekRange(),a=t.end-t.start;return Object(l.a)(a,u)?-a:1/0}return e},o.getSeekRange=function(){var e=T("liveSeekableRange")||{start:0,end:Math.max(T("duration")||0,0)};return{start:e.start,end:e.end}},o.triggerTime=function(){var e=T("currentTime");Object(r.v)(e)&&o.trigger(i.S,{position:o.getPosition(),duration:o.getDuration(),currentTime:e,seekRange:o.getSeekRange(),metadata:{currentTime:e}})},o.stop=function(){o.clearTracks()},o.castEventHandlers={media:function(e){var t=T("items"),a="IDLE"===e.playerState&&"FINISHED"===e.idleReason,r="IDLE"===e.playerState&&"ERROR"===e.idleReason,c=a&&!t;o.castEventHandlers.playerState(c?"complete":e.playerState),o.castEventHandlers.currentTime(),clearInterval(o.timeInterval),"PLAYING"===e.playerState?o.timeInterval=setInterval(o.castEventHandlers.currentTime,100):c?o.setState("complete"):r&&(o.setState("error"),o.trigger(i.wb,new s.t(null,35e4,e)),n.disconnect())},volume:function(e){o.trigger("volume",{volume:Math.round(100*e.volume)}),o.trigger("mute",{mute:e.isMute})},captions:function(e){o.clearTracks(),o.setTextTracks(e.tracks),o.trigger("subtitlesTracks",{tracks:e.tracks})},playerState:function(e){var t=[i.kb,i.nb,i.qb,i.pb,i.rb,i.ob,i.lb,i.mb];if(e&&-1!==t.indexOf(e.toLowerCase())){var a=e.toLowerCase();if(a===i.nb||a===i.kb){var n=T("currentTime");Object(r.v)(n)&&o.trigger(i.D,{bufferPercent:0,position:o.getPosition(),duration:o.getDuration(),currentTime:n,seekRange:o.getSeekRange()})}o.setState(a)}},currentTime:o.triggerTime,duration:o.triggerTime,isPaused:function(e){e?o.setState(i.pb):o.setState(i.qb)},supports:function(){return!0}}};Object(r.j)(f.prototype,o.a,n.a,u.a,{getName:function(){return{name:"chromecast"}},getQualityLevels:Object(r.d)(["Auto"])});var v,T=f,m=a(23);var h=a(35),g=v||(v=new Promise((function(e,t){window.__onGCastApiAvailable=function(a){a?e(a):t(),delete window.__onGCastApiAvailable},new m.a("https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1").load().catch(t)}))),k={};t.default=function(e,t){var a=k[t.get("id")],n=null;function s(){var r=t.get("cast")||{};t.set("castState",{available:!1,active:!1,deviceName:""}),a&&(a.off(),a.reset()),(a=new c(r.customAppId)).on("castState",_),a.on("mediaUpdate",m),a.on("mediaUpdate",p),a.on("setPlaylist",d),a.on(i.wb,(function(t){e.trigger(i.wb,t)})),a.updateCastState(),k[t.get("id")]=a}function d(){t.set("state",i.kb);var e=t.get("playlistItem");n.updateScreen("Connecting",e.image),a.setPlaylist(t)}function o(){var i;(t.get("castClicked")||!a.getPlayerId())&&a.setPlayerId(t.get("id")),b()&&(e.setFullscreen(!1),n=new T(t.get("id"),t.getConfiguration()),e.castVideo(n,t.get("playlistItem")),n.setService(a),a.addListeners(),(i=a.getMedia())?a.loaded(i):(a.on("mediaUpdate",y),d()),t.on("change:playlist",d),t.on("change:itemReady",f),t.change("captions",v))}function u(r){r?o():n&&function(){var r=t.get("state"),s=r===i.lb,c=r===i.nb,o=r===i.mb,u=t.get("item"),l=t.get("playlist"),v=t.get("playlistItem");if(a.removeListeners(),n&&n.remove(),v&&o&&(void 0===(v=l[u+1])?s=!0:(t.set("item",u+1),t.set("playlistItem",v))),t.set("castActive",!1),t.set("castClicked",!1),e.stopCast(),t.off("change:playlist",d),t.off("change:itemReady",f),v)if(s)e.trigger(i.cb,{});else if(!c){var T=t.mediaModel;e.playVideo("interaction").catch((function(e){n&&T===t.mediaModel&&n.trigger("error",{message:e.message})}))}}()}function f(){a.extractEmbeddedCaptions(),n.setSubtitlesTrack(t.get("captionsIndex"))}function v(e,t){var i=a.getMedia();if(i){var r=a.obtainTrackStyles(t);a.editTracksInfo(i.activeTrackIds,r)}}function m(e){var a=e.field,i=e.value;if(n){"media"===a&&function(e){var a,i=t.get("playlist");if(!e.media)return;a=e.media.metadata;var s=i[a.index];Object(r.v)(a.index)&&a.index!==t.get("item")&&(t.attributes.itemReady=!1,t.set("item",a.index),t.set("playlistItem",s),t.set("itemReady",!0));var c=t.get("castState").deviceName,d=c?"Casting to "+c:"";n.updateScreen(d,s.image)}(i);var s=n.castEventHandlers[a];s&&s(i)}}function p(e){"media"===e.field&&(a.off("mediaUpdate",p),f())}function y(e){if("media"===e.field){a.off("mediaUpdate",y);var i=e.value,r=i.currentTime,n=i.liveSeekableRange;if(!r&&n){var s=n.start,c=n.end;if(!t.mediaModel.get("currentTime")&&Object(l.a)(c-s,t.get("minDvrWindow"))){var d=c-t.get("dvrSeekLimit");a.seek(d)}}}}function _(e){var a=t.get("castActive"),i=e.active;a!==i&&u(i),i=i&&b(),t.set("castAvailable",e.available),t.set("castActive",i),t.set("castState",{available:e.available,active:i,deviceName:e.deviceName})}function b(){return a.getPlayerId()===t.get("id")}this.init=function(){return g.then(s)},this.castToggle=h.a.noop,this.stopCasting=function(){return a&&a.disconnect()||h.a.noop}}},96:function(e,t,a){"use strict";var i=a(83),r=a(82),n={TIT2:"title",TT2:"title",WXXX:"url",TPE1:"artist",TP1:"artist",TALB:"album",TAL:"album"};function s(e,t){for(var a,i,r,n=e.length,s="",c=t||0;c<n;)if(0!==(a=e[c++])&&3!==a)switch(a>>4){case 0:case 1:case 2:case 3:case 4:case 5:case 6:case 7:s+=String.fromCharCode(a);break;case 12:case 13:i=e[c++],s+=String.fromCharCode((31&a)<<6|63&i);break;case 14:i=e[c++],r=e[c++],s+=String.fromCharCode((15&a)<<12|(63&i)<<6|(63&r)<<0)}return s}function c(e){var t=function(e){for(var t="0x",a=0;a<e.length;a++)e[a]<16&&(t+="0"),t+=e[a].toString(16);return parseInt(t)}(e);return 127&t|(32512&t)>>1|(8323072&t)>>2|(2130706432&t)>>3}function d(e){return void 0===e&&(e=[]),e.reduce((function(e,t){if(!("value"in t)&&"data"in t&&t.data instanceof ArrayBuffer){var a=new Uint8Array(t.data),i=a.length;t={value:{key:"",data:""}};for(var r=10;r<14&&r<a.length&&0!==a[r];)t.value.key+=String.fromCharCode(a[r]),r++;var d=19,o=a[d];3!==o&&0!==o||(o=a[++d],i--);var u=0;if(1!==o&&2!==o)for(var l=d+1;l<i;l++)if(0===a[l]){u=l-d;break}if(u>0){var f=s(a.subarray(d,d+=u),0);if("PRIV"===t.value.key){if("com.apple.streaming.transportStreamTimestamp"===f){var v=1&c(a.subarray(d,d+=4)),T=c(a.subarray(d,d+=4))+(v?4294967296:0);t.value.data=T}else t.value.data=s(a,d+1);t.value.info=f}else t.value.info=f,t.value.data=s(a,d+1)}else{var m=a[d];t.value.data=1===m||2===m?function(e,t){for(var a=e.length-1,i="",r=t||0;r<a;)254===e[r]&&255===e[r+1]||(i+=String.fromCharCode((e[r]<<8)+e[r+1])),r+=2;return i}(a,d+1):s(a,d+1)}}if(n.hasOwnProperty(t.value.key)&&(e[n[t.value.key]]=t.value.data),t.value.info){var h=e[t.value.key];h!==Object(h)&&(h={},e[t.value.key]=h),h[t.value.info]=t.value.data}else e[t.value.key]=t.value.data;return e}),{})}var o=a(4),u=a(3),l=a(0),f={_itemTracks:null,_textTracks:null,_currentTextTrackIndex:-1,_tracksById:null,_cuesByTrackId:null,_cachedVTTCues:null,_metaCuesByTextTime:null,_unknownCount:0,_activeCues:null,_cues:null,textTrackChangeHandler:null,addTrackHandler:null,cueChangeHandler:null,renderNatively:!1,_initTextTracks:function(){this._textTracks=[],this._tracksById={},this._metaCuesByTextTime={},this._cuesByTrackId={},this._cachedVTTCues={},this._cues={},this._activeCues={},this._unknownCount=0},addTracksListener:function(e,t,a){e&&(this.removeTracksListener(e,t,a),this.instreamMode||(e.addEventListener?e.addEventListener(t,a):e["on"+t]=a))},removeTracksListener:function(e,t,a){e&&(e.removeEventListener&&a?e.removeEventListener(t,a):e["on"+t]=null)},clearTracks:function(){var e=this;Object(i.a)(this._itemTracks);var t=this._tracksById;if(t&&Object.keys(t).forEach((function(a){if(0===a.indexOf("nativemetadata")){var i=t[a];e.cueChangeHandler&&i.removeEventListener("cuechange",e.cueChangeHandler),k(e.renderNatively,[i],!0)}})),this._itemTracks=null,this._textTracks=null,this._tracksById=null,this._cuesByTrackId=null,this._metaCuesByTextTime=null,this._unknownCount=0,this._currentTextTrackIndex=-1,this._activeCues={},this._cues={},this.renderNatively){var a=this.video.textTracks;this.textTrackChangeHandler&&this.removeTracksListener(a,"change",this.textTrackChangeHandler),k(this.renderNatively,a,!0)}},clearMetaCues:function(){var e=this,t=this._tracksById,a=this._cachedVTTCues;t&&a&&Object.keys(t).forEach((function(i){if(0===i.indexOf("nativemetadata")){var r=t[i];k(e.renderNatively,[r],!1),r.mode="hidden",r.inuse=!0,r._id&&(a[r._id]={})}}))},clearCueData:function(e){var t=this._cachedVTTCues;t&&t[e]&&(t[e]={},this._tracksById&&(this._tracksById[e].data=[]))},disableTextTrack:function(){var e=this.getCurrentTextTrack();if(e){e.mode="disabled";var t=e._id;(t&&0===t.indexOf("nativecaptions")||this.renderNatively&&o.OS.iOS)&&(e.mode="hidden")}},enableTextTrack:function(){var e=this.getCurrentTextTrack();e&&(e.mode="showing")},getCurrentTextTrack:function(){if(this._textTracks)return this._textTracks[this._currentTextTrackIndex]},getSubtitlesTrack:function(){return this._currentTextTrackIndex},addTextTracks:function(e){var t=this,a=[];return e?(this._textTracks||this._initTextTracks(),e.forEach((function(e){if(!e.kind||p(e.kind)){var r=t._createTrack(e);t._addTrackToList(r),a.push(r),e.file&&(e.data=[],Object(i.b)(e,(function(e){r.sideloaded=!0,t.addVTTCuesToTrack(r,e)}),(function(e){t.trigger(u.wb,e)})))}})),this._textTracks&&this._textTracks.length&&this.trigger(u.sb,{tracks:this._textTracks}),a):a},setTextTracks:function(e){var t=this;if(this._currentTextTrackIndex=-1,e){if(this._textTracks){var a=this._tracksById;this._activeCues={},this._cues={},this._unknownCount=0,this._textTracks=this._textTracks.filter((function(e){var i=e._id;return t.renderNatively&&i&&0===i.indexOf("nativecaptions")?(delete a[i],!1):(e.name&&0===e.name.indexOf("Unknown")&&t._unknownCount++,0===i.indexOf("nativemetadata")&&"com.apple.streaming"===e.inBandMetadataTrackDispatchType&&delete a[i],!0)}),this)}else this._initTextTracks();if(e.length)for(var i=0,n=e.length,s=this._tracksById,c=this._cuesByTrackId;i<n;i++){var d=e[i],o=d._id||"";if(!o){if("captions"===d.kind||"metadata"===d.kind){if(o=d._id="native"+d.kind+i,!d.label&&"captions"===d.kind){var l=Object(r.b)(d,this._unknownCount);d.name=l.label,this._unknownCount=l.unknownCount}}else o=d._id=Object(r.a)(d,this._textTracks?this._textTracks.length:0);if(s[o])continue;d.inuse=!0}if(d.inuse&&!s[o])if("metadata"===d.kind){d.mode="hidden";var f=this.cueChangeHandler=this.cueChangeHandler||h.bind(this);d.removeEventListener("cuechange",f),d.addEventListener("cuechange",f),s[o]=d}else if(p(d.kind)){var v=d.mode,T=void 0;if(d.mode="hidden",!d.cues.length&&d.embedded)continue;if("disabled"===v&&0===o.indexOf("nativecaptions")||(d.mode=v),c[o]&&!c[o].loaded){for(var m=c[o].cues;T=m.shift();)g(this.renderNatively,d,T);d.mode=v,c[o].loaded=!0}this._addTrackToList(d)}}this.renderNatively&&this.addTrackListeners(e),this._textTracks&&this._textTracks.length&&this.trigger(u.sb,{tracks:this._textTracks})}},addTrackListeners:function(e){var t=this.textTrackChangeHandler=this.textTrackChangeHandler||v.bind(this);this.removeTracksListener(e,"change",t),this.addTracksListener(e,"change",t),(o.Browser.edge||o.Browser.firefox)&&(t=this.addTrackHandler=this.addTrackHandler||m.bind(this),this.removeTracksListener(e,"addtrack",t),this.addTracksListener(e,"addtrack",t))},setupSideloadedTracks:function(e){if(this.renderNatively){var t=e===this._itemTracks;t||Object(i.a)(this._itemTracks),this._itemTracks=e,e&&(t||(this.disableTextTrack(),this._clearSideloadedTextTracks(),this.addTextTracks(e)))}},setSubtitlesTrack:function(e){if(this.renderNatively){if(this._textTracks&&(0===e&&this._textTracks.forEach((function(e){e.mode=e.embedded?"hidden":"disabled"})),this._currentTextTrackIndex!==e-1)){this.disableTextTrack(),this._currentTextTrackIndex=e-1;var t=this.getCurrentTextTrack();t&&(t.mode="showing"),this.trigger(u.tb,{currentTrack:this._currentTextTrackIndex+1,tracks:this._textTracks})}}else this.setCurrentSubtitleTrack&&this.setCurrentSubtitleTrack(e-1)},addCuesToTrack:function(e){var t=this._tracksById[e.name];if(t&&this._metaCuesByTextTime){t.source=e.source;for(var a=e.captions||[],i=[],r=!1,n=0;n<a.length;n++){var s=a[n],c=e.name+"_"+s.begin+"_"+s.end;if(!this._metaCuesByTextTime[c]){var d=this.createCue(s.begin,s.end,s.text);this._metaCuesByTextTime[c]=d,i.push(d),r=!0}}r&&i.sort((function(e,t){return e.start-t.start})),t.data=t.data||[],Array.prototype.push.apply(t.data,i)}},addCaptionsCue:function(e){if(e.text&&e.begin&&e.end&&this._metaCuesByTextTime){var t,a=e.trackid.toString(),i=this._tracksById&&this._tracksById[a];if(i||(i={kind:"captions",_id:a,data:[],default:!1},this.addTextTracks([i]),this.trigger(u.sb,{tracks:this._textTracks})),e.useDTS&&(i.source||(i.source=e.source||"mpegts")),t=e.begin+"_"+e.text,!this._metaCuesByTextTime[t]){var r=this.createCue(e.begin,e.end,e.text);this._metaCuesByTextTime[t]=r,i.data=i.data||[],i.data.push(r)}}},createCue:function(e,t,a){return new(window.VTTCue||window.TextTrackCue)(e,Math.max(t||0,e+.25),a)},addVTTCue:function(e,t){this._tracksById||this._initTextTracks();var a=e.track?e.track:"native"+e.type,i=this._tracksById[a],r="captions"===e.type?"Unknown CC":"ID3 Metadata",n=e.cue;if(!i){var s={kind:e.type,_id:a,label:r,default:!1};this.renderNatively||"metadata"===s.kind?((i=this._createTrack(s)).embedded=!0,this.setTextTracks(this.video.textTracks)):i=this.addTextTracks([s])[0]}if(this._cacheVTTCue(i,n,t)){var c=this.renderNatively||"metadata"===i.kind;return c?g(c,i,n):i.data.push(n),n}return null},addVTTCuesToTrack:function(e,t){if(this.renderNatively){var a,i=e._id,r=this._tracksById,n=this._cuesByTrackId,s=r[i];if(!s)return n||(n=this._cuesByTrackId={}),void(n[i]={cues:t,loaded:!1});if(!n[i]||!n[i].loaded)for(n[i]={cues:t,loaded:!0};a=t.shift();)g(this.renderNatively,s,a)}},parseNativeID3Cues:function(e,t){var a=e[e.length-1];if(!t||t.length!==e.length||!a._parsed&&!_(t[t.length-1],a)){for(var i=[],r=[],n=-1,s=-1,c=-1,d=0;d<e.length;d++){var o=e[d];if(!o._extended&&(o.data||o.value)){if(o.startTime!==s||null===o.endTime){c=s,s=o.startTime;var l=i[n];if(i[++n]=[],r[n]=[],l&&s-c>0)for(var f=0;f<l.length;f++){var v=l[f];v.endTime=s,v._extended=!0}}i[n].push(o),o._parsed||(r[n].push(o),o.endTime-s<.25&&(o.endTime=s+.25),o._parsed=!0)}}for(var T=0;T<r.length;T++)if(r[T].length){var m=y(r[T]);this.trigger(u.L,m)}}},triggerActiveCues:function(e,t){var a=this,i=e.filter((function(e){if(t&&t.some((function(t){return _(e,t)})))return!1;if(e.data)return!0;var i=e.text?function(e){var t;try{t=JSON.parse(e.text)}catch(e){return null}var a={metadataType:t.metadataType,metadataTime:e.startTime,metadata:t};t.programDateTime&&(a.programDateTime=t.programDateTime);return a}(e):null;if(i)"emsg"===i.metadataType&&(i.metadata=i.metadata||{},i.metadata.messageData=e.value),a.trigger(u.K,i);else if(e.value)return!0;return!1}));if(i.length){var r=y(i);this.trigger(u.K,r)}},ensureMetaTracksActive:function(){for(var e=this.video.textTracks,t=e.length,a=0;a<t;a++){var i=e[a];"metadata"===i.kind&&"disabled"===i.mode&&(i.mode="hidden")}},_cacheVTTCue:function(e,t,a){var i=e.kind,r=e._id,n=this._cachedVTTCues;n[r]||(n[r]={});var s,c=n[r];switch(i){case"captions":case"subtitles":s=a||Math.floor(20*t.startTime);var d="_"+(t.line||"auto"),o=Math.floor(20*t.endTime),u=c[s+d]||c[s+1+d]||c[s-1+d];return!(u&&Math.abs(u-o)<=1)&&(c[s+d]=o,!0);case"metadata":var l=t.data?new Uint8Array(t.data).join(""):t.text;return!c[s=a||t.startTime+l]&&(c[s]=t.endTime,!0);default:return!1}},_addTrackToList:function(e){this._textTracks.push(e),this._tracksById[e._id]=e},_createTrack:function(e){var t,a=Object(r.b)(e,this._unknownCount),i=a.label;if(this._unknownCount=a.unknownCount,this.renderNatively||"metadata"===e.kind){var n=this.video.textTracks;(t=Object(l.m)(n,{label:i}))||(t=this.video.addTextTrack(e.kind,i,e.language||"")),t.default=e.default,t.mode="disabled",t.inuse=!0}else(t=e).data=t.data||[];return t._id||(t._id=Object(r.a)(e,this._textTracks?this._textTracks.length:0)),t},_clearSideloadedTextTracks:function(){if(this._textTracks){var e=this._textTracks.filter((function(e){return e.embedded||"subs"===e.groupid}));this._initTextTracks();var t=this._tracksById;e.forEach((function(e){t[e._id]=e})),this._textTracks=e}}};function v(){var e=this.video.textTracks,t=Object(l.k)(e,(function(e){return(e.inuse||!e._id)&&p(e.kind)}));if(this._textTracks&&!T.call(this,t)){for(var a=-1,i=0;i<this._textTracks.length;i++)if("showing"===this._textTracks[i].mode){a=i;break}a!==this._currentTextTrackIndex&&this.setSubtitlesTrack(a+1)}else this.setTextTracks(e)}function T(e){var t=this._textTracks,a=this._tracksById;if(e.length>t.length)return!0;for(var i=0;i<e.length;i++){var r=e[i];if(!r._id||!a[r._id])return!0}return!1}function m(e){var t=e.track;t&&t._id||this.setTextTracks(this.video.textTracks)}function h(e){var t=e.target,a=t.activeCues,i=t.cues,r=t._id,n=this._cues,s=this._activeCues;if(i&&i.length){var c=n[r];n[r]=Array.prototype.slice.call(i),this.parseNativeID3Cues(i,c)}else delete n[r];if(a&&a.length){var d=s[r],o=s[r]=Array.prototype.slice.call(a);this.triggerActiveCues(o,d)}else delete s[r]}function g(e,t,a){if(o.Browser.ie){var i=a;(e||"metadata"===t.kind)&&(i=new window.TextTrackCue(a.startTime,a.endTime,a.text),a.value&&(i.value=a.value)),function(e,t){var a=[],i=e.mode;e.mode="hidden";for(var r=e.cues,n=r.length-1;n>=0&&r[n].startTime>t.startTime;n--)a.unshift(r[n]),e.removeCue(r[n]);try{e.addCue(t),a.forEach((function(t){return e.addCue(t)}))}catch(e){console.error(e)}e.mode=i}(t,i)}else try{t.addCue(a)}catch(e){console.error(e)}}function k(e,t,a){t&&t.length&&Object(l.i)(t,(function(t){var i=t._id||"";if(a&&(t._id=void 0),!o.Browser.ie&&!o.Browser.safari||!e||!/^(native|subtitle|cc)/.test(i)){o.Browser.ie&&"disabled"===t.mode||(t.mode="disabled",t.mode="hidden");for(var r=t.cues.length;r--;)t.removeCue(t.cues[r]);t.embedded||(t.mode="disabled"),t.inuse=!1}}))}function p(e){return"subtitles"===e||"captions"===e}function y(e){var t=d(e);return{metadataType:"id3",metadataTime:e[0].startTime,metadata:t}}function _(e,t){return e.startTime===t.startTime&&e.endTime===t.endTime&&e.text===t.text&&e.data===t.data&&JSON.stringify(e.value)===JSON.stringify(t.value)}t.a=f}}]);