window.$ = window.jQuery = require('jquery');
require('jquery-mask-plugin');

$(document).ready(function($){


    $('.cnpj').mask('00.000.000/0000-00');
    $('.telefone').mask('(00) 0000-0000');


});