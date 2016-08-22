$(document).ready(function() {
    $.validator.addMethod(
        "canaralabel",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/^[a-zA-Z0-9\.\-\s\'\"]*$/g);
        },
        "Please check for invalid input."
    );
    $.validator.addMethod(
        "canaratablename",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/^[a-z0-9_]*$/g);
        },
        "Please check for invalid input."
    );
    $.validator.addMethod(
        "canaraaddress",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/^[#a-zA-Z0-9\.\-\s\'\"]*$/g);
        },
        "Please check for invalid input."
    );
    $.validator.addMethod(
        "canaramacaddress",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/([a-fA-F0-9]{2}?){6}/);
        },
        "Please check for invalid input."
    );
    $.validator.addMethod(
        "canaraemail",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/);
        },
        "Please check for invalid email."
    );
    $.validator.addMethod(
        "canaraurl",
        function(value, element, enabled) {
            return this.optional(element) || value.match(/^http(s)?:\/\/[a-z0-9\-]+(.[a-z0-9\-]+)*(:[0-9]+)?(\/.*)?$/i);
        },
        "Please check for invalid url."
    );
    $.validator.addMethod(
        "canaradecimal",
        function(value, element, params) {
            var regxStr = "^\\d{0,"+params[0]+"}(\\.\\d{0,"+params[1]+"})?$";
            var regX = new RegExp(regxStr);
            return this.optional(element) || regX.test(value);
        },
        "Please note the correct numeric format."
    );
    $.validator.addMethod(
        'canaraLessThan', 
        function(value, element, param) {
            return this.optional(element) || parseInt(value) <= parseInt(param);
        }, "The value must be less than {0}"
    );
    $.validator.addMethod(
        "canararegex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check for invalid input."
    );
});