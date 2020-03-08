window.$ = window.jQuery = require('jquery');
var Inputmask = require('inputmask');
// require('jquery-validation');

var dependents = 0;

$(document).ready(function($){

    recountDependents();

    // $('.telephone').inputmask('(00) 0000-0000');$('.telephone').inputmask('(00) 0000-0000');
    // $('.cep').inputmask('00000-000');
    // $('.cpf').inputmask('000.000.000-00');

    Inputmask({"mask": "99/99/9999", placeholder: ""}).mask('.date-br');
    Inputmask({"mask": "999.999.999-99", placeholder: ""}).mask('.cpf');
    Inputmask({"mask": "99999-999", placeholder: ""}).mask('.cep');
    Inputmask({"mask": "(99)99999-9999", placeholder: ""}).mask('.telephone');

    
    $('#addTelephone').on('click', function(e){
        e.preventDefault();
        var item = $('.repeat-telephone:first').clone();
        item.find('input').val('');
        Inputmask({"mask": "(99)99999-9999", placeholder: ""}).mask(item.find('input'));
        item.find('.remove-telephone').show();
        $('#telephone-repeater').append(item);
    });

    $(document).on('click', '.remove-telephone', function(e){
        var obj = e.target;
        if ($('.repeat-telephone').length > 1) {
            $(obj).parents('.repeat-telephone:first').remove();
        }
    });


    $('#addColaborator').on('click', function(e){
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
                $(o).val('');
            }

        });

        var deleteBtn = '<a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>';
        var fieldset = $.parseHTML('<fieldset class="form-group dependent"><span class="count">#' + dependents + '</span><span class="delete-dependent">' + deleteBtn  +'</span></fieldset>');
        
        $(fieldset).append(items);
        $('#dependents').append(fieldset);
        
        Inputmask({"mask": "99/99/9999", placeholder: ""}).mask('.date-br');
        Inputmask({"mask": "999.999.999-99", placeholder: ""}).mask('.cpf');
        Inputmask({"mask": "99999-999", placeholder: ""}).mask('.cep');

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

    $(document).on('keyup', '.cep', function(e){
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

    $(document).on('change', '#health-declaration', function(e){

        openHealthDeclaration($(e.target).val());        
        $('#health-declaration-comments').show();

    });    


    if ($('#health-declaration').find('option:selected').val() > 0) {
        $('#health-declaration').trigger('change');
    }

});


function changeHealthDeclaration() {

    if ($('#health-declaration-table').find('tbody > tr').length > 0) {

        var table = $('#health-declaration-table');
        num_dependents = dependents + 3;

        var head = table.find('thead').clone(); 
        var body = table.find('tbody').clone();
        
        //console.log(head.find('th').length);
        //console.log(num_dependents);

        if (head.find('th').length > num_dependents) {
            console.log('retirar');
            head.find('th:eq('+ (head.find('th').length - 1) + ')').remove();
            
            body.find('tr').each(function(i,o){
                $(o).find('td:eq('+ (head.find('td').length - 1) +')').remove();  
            });

        } else if (num_dependents > head.find('th').length) {
            
                
            head.find('tr:first').append("<th>Dependente " + ((head.find('th').length - 3) + 1) + "</th>")
            
            body.find('tr').each(function(i,o){
                $(o).append("<td><input class='form-control col-4 text-center' type='text' required name=\"dependent_" + (head.find('th').length - 3) + "[]\"></td>");  
            });

        }
    
        table.find('thead').html(head.html());
        table.find('tbody').html(body.html());
    } 
    
}


function openHealthDeclaration(model_id) {
    
    var item_number = 0;

    $.ajax({
        url: '/api/quizzes/' + model_id,
        success: function(results) {
            
            var table = "<thead>";
            table += "<tr>";
            table += "<th>#</th>";
            table += "<th>Pergunta</th>";
            for(var j = 0; j <= dependents; j++){
                if (j == 0) {
                    table += "<th>Titular</th>";
                } else {
                    table += "<th>Dependente " + j + "</th>";
                }
            }
            table += "</tr>";
            table += "</thead><tbody>";
            for(i in results.questions) {
                item_number++;
                table += "<tr><td><input type=\"hidden\" name=\"item_number[]\" value=\""+ item_number +"\" />" + item_number + "</td>";
                table += "<td><input type=\"hidden\" name=\"question[]\" value=\""+ results.questions[i].question +"\" />" + results.questions[i].question + "</td>";
                for(var j = 0; j <= dependents; j++){
                        if (j == 0) {
                            table += "<td><input class='form-control col-4 text-center' type='text' required name=\"holder_answer[]\" value=\""+ ( $('#holder_answer\\.' + (item_number - 1)).length > 0 ? $('#holder_answer\\.' + (item_number - 1)).val() : '' ) +"\"></td>";
                        } else {
                            table += "<td><input class='form-control col-4 text-center' type='text' required name=\"dependent_" + j + "[]\" value=\""+ ( $('#dependent_' + j + '\\.' + (item_number - 1)).length > 0 ? $('#dependent_' + j + '\\.' + (item_number - 1)).val() : '') +"\"></td>";
                        }
                }
                table += "</tr>";
            }
            table += "</tbody>";

            $('#health-declaration-table').html(table);

            $('#comments-by-item').toggle();

        }
    })

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