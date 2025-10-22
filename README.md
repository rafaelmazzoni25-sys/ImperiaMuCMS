# ImperiaMuCMS

## Visão geral
ImperiaMuCMS é um CMS em PHP para servidores Mu Online. O ponto de entrada (`index.php`) carrega o bootstrap `includes/imperiamucms.php`, que inicializa sessões, define caminhos globais e importa todas as classes utilizadas pelo site e pelos painéis administrativos.【F:index.php†L1-L30】【F:includes/imperiamucms.php†L10-L158】 O projeto já inclui módulos públicos, painel administrativo (`admincp`) e painel de Game Masters (`gmcp`), além de integrações com sistemas de doação e APIs externas.

## Estrutura do projeto
- `admincp/`: módulos e lógica do painel administrativo, incluindo geradores de configuração do site.【F:admincp/modules/website_config.php†L208-L339】
- `api/`: endpoints utilizados por sistemas de votação, gateways de pagamento e integrações diversas.
- `cron/`: scripts agendados para tarefas recorrentes.
- `gmcp/`: painel para Game Masters com módulos específicos.【F:gmcp/index.php†L8-L12】
- `includes/`: núcleo da aplicação (classes, funções auxiliares, cache, configurações e templates de e-mail).【F:includes/imperiamucms.php†L92-L158】【F:includes/functions/function.config.php†L29-L59】
- `modules/`: módulos públicos exibidos no site (login, rankings, usercp etc.).【F:modules/login.php†L4-L36】
- `templates/`: temas front-end (arquivos HTML, CSS e JS) carregados conforme definido em configuração.【F:includes/imperiamucms.php†L94-L123】
- `languages/`: arquivos de internacionalização utilizados pelos módulos.
- `install/`: instalador web com checagens de ambiente e geração inicial de configuração.【F:install/systemcheck.php†L9-L136】【F:install/config.php†L4-L21】
- `__logs/`: diretório usado para armazenar logs de acesso e SQL quando habilitados.【F:index.php†L11-L25】

## Requisitos de ambiente
O instalador valida se o ambiente possui:
- PHP 7.2 ou superior com `short_open_tag` habilitado.
- Extensões PHP: cURL, BCMath, GD, OpenSSL, session, SimpleXML, XML, XMLReader, XMLWriter e pelo menos um driver PDO para MSSQL (`pdo_dblib`, `PDO_SQLSRV` ou `PDO_ODBC`).
- Servidor web com `mod_rewrite` ativo (ou verificação manual caso `apache_get_modules` não exista).
- Permissões de escrita para pastas de cache, configuração e logs listadas pelo instalador, além do arquivo `includes/config.php`.
Esses requisitos estão descritos em `install/systemcheck.php` e devem ser atendidos antes de habilitar o site.【F:install/systemcheck.php†L9-L137】

## Fluxo de inicialização
Ao carregar o site:
1. `index.php` garante que `system.php` existe e importa `includes/imperiamucms.php`.【F:index.php†L3-L10】
2. `includes/imperiamucms.php` inclui `includes/config.php`, aplica fuso horário, define constantes de caminho, controla modo de manutenção e carrega as classes de banco de dados, autenticação, validação e utilidades.【F:includes/imperiamucms.php†L10-L158】
3. As classes utilizam os valores de `$config` (definidos em `includes/config.php`) para conectar ao banco de dados, controlar logs e demais funcionalidades.【F:includes/classes/class.database.php†L9-L61】

## Sistema de módulos
Cada módulo público chama `loadModuleConfigs('<nome>')`, que converte o XML correspondente em `includes/config/modules/<nome>.xml` para o array global `$mconfig`. As funções `mconfig()` e `gconfig()` consultam esses arrays para habilitar/desabilitar recursos e carregar parâmetros de execução.【F:includes/functions/function.config.php†L29-L101】 Exemplo: o módulo de login exige que a chave `active` esteja habilitada no XML para exibir o formulário.【F:modules/login.php†L4-L36】

## Diagnóstico: por que há módulos inoperantes
- O arquivo crítico `includes/config.php` está vazio no repositório, portanto `$config` nunca é populado. Quando `includes/imperiamucms.php` tenta acessá-lo, faltam informações essenciais como fuso horário, credenciais de banco, template ativo e flags de manutenção, quebrando a inicialização de classes e módulos.【F:includes/imperiamucms.php†L26-L123】【F:includes/classes/class.database.php†L9-L61】
- O instalador deveria gerar esse arquivo, mas o script `install/config.php` abre `includes/config.php` e imediatamente encerra a execução com `exit("Unable to open file!")`, impedindo que qualquer conteúdo seja gravado e deixando o CMS sem configuração global.【F:install/config.php†L4-L21】
- Sem `$config`, chamadas como `mconfig('active')` retornam `null`, o que leva os módulos a exibir mensagens de erro ou simplesmente não renderizar conteúdo.【F:modules/login.php†L10-L36】【F:includes/functions/function.config.php†L29-L59】 Além disso, o conector de banco (`class.database.php`) não consegue inicializar porque os parâmetros SQL esperados não existem.【F:includes/classes/class.database.php†L9-L61】
- Mesmo com a configuração preenchida, diversos módulos “premium” fazem duas verificações de licença (`license/<módulo>.imperiamucms`). Como o repositório só inclui `includes/license/license.imperiamucms`, essas checagens disparam exceções ([700], [705], etc.), impedindo o carregamento de recursos como Bug Tracker, Market, Cash Shop, Wheel of Fortune e outros listados em `MODULE_STATUS.md`.【F:includes/classes/class.database.php†L520-L724】【F:modules/bugtracker.php†L9-L18】

## Como corrigir e configurar
1. **Gerar `includes/config.php`:**
   - Utilize o formulário “Website Config” do painel administrativo ou replique manualmente o template gerado por `admincp/modules/website_config.php`, que grava todas as chaves necessárias no arquivo via `file_put_contents` quando os diretórios são graváveis.【F:admincp/modules/website_config.php†L208-L215】
   - Caso o instalador continue encerrando precocemente, ajuste `install/config.php` para testar o retorno de `fopen()` antes de chamar `exit`, permitindo que o restante do fluxo escreva o arquivo.
2. **Preencher credenciais do banco de dados e chaves de segurança:** garanta que os campos SQL (`SQL_DB_HOST`, `SQL_DB_NAME`, `SQL_PDO_DRIVER`, etc.) contenham valores válidos; essas informações são consumidas por `class.database.php` e por todas as classes que dependem de consultas MSSQL.【F:includes/classes/class.database.php†L9-L61】【F:admincp/modules/website_config.php†L208-L339】
3. **Revisar permissões de escrita:** confirme que as pastas mencionadas no instalador permanecem com `chmod 0777` (ou permissões equivalentes) para permitir cache de módulos, logs e atualização de configurações.【F:install/systemcheck.php†L103-L120】
4. **Validar arquivos XML de módulos:** para cada funcionalidade desejada, certifique-se de que o respectivo arquivo em `includes/config/modules/` esteja marcado como ativo e com parâmetros corretos antes de habilitar o módulo correspondente.【F:includes/functions/function.config.php†L29-L101】

## Próximos passos recomendados
- Após gerar `includes/config.php`, limpe os caches em `includes/cache` e revalide os módulos mais críticos (login, registros, rankings).
- Considere versionar um `config.php` de exemplo com placeholders (fora do repositório público) para acelerar futuras instalações.
- Automatize a correção do instalador para evitar que o problema retorne em ambientes novos.
- Configure cron jobs e APIs conforme necessário para votações, doações e tarefas automáticas presentes no diretório `cron/` e na pasta `api/`.
