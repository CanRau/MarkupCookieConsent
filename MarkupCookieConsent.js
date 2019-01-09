/**
 * NOTE If you make any changes to this file:
 * You need to minify it yourself or at least name it MarkupCookieConsent.min.js
 * because the module only injects this file automatically
 */

/**
 * Cross-browser Document Ready check by http://www.raymonschouwenaar.nl/cross-browser-document-ready-with-vanilla-javascript-ie8-included/
 */
var domIsReady = (function(domIsReady) {
   var isBrowserIeOrNot = function() {
      return (!document.attachEvent || typeof document.attachEvent === "undefined" ? 'not-ie' : 'ie');
   }

   domIsReady = function(callback) {
      if(callback && typeof callback === 'function'){
         if(isBrowserIeOrNot() !== 'ie') {
            document.addEventListener("DOMContentLoaded", function() {
               return callback();
            });
         } else {
            document.attachEvent("onreadystatechange", function() {
               if(document.readyState === "complete") {
                  return callback();
               }
            });
         }
      } else {
         console.error('The callback is not a function!');
      }
   }

   return domIsReady;
})(domIsReady || {});


(function(document, window, domIsReady, undefined) {
   domIsReady(function() {
      
      var mCCButton = document.getElementById('mCCButton');

      mCCButton.addEventListener('click', function(e) {
         // prevent the button from actually submitting the form
         e.preventDefault();

         // immediately remove cookie message from dom
         var mCCForm = document.getElementById('mCCForm');
         mCCForm.parentNode.removeChild(mCCForm);

         // now let's send the request to place the cookie
         // we could set the cookie via js,
         // but the code with all user defined settings is already there
         var xhr = new XMLHttpRequest();
         xhr.open("POST", './', true);
         xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xhr.send('action=acceptCookies');
         xhr.onreadystatechange=function(){
         	if(xhr.readyState==4 && xhr.status==200){
         		window.location.reload(true);
         	}
         }
      });
   });

})(document, window, domIsReady);
