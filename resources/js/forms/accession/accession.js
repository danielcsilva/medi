window.$ = window.jQuery = require('jquery');
import IMask from 'imask';

var dependents = 0;

function applyMasks() {
    // console.log('apllying masks...')
    var datesBR = document.getElementsByClassName('date-br');

    Array.prototype.forEach.call(datesBR, function(element) {
        var phoneMask = new IMask(element, {
            mask: Date,
            min: new Date(1900, 0, 1),
            max: new Date(new Date().getFullYear() + 1, 0, 1),
            lazy: false
        });
    });

    var telephones = document.getElementsByClassName('telephone');

    Array.prototype.forEach.call(telephones, function(element) {
        var phoneMask = new IMask(element, {
        mask: '(00)00000-0000',
        placeholder: {
                show: 'always'
            }
        });
    });

    var cpfs = document.getElementsByClassName('cpf');

    Array.prototype.forEach.call(cpfs, function(element) {
        var phoneMask = new IMask(element, {
        mask: '000.000.000-00',
        placeholder: {
                show: 'always'
            }
        });
    });
}

$(document).ready(function($){
    
    applyMasks();
    recountDependents();
    
    $('#addTelephone').on('click', function(e){
        e.preventDefault();
        var item = $('.repeat-telephone:first').clone();
        item.find('input').val('');
        item.find('.remove-telephone').show();
        $('#telephone-repeater').append(item);
        applyMasks();
    });

    $(document).on('click', '.remove-telephone', function(e){
        var obj = e.target;
        if ($('.repeat-telephone').length > 1) {
            $(obj).parents('.repeat-telephone:first').remove();
        }
    });


    $('#addColaborator').on('click', function(e){

        window.livewire.emit('dependentAdded')

        e.preventDefault();
        dependents += 1;

        var items = $('#repeater-colaborator').clone(true);        

        items.find('input').each(function(i,o){            
            
            let placeholder = ($(o).attr('placeholder') ? $(o).attr('placeholder').replace('titular', 'dependente') : '');
            $(o).attr('placeholder', placeholder);
            
            if ($(o).hasClass('financier')) {
                $(o).val(dependents + 1);
                $(o).prop('checked', false);
                $(o).attr('checked', "");
            } else {
                if ($(o).attr('name').indexOf('address') == -1) {
                    $(o).val('');
                }
            }

        });

        var deleteBtn = '<a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>';
        var fieldset = $.parseHTML('<fieldset class="form-group dependent"><span class="count">#' + dependents + '</span><span class="delete-dependent">' + deleteBtn  +'</span></fieldset>');
        
        $(fieldset).append(items);
        $('#dependents').append(fieldset);
        
        applyMasks();
        changeHealthDeclaration();
    })


    $(document).on('click', '.delete-dependent', function(e){
       $('#toDelete').val($(e.target).parents('fieldset:first').index());
    });


    $(document).on('click', '#delete-dependent-confirm', function(e){
        e.preventDefault();
        
        var toRemove = $('#toDelete').val();
        $('fieldset:eq('+ toRemove +')').remove();
        
        recountDependents();
        changeHealthDeclaration();
    });

    $(document).on('keyup', '.cep:first', function(e){
        var objInput = $(e.target);
        const cep = $(e.target).val();
        if (cep.length == 9) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep.replace('-', '') + '/json/',
                success: function(result) {
                    objInput.parents('.address').find('input:eq(1)').val(result.logradouro);
                    objInput.parents('.address').next('.address-city-state').find('input:first').val(result.localidade);
                    objInput.parents('.address').next('.address-city-state').find('input:eq(1)').val(result.uf);
                    objInput.parents('.address').find('input:eq(2)').focus();
                },
                error: function() {
                    alert('Não é possível recuperar o endereço, verifique sua conexão com a internet!');
                }
            });
        }
    });


    $(document).on('change', '.specific-items', function(e){
        var choose = $(e.target).val();
        if (choose != '') {

            var count = 0;
            $('.specific-items').each(function(i,o) {
                if ($(o).val() == choose) {
                    count++;
                    if (count > 1) {
                        alert('Você não pode escolher o mesmo Item da DS');
                        $(e.target).val('');
                    }
                }
            })
            
        } else {
            $(e.target).val('');
            $(e.target).find('option').each(function(i,o){
                $(o).attr('selected', "");
                $(o).removeAttr('selected');
                console.log($(o));
            });
        }
    });


    // $(document).on('click', '.ds-btn', function(e){
    //     e.preventDefault();

    //     const btn = $(e.target);

    //     if (btn.text() == 'Não') {
    //         btn.text('Sim');
    //         btn.val('S');
    //         btn.removeClass('btn-secondary');
    //         btn.addClass('btn-primary');
            
    //     } else {

    //         btn.text('Não');
    //         btn.val('N');
    //         btn.removeClass('btn-primary');
    //         btn.addClass('btn-secondary');
    //     }

    //     setSpecifics(btn.parents('tr:first').index() + 1, btn.val());
    // })

    $(document).on('change', 'input.weight', function(e){
        
        let weight = $(e.target).val();
        let height = $(e.target).parents('div.form-row').find('.height:first').val();
        
        $(e.target).parents('div.form-row').find('.imc-calc:first').val( imcCalc(weight, height).toFixed(2) );
    })

});

function setSpecifics(item_number, item_value) {

    const row = "<div class=\"form-row mb-1 mt-1\">";
    const endRow = "</div>";
    const fieldNumber = "<div class=\"col-1\"><input id=\"specific-"+ item_number +"\" type=\"text\" name=\"comment_number[]\" class=\"form-control comment-number\" placeholder=\"\" value=\"\" /></div>";
    const fieldItem = "<div class=\"col-6\"><input type=\"text\" name=\"comment_item[]\" class=\"form-control\" placeholder=\"comentário\" value=\"\" /></div>";
    const fieldPeriod = "<div class=\"col-3\"><input type=\"text\" name=\"comment_period[]\" class=\"form-control\" placeholder=\"período\" value=\"\" /></div>";
    
    const specifics = $('#comments-by-item');
    
    // console.log(specifics.find('.comment-number:eq("'+ item_number +'")').length, item_number);
    
    if (specifics.find('#specific-'+ item_number).length == 0 && item_value === 'S') {
        specifics.append(row + fieldNumber + fieldItem + fieldPeriod + endRow);
        specifics.find('#specific-'+ item_number).val(item_number);
        specifics.show();
    } else if (item_value === 'N') {
        specifics.find('#specific-'+ item_number).parents('div.form-row:first').remove();
    }

    if (specifics.find('input').length === 0) {
        specifics.hide();
    }

    orderSpecifics();
}

function orderSpecifics() {
    
    $('#comments-by-item').find('div.form-row').each(function(i,o){

        if ( parseInt($(o).find('.comment-number').attr('id').replace('specific-', '')) <  (i + 1) ){
            let obj = $(o).clone();
            $('#comments-by-item').find('label').after(obj);
            $(o).remove();
        }
        
    })

}

function imcCalc(weight, height) {
    return weight / (height * height);
}


function recountDependents() {    

    //if ($('fieldset.dependent').length > 0) {
        
        var count = 0
        $('fieldset.dependent').each(function(i,o){
            $(o).find('span.count').html('#' + (i + 1));
            //console.log('conta ' + i);
            //$(o).find('input,select').attr('name', $(o).find('input,select').attr('name').replace(/dependent\[[0-9]*\]/gm, '[' + (i + 1) + ']'));
            if ($(o).find('input[type=radio]').each(function(index,obj){
                if ($(obj).hasClass('financier')){
                    $(obj).val(i + 2);
                }
            })) 
        
            count++;

        });
        //console.log('conta todos: ' + count);
        dependents = count;

    //}

}   