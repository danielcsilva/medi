<?php

/* Beneficiaries */
Breadcrumbs::for('beneficiaries', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));

    if ($content == 'list'){
        $trail->push('Beneficiários');
    } else {
        $trail->push('Beneficiários', route('beneficiaries.index'));
    }

    if ($content == null) {
        $trail->push('Novo Beneficiário');
    } else if(is_object($content)){
        $trail->push($content->name);
    }   

});

/* Companies */
Breadcrumbs::for('companies', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Clientes');
    } else {
        $trail->push('Clientes', route('companies.index'));
    }

    if ($content == null) {
        $trail->push('Nova Empresa');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});

/* Health Plan */
Breadcrumbs::for('healthplans', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Operadoras de Saúde');
    } else {
        $trail->push('Operadoras de Saúde', route('healthplans.index'));
    }

    if ($content == null) {
        $trail->push('Nova Operadora de Saúde');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});

Breadcrumbs::for('inconsistencies', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Inconsistências');
    } else {
        $trail->push('Inconsistências', route('inconsistencies.index'));
    }

    if ($content == null) {
        $trail->push('Nova Inconsistência');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});

Breadcrumbs::for('accessions', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content === 'list'){
        $trail->push('Processos');
    } else {
        $trail->push('Processos', route('accessions.index'));
    }

    if ($content == null) {
        $trail->push('Novo Processo');
    } else if(is_object($content)){
        $trail->push($content->proposal_number . ' - ' . ($content->company->name ?? ''));
    }

});

Breadcrumbs::for('accessions-contact', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    $trail->push('Processos para Contato', url('/tocontact/accessions'));
    $trail->push($content->proposal_number . ' - ' . ($content->company->name ?? ''));

});

Breadcrumbs::for('quizzes', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Modelos de DS');
    } else {
        $trail->push('Modelos de DS', route('quizzes.index'));
    }

    if ($content == null) {
        $trail->push('Nova Declaração de Saúde');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});


Breadcrumbs::for('healthquestions', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Questões');
    } else {
        $trail->push('Questões', route('healthquestions.index'));
    }

    if ($content == null) {
        $trail->push('Nova Questão');
    } else if(is_object($content)){
        $trail->push($content->question);
    }

});


Breadcrumbs::for('suggestions', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Sugestões');
    } else {
        $trail->push('Sugestões', route('suggestions.index'));
    }

    if ($content == null) {
        $trail->push('Nova Sugestão');
    } else if(is_object($content)){
        $trail->push($content->suggestion);
    }

});


Breadcrumbs::for('riskgrades', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Graus de Risco');
    } else {
        $trail->push('Graus de Risco', route('riskgrades.index'));
    }

    if ($content == null) {
        $trail->push('Novo Grau de Risco');
    } else if(is_object($content)){
        $trail->push($content->risk);
    }

});


Breadcrumbs::for('statusprocess', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Status do Processo');
    } else {
        $trail->push('Status do Processo', route('statusprocess.index'));
    }

    if ($content == null) {
        $trail->push('Novo Status do Processo');
    } else if(is_object($content)){
        $trail->push($content->status);
    }

});

Breadcrumbs::for('processtypes', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Tipo de Movimentação');
    } else {
        $trail->push('Tipo de Movimentação', route('processtypes.index'));
    }

    if ($content == null) {
        $trail->push('Novo Tipo de Movimentação');
    } else if(is_object($content)){
        $trail->push($content->type_of_process);
    }

});


Breadcrumbs::for('users', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    $trail->push('Usuários', ($content != 'list' ? route('users.index') : ''));

    $trail->push(($content == null ? 'Novo Usuário' : $content->name ?? ''));

});

Breadcrumbs::for('roles', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    $trail->push('Grupos', ($content != 'list' ? route('roles.index') : ''));

    $trail->push(($content == null ? 'Novo Grupo' : $content->name ?? ''));

});


Breadcrumbs::for('dashboards', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Painéis (dashboards)');
    } else {
        $trail->push('Painéis', route('dashboards.index'));
    }

    if ($content == null) {
        $trail->push('Novo Painel (dashboards)');
    } else if(is_object($content)){
        $trail->push($content->label);
    }

});