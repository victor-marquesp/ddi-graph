# Reprodutibilidade experimental

Este documento registra as fontes de dados, os procedimentos de processamento, os parâmetros experimentais e as características do ambiente utilizado na pesquisa do DDI-Graph.

## 1. Proveniência dos dados

| Fonte | Arquivos | Data de obtenção | Versão ou commit |
| --- | --- | --- | --- |
| DDInter | `ddinter_downloads_*.csv` | 11/07/2026 | 1.0 |
| mnarayan1/DDInter | `drug_data.json` | 11/07/2026 | 15757ad550bff06b393d70fc640487deee5ddea2 |
| ATC-drugs-class.db | `drugs_list.json` | 11/07/2026 | d98d6b0651cde2e812e480695a265c3f766da9a5 |
| ATC-drugs-class.db | `drugs_atc.json` | 11/07/2026 | 7e7238c1eb20e6d957c0a85afe56206417125a32 |

Os hashes SHA-256 dos arquivos originais e processados estão registrados em [`SHA256SUMS`](SHA256SUMS).

## 2. Processamento dos dados

A preparação dos dados é realizada pelo script `scripts/extract.py`, compreendendo:

1. Extração dos medicamentos e interações provenientes do DDInter.
2. Eliminação de auto-interações e duplicidades.
3. Exclusão de interações com níveis de gravidade conflitantes.
4. Seleção dos níveis de gravidade Minor, Moderate e Major.
5. Associação dos identificadores DDInter aos identificadores DrugBank.
6. Associação dos medicamentos aos códigos ATC.
7. Seleção de medicamentos com classificação ATC inequívoca de segundo nível.
8. Exportação dos registros normalizados em formato CSV.

### Dataset resultante

| Entidade | Quantidade de registros |
| --- | ---: |
| Classificações terapêuticas | 61 |
| Medicamentos | 1.367 |
| Interações medicamentosas | 70.919 |

## 3. Ambiente experimental

| Componente | Especificação |
| --- | --- |
| Sistema operacional | Fedora 44 |
| Processador | Intel Core i3-1115G4 |
| Núcleos físicos | 2 |
| Threads | 4 |
| Memória RAM disponível | 3,5 GiB |
| PHP | 8.5.12 |
| PostgreSQL | 18.7 |
| Laravel | 13.27.0 |
| Python | 3.14.10 |
| Limite de memória do PHP | 1024 MiB |

## 4. Parâmetros e determinismo

### Processamento

- Script: `scripts/extract.py`.
- Parâmetro `--limit`: não utilizado na geração do dataset experimental completo.
- Semente fixa: 42.
- Método de amostragem opcional: `random.Random(42).sample()`, aplicado aos identificadores externos previamente ordenados.

A semente do script de extração é utilizada exclusivamente quando é definido um limite de medicamentos.

### Benchmark

- Comando: `graph:benchmark`.
- Método de seleção: ordenação determinística dos identificadores internos por hash SHA-256.
- Prefixo fixo aplicado ao hash: `42:`.
- Execuções independentes por cenário: 10.
- Iterações cronometradas por operação: 1.000.
- Execuções de aquecimento por medição: 1.
- Total de execuções independentes: 50.

A seleção dos medicamentos utiliza a expressão:

`SHA-256("42:" + id)`

Os identificadores são ordenados lexicograficamente de acordo com seus hashes, permitindo a construção de subconjuntos cumulativos.

## 5. Cenários experimentais

| Cenário | Medicamentos | Interações |
| ---: | ---: | ---: |
| 1 | 50 | 115 |
| 2 | 100 | 401 |
| 3 | 200 | 1.777 |
| 4 | 500 | 10.280 |
| 5 | 1.367 | 70.919 |

As interações são selecionadas considerando exclusivamente aquelas cujas duas extremidades pertencem ao subconjunto de medicamentos de cada cenário.

## 6. Resultados

Os resultados experimentais originais estão disponíveis no diretório `benchmarks/`.

As medições incluem:

- Integridade da conversão.
- Tempo de recuperação dos dados relacionais.
- Tempo de construção do grafo.
- Tempo de cálculo das métricas.
- Consumo de memória.
- Equivalência e desempenho das operações relacionais e de grafo.
- Métricas estruturais da rede.

Diferentes configurações de hardware e software podem produzir variações nas medições de desempenho, ainda que sejam utilizados os mesmos dados e parâmetros experimentais.