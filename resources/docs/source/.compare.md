---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Processos


API para gerenciamento de processos
<!-- START_80ba9d30989eb9ca06949165d37a7ffc -->
## API online

Verifica se a API está online (healthcheck)

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/v1/ping" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/v1/ping"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "success"
}
```

### HTTP Request
`GET api/v1/ping`


<!-- END_80ba9d30989eb9ca06949165d37a7ffc -->

<!-- START_d7f08ad9784c5cc74b394ae5f67f927d -->
## Novo Processo

Cria um novo processo no sistema da Medi

> Example request:

```bash
curl -X POST \
    "http://localhost/api/v1/novoprocesso" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"users":[{"first_name":"John"}],"yet_another_param":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/v1/novoprocesso"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "users": [
        {
            "first_name": "John"
        }
    ],
    "yet_another_param": {}
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/v1/novoprocesso`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `users.*.first_name` | string |  optional  | The first name of the user.
        `yet_another_param` | object |  required  | Some object params.
    
<!-- END_d7f08ad9784c5cc74b394ae5f67f927d -->


