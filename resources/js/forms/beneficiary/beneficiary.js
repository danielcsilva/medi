require('../../bootstrap');

$(document).ready(function(){

    $('#addTelephone').on('click', function(){
        var item = $('.repeat-telephone:first').clone();
        item.find('.remove-telephone').show();
        $('#telephone-repeater').append(item);
    });

    $(document).on('click', '.remove-telephone', function(e){
        var obj = e.target;
        if ($('.repeat-telephone').length > 1) {
            $(obj).parents('.repeat-telephone:first').remove();
        }
    });

});
