var values = [];
$(document).ready(function() {
    var limitOptions = function(codeVersion) {
        var codeVersionClass = '.code-version-' + codeVersion;
        $("#wind option[value!='']").not(codeVersionClass).prop("disabled", true);
        $('#wind ' + codeVersionClass).prop("disabled", false);
    };
    
    $('#codeVersion').change(function(e) {
        limitOptions($(this).val());
        
        $("#wind option:not(:disabled)").each(function(name, option) {
            values.push(option.value);
        });
        if (-1 == values.indexOf($('#wind').val())) {
            $('#wind').val($('#wind option:first').val());
            console.log('no');
        }
    });
    
    limitOptions($('#codeVersion').val());
});
