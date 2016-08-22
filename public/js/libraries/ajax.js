/**
 * @preserve Copyright 2015 CareSpan International, Inc.
 *
 * No part of this code may be re-used in any other application
 * than the CareSpan Virtual Clinic or other application owned by CareSpan
 *
 * Required js files:
 * 3) jquery.cookie.js
 * 
 */

var Canara = Canara || {};
Canara.Libraries = Canara.Libraries || {};

(function(global) {

    global.Ajax = function () {

        // declaring my properties
        var self = this,
            // declaring my functions
            securecall,
            _secureAjax,
            _wrapAjaxData;

        // public functions
        get = function(params)
        {
            $.ajax(params);
        };

        securecall = function(params)
        {
            _secureAjax(params);
        };

        securesync = function()
        {
            var self = this;
            if (self.urlRoot || self.url) {
                _secureAjax({
                    url: self.urlRoot || self.url,
                    success: function(datastr) {
                        console.log(self.urlRoot || self.url);
                        // console.log(self);
                        if (datastr.length) {
                            console.log(datastr);
                            var data = JSON.parse(datastr);
                            if (undefined === self.length) { // if this is a model
                                // console.log('update model');
                                self.set(data);
                            } else { // if (self.collection) { // if this is a collection
                                // console.log('update collection');
                                self.reset(data);
                                // self.trigger('reset');
                            }
                        } else {
                            console.log('no datastr');
                        }
                    }
                });
            }
        };

        // private function
        _secureAjax = function(params)
        {
            params.type = 'POST'; // forces call using post
            params.data = _wrapAjaxData(params.data); // make sure we grab the csrf
            $.ajax(params);
        };

        _wrapAjaxData = function(data)
        {
            data = data || {};
            
            if ('string' == $.type(data)) {
                var pairs = data.split('&');
                dataobj = {};
                for (var i = 0; i < pairs.length; i++) {
                    var pair = pairs[i].split('=');
                    var key = pair[0];
                    var value = pair[1];
                    dataobj[key] = value;
                }
                
                // this is weird, the csrf is not working if serialized from the form. i have to remove it and use the csrf from the cookie
                // this is because when we call the ping session, it will overwrite the csrf cookie
                dataobj.quad_token = $.cookie('quad_cookie'); // always overwrite the csrf

                var datapairs = [];
                for (var key in dataobj) {
                    datapairs.push(key + '=' + dataobj[key]); // convert into a list of [key, value] pairs
                }

                data = datapairs.join('&'); // can only join a [key, value] pair
            } else {
                
                data.quad_token = $.cookie('quad_cookie'); // always overwrite the csrf
            }

            // if (undefined == data.c_timestamp) {
                // console.log('new c time stamp')
            // }
            return data;
        };

        return {
            get: get,
            securecall: securecall,
            securesync: securesync
        };

    };

}(Canara.Libraries));

// this line should be commented out
// window.CsAjax = Carespan.Libraries.CsAjax;