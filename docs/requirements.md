## 1. Regras de Negócio

| Identificação | Descrição |
| --- | --- |
| RN001 | Medicamentos devem possuir um identificador, nome, classificação e opcionalmente uma descrição. |
| RN002 | Os medicamentos devem ser identificados por sua denominação do princípio ativo, não sendo considerados nomes comerciais. |
| RN003 | Uma classificação farmacológica deve ser uma entidade à parte. |
| RN004 | Uma classificação farmacológica deve possuir um identificador, nome e opcionalmente uma descrição. |
| RN005 | O nome de uma classificação deve ser único. |
| RN006 | As classificações farmacológicas associadas aos medicamentos devem ser referentes à sua classe terapêutica. |
| RN007 | Cada medicamento deve estar associado a apenas uma classificação. |
| RN008 | Uma classificação não poderá ser excluída enquanto possuir medicamentos associados. |
| RN009 | Entre dois medicamentos distintos pode existir no máximo uma interação. |
| RN010 | Uma interação só pode estar associada a exatamente dois medicamentos distintos. |
| RN011 | Um medicamento não pode possuir interação consigo mesmo. |
| RN012 | Uma interação deve conter os identificadores dos medicamentos a ela associados, gravidade e opcionalmente uma descrição. |
| RN013 | A gravidade da interação deve pertencer a um conjunto enumerado com os seguintes valores possíveis:<br>• LEVE<br>• MODERADA<br>• GRAVE<br>• CONTRAINDICADA |
| RN014 | Quando informada, a descrição da interação deve apresentar uma explicação sobre a interação entre os medicamentos. |
| RN015 | A exclusão de um medicamento deve excluir automaticamente todas as interações a ele associadas. |
| RN016 | O sistema deve possuir contas apenas para usuários administradores. |
| RN017 | Somente administradores devem ser capazes de manter (CRUD) medicamentos, classificações, interações e contas. |
| RN018 | Um administrador não deve ser capaz de deletar uma conta se ela for a última cadastrada no sistema. |
| RN019 | Uma conta de administrador deve possuir um identificador, email e senha. |
| RN020 | A autenticação de administradores deve ser validada com login e senha. |
| RN021 | Usuários comuns não devem possuir conta e acessam o sistema de forma anônima, apenas para consulta e visualização das interações. |
| RN022 | O sistema deve permitir que o usuário forneça uma lista de medicamentos selecionados e visualize as interações entre eles. |
| RN023 | A representação visual em grafo deve ser interativa, permitindo a exploração das conexões entre os medicamentos. |
| RN024 | As métricas calculadas sobre a rede de interações devem ser apresentadas ao usuário de forma organizada e acessível na interface do sistema. |
| RN025 | O sistema deve informar de forma visível que as informações apresentadas possuem caráter educacional e não substituem avaliação ou orientação profissional. |

## 2. Requisitos Funcionais

| Identificação | Descrição | Regras de Negócio Envolvidas (0..N) |
| --- | --- | --- |
| RF001 | Manter medicamentos (CRUD). | RN001, RN002, RN007 |
| RF002 | Manter classificações (CRUD). | RN003, RN004, RN005, RN006, RN008 |
| RF003 | Manter interações (CRUD). | RN009, RN010, RN011, RN012, RN013, RN014, RN015 |
| RF004 | Controlar o acesso às funcionalidades administrativas. | RN017, RN021 |
| RF005 | Manter contas de administradores (CRUD). | RN018, RN019 |
| RF006 | Autenticar administradores. | RN016, RN020 |
| RF007 | Permitir consulta de interações. | RN022 |
| RF008 | O sistema deve converter os dados de medicamentos e interações, armazenados em um banco relacional, para uma estrutura de grafo. | — |
| RF009 | Permitir a visualização de interações em diferentes formas de representação, incluindo:<br>• Representação textual ou tabular, contendo as informações das interações.<br>• Representação em grafo, exibindo os medicamentos como nós e suas interações como arestas. | RN023 |
| RF010 | Permitir a alternância entre as diferentes formas de visualização das interações. | — |
| RF011 | Gerar métricas relacionadas à rede de interações medicamentosas. | RN024 |
| RF012 | O sistema deve exibir avisos informando que as informações apresentadas não substituem avaliação ou orientação profissional. | RN025 |

## 3. Requisitos Não Funcionais

| Identificação | Descrição |
| --- | --- |
| RNF001 | O sistema deve utilizar um algoritmo de conversão de dados relacionais em estruturas de grafos em memória. |
| RNF002 | O sistema deve ser web. |
| RNF003 | O sistema deve utilizar banco de dados relacional para armazenamento de dados. |
| RNF004 | O sistema deve utilizar bibliotecas de visualização de grafos no frontend. |
| RNF005 | O sistema deve utilizar arquitetura MVC, com camadas de organização que separam a lógica de negócio. |
| RNF006 | Os dados utilizados para povoamento e testes do sistema devem ser obtidos de bases públicas ou fontes de dados farmacológicos adequadas ao escopo do trabalho. |
| RNF007 | A interface do sistema deve ser responsiva. |
