# AlcoolPlus
Teste prático. Sistema para fornecimento de álcool em gel para clientes sob controle de administradores.

## Sobre o Sistema
Alcool+ é um pequeno sistema onde os clientes cadastrados poderam solicitar Alcool em gel para seus determinados fornecedores. 
Cada fornecedor poderá se cadastrar e publicar novos produtos sobre o controle e supertvisão da administração geral do sistema.

## Instalação
- Para o funcionamento imediato do sistema, basta descompactar os arquivos na pasta correta do servidor web.
Também será necessário realizar a importação do arquivo alcoolPlus.sql no banco de dados. 
-Para conexão no banco de dados o usuário e senha estão definidos como padrão.
usuario: 'root'
senha: ''

## Ferramentas utilizadas
O sistema foi construído código a código usando as seguintes tecnologias:
- PHP 7.4
- HTML 5
- CSS 3
- JavaScript
- Mysql
- WampServer
- IDE NetBeans 12.0
- Não foi utilizado nenhuma biblioteca ou frameworks para desenvolvimento (exeto Jquery). 

- Importante salientar que o sistema foi construido com PHP 7.4. Fazendo uso de propriedades tipadas.
Sendo assim o sistema poderá não funcionar corretamente se for utilizado em uma versão anterior a essa.

## Funcionamento geral
#### Cliente
Será permitido um unico CPF por cadastro. Deverá ser informado nome, cpf, marcações para Asma, Hipertensão, Diabetes e Fumante além de senha e confirmação de senha. <br />
(As opções para Asma, Hipertensão, Diabetes e Fumante são para o calculo de prioridade de cada cliente). <br/ >
Em sua tela inicial será exibido todos seus pedidos seguidos dos respectivos status(entregue/não entrgue). 
Além da informação se o cliente pode ou não realizar um novo pedido e a quantidade de produtos permitidos <br />  
Terá um menu com opção onde os clientes podem realizar novos pedidos para os fornecedores.

#### Estabelecimentos/Fornecedores
Será permitido um unico CNPJ por cadastro. Deverá ser informado nome, cnpj, cidade, senha e confirmação de senha. <br />
Em sua tela inicial será exibido todos os pedidos recebidos dos cliente seguidos da opção para realizar a entrega. <br />
Os pedidos são exibidos em ordem de prioridade dos clientes.
Haverá um menu com opção de criar novos produto informando a descrição e o preço de cada um. 
Essa funcionalidade só será disponibilizada se o estabelecimento/fornecedor já estiver liberado pelo Administrador 

#### Administrador
Será permitido um unico CPF por cadastro. Deverá ser informado nome, cpf, senha e confirmação de senha. <br />
No painel inicial será exibido os fornecedores cadastrados que estão aguardando liberação. <br />
Haverá um menu com opções para vizualização dos clientes cadastrados e definições de regra geral do sistema.

## Funcionamento
- Para facilitar e servir de exemplo, foi gravado um registro de cada tipo no banco de dados.
- O cliente só pode solicitar produtos se algum estabelecimento já estiver cadastrado, e se algum produto também já estiver cadastrado
- O estabelecimento só pode cadastro novos produtos se o Administrador libera-lo. O preço obrigatoriamente deve estar entre os valores definidos pelo Administrador.
- O Administrador poderá vizualiar os estabelecimentos que aguardam liberam, além de ver os produtos e clientes cadastrados.
- O foi construído com uso de sessões, sendo assim, haverá uma opção de logout em cada tela de painel.

## Credits

- [Rodolfo J.Silva](https://github.com/lrodolfol) (Developer)
- [LinkeIn](https://www.linkedin.com/in/rodolfoj-silva/)
- [Email](rodolfo0ti@gmail.com)

## License
The MIT License (MIT).
