# Controle Financeiro

Esse sistema foi desenvolvido em 2015, quando eu estava fazendo o curso técnico em informática para internet, 
no Senac em Piracicaba, SP.

Foi desenvolvido em PHP com banco MySQL e utilizei o framework Bootstrap v3 para a tela. Está 
sem nenhum padrão de projeto e/ou arquitetura.

## Objetivo

Com esse repositório pretendo deixar disponível a ideia que tive naquela época, pois hoje eu já 
sigo padrões de desenvolvimento mais fáceis de dar manutenção.

## Execução

Para rodar é necessário criar um banco chamado financeiro_db e executar o script banco\financeiro_db.sql, 
que fará o cadastro dos usuários com alguns dados pré-cadastrados para acesso.

O usuário "administrador" tem acesso de administração dos usuários cadastrados, podendo ativar, inativar ou bloquear 
os usuários. Os demais usuários poderão acessar o sisema com as suas devidas movimentações.

A senha é guardada no banco criptografada com o padrão sha1, sendo "123" para os usuários pré-cadastrados no 
script.