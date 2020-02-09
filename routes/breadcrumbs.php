<?php

/* Beneficiaries */
Breadcrumbs::for('beneficiaries', function ($trail, $content) {

    $trail->push('Home', route('home'));

    if ($content == 'list'){
        $trail->push('Beneficiários');
    }

    if ($content == null) {
        $trail->push('Novo Beneficiário');
    } else if(is_object($content)){
        $trail->push($content->name);
    }   

});

/* Companies */
Breadcrumbs::for('companies', function ($trail, $content = null) {

    $trail->push('Home', route('home'));
    
    if ($content == 'list'){
        $trail->push('Empresas');
    } else {
        $trail->push('Empresas', route('companies.index'));
    }

    if ($content == null) {
        $trail->push('Nova Empresa');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});