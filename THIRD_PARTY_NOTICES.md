# Third-Party Notices

O DDI-Graph utiliza softwares, bibliotecas, recursos visuais e fontes de dados desenvolvidos e disponibilizados por terceiros.

A licença MIT adotada pelo DDI-Graph aplica-se ao seu conteúdo autoral, não substituindo as licenças dos componentes externos utilizados pelo projeto.

## 1. Dependências de software

### Backend e desenvolvimento

| Componente | Licença |
| --- | --- |
| [PHP](https://www.php.net/) | PHP-3.01 |
| [Laravel](https://github.com/laravel/framework) | MIT |
| [Laravel Tinker](https://github.com/laravel/tinker) | MIT |
| [PostgreSQL](https://www.postgresql.org/) | PostgreSQL |
| [Python](https://www.python.org/) | PSF-2.0 |
| [Pest](https://github.com/pestphp/pest) | MIT |
| [PHPUnit](https://github.com/sebastianbergmann/phpunit) | BSD-3-Clause |
| [Faker](https://github.com/FakerPHP/Faker) | MIT |
| [Mockery](https://github.com/mockery/mockery) | BSD-3-Clause |
| Laravel Pail, Pint e Pao | MIT |
| [Collision](https://github.com/nunomaduro/collision) | MIT |

### Frontend

| Componente | Licença |
| --- | --- |
| [Cytoscape.js](https://github.com/cytoscape/cytoscape.js) | MIT |
| [Bootstrap](https://github.com/twbs/bootstrap) | MIT |
| [Bootstrap Icons](https://github.com/twbs/icons) | MIT |
| [Tailwind CSS](https://github.com/tailwindlabs/tailwindcss) | MIT |
| [Vite](https://github.com/vitejs/vite) | MIT |
| [Laravel Vite Plugin](https://github.com/laravel/vite-plugin) | MIT |
| [Concurrently](https://github.com/open-cli-tools/concurrently) | MIT |
| [Lucide](https://github.com/lucide-icons/lucide) | ISC, com componentes derivados de Feather sob MIT |
| [Inter](https://github.com/rsms/inter) | OFL-1.1 |

### Dependências transitivas

As dependências diretas e transitivas estão registradas nos arquivos `composer.lock` e `package-lock.json`.

Entre as licenças declaradas por essas dependências encontram-se:

- MIT
- ISC
- BSD-3-Clause
- 0BSD
- Apache-2.0
- MPL-2.0
- OFL-1.1
- CC0-1.0 (como alternativa de licenciamento)
- GPL-2.0-only e GPL-3.0-only (como alternativas de licenciamento oferecidas por determinados pacotes também disponibilizados sob BSD-3-Clause)

Os textos integrais das licenças e os avisos de direitos autorais devem ser preservados conforme as condições aplicáveis à redistribuição de cada componente.

## 2. Recursos visuais

O projeto utiliza ícones provenientes do Lucide, incluindo elementos derivados do projeto Feather, e a família tipográfica Inter, disponibilizada por meio do Fontsource.

- Lucide: ISC.
- Feather: MIT.
- Inter: SIL Open Font License 1.1.

Os respectivos direitos autorais permanecem pertencentes aos seus titulares originais.

## 3. Fontes de dados

### DDInter

Base de dados de interações medicamentosas utilizada na pesquisa.

- Fonte: https://ddinter.scbdd.com/
- Licença: CC BY-NC-SA 4.0.
- Publicação de referência: https://doi.org/10.1093/nar/gkab880

### DDInter — mnarayan1

Fonte auxiliar para o mapeamento entre identificadores DDInter e DrugBank.

- Repositório: https://github.com/mnarayan1/DDInter
- Arquivo utilizado: `drug_data.json`.
- Licenciamento próprio: não explicitamente declarado.

### ATC-drugs-class.db

Fonte auxiliar para associação de medicamentos aos códigos ATC e obtenção das classificações terapêuticas.

- Repositório: https://github.com/theoffbeatdoc/ATC-drugs-class.db
- Arquivos utilizados: `drugs_list.json` e `drugs_atc.json`.
- Licença declarada: CC BY-SA 4.0.

As bases de dados originais e seus derivados não são distribuídos pelo DDI-Graph. Sua obtenção e utilização estão sujeitas às condições estabelecidas por seus respectivos titulares, incluindo eventuais direitos sobre fontes de dados subjacentes.

Os scripts disponibilizados pelo DDI-Graph destinam-se à preparação local dos dados para fins de reprodução da pesquisa.

## 4. Avisos de direitos autorais

### Lucide

Os ícones incorporados ao diretório `resources/views/icons/` são provenientes do projeto [Lucide](https://github.com/lucide-icons/lucide), disponibilizado sob a licença ISC, incluindo componentes derivados do projeto Feather, disponibilizados sob a licença MIT.

#### ISC License

Copyright (c) 2026 Lucide Icons and Contributors

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.

### Feather

Parte dos ícones disponibilizados pelo Lucide deriva do projeto [Feather](https://github.com/feathericons/feather).

#### MIT License

Copyright (c) 2013-present Cole Bemis

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

### Laravel

A estrutura inicial da aplicação foi desenvolvida a partir do projeto [Laravel](https://github.com/laravel/laravel), disponibilizado sob a licença MIT. Os componentes provenientes dessa estrutura permanecem sujeitos à sua licença original.

## 5. Considerações finais

Nenhuma disposição da licença do DDI-Graph implica a transferência de direitos sobre componentes ou dados de terceiros.

Os direitos autorais, marcas e demais direitos de propriedade intelectual permanecem pertencentes aos seus respectivos titulares.