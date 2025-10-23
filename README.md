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

## Diagnóstico: por que o projeto não funciona “out of the box”
- O arquivo `includes/license/license.imperiamucms` versionado contém apenas a URL `http://mu-loc.com`, mas o núcleo espera um JSON criptografado. Ao tentar decodificar o conteúdo, `General->checkLicense()` recebe `null` do `json_decode` e logo acessa `$data->last_checked`, o que gera o erro “Trying to get property 'last_checked' of non-object” e interrompe a carga do site.【F:includes/license/license.imperiamucms†L1】【F:includes/classes/class.general.php†L132-L216】
- Esse método é chamado diretamente no bootstrap (`includes/imperiamucms.php`) em toda requisição web, portanto a falha do arquivo de licença impede que qualquer módulo seja carregado, mesmo que o restante da configuração esteja correto.【F:includes/imperiamucms.php†L298-L304】
- Além da licença principal, cada módulo premium procura por `includes/license/license_<módulo>.imperiamucms`; na ausência desses arquivos, a execução lança exceções `[700]`–`[706]` e bloqueia recursos como Bug Tracker, Market, Cash Shop e Wheel of Fortune, conforme detalhado em `MODULE_STATUS.md`.【F:includes/classes/class.database.php†L603-L724】【F:modules/bugtracker.php†L9-L18】
- A rotina `General->decodel()` usa as funções `mcrypt_*`, removidas das builds padrão do PHP ≥ 7.2. Se a extensão `mcrypt` não estiver instalada manualmente, qualquer chamada de licença resulta em “Call to undefined function mcrypt_get_iv_size()”.【F:includes/classes/class.general.php†L420-L449】
- O CMS envia as consultas de validação para `http://127.0.0.1:5000/`, endereço definido por `__IMPERIAMUCMS_LICENSE_SERVER__`. É obrigatório que o License Server esteja ativo nessa porta e com as credenciais corretas; caso contrário, o retorno `false` de `curl_file_get_contents()` mantém o status `[603] Failed to check license` e, após três dias, bloqueia o site.【F:includes/imperiamucms.php†L37-L40】【F:includes/classes/class.general.php†L144-L210】

## Como corrigir e configurar
1. **Gerar e publicar os arquivos de licença:**
   - Use o License Server para emitir o JSON criptografado do domínio/IP atual e substitua o conteúdo de `includes/license/license.imperiamucms`. Sem esse arquivo válido, o bootstrap do CMS sempre termina com erro de licença.【F:includes/license/license.imperiamucms†L1】【F:includes/classes/class.general.php†L132-L210】
   - Para cada módulo pago habilitado, gere também `license_<módulo>.imperiamucms`; caso contrário, as rotinas `ifn9fJgdGKPP_check...`/`fjbaYbddafFF_check...` levantarão as exceções `[700]`–`[706]` e o recurso permanecerá bloqueado.【F:includes/classes/class.database.php†L603-L724】
   - Garanta que o License Server esteja acessível em `http://127.0.0.1:5000/` (ou ajuste a constante) antes do primeiro acesso, evitando que o CMS acumule falhas `[603] Failed to check license`.【F:includes/imperiamucms.php†L37-L40】【F:includes/classes/class.general.php†L144-L210】
2. **Instalar a extensão criptográfica necessária:** se o servidor executar PHP 7.2 ou superior, habilite a extensão `mcrypt` (via PECL ou pacotes específicos) ou adapte o código para usar `openssl_encrypt()` também na classe `General`; sem isso, as funções `decodel()`/`encodel()` geram fatal error.【F:includes/classes/class.general.php†L420-L449】
3. **Gerar `includes/config.php`:** rode o instalador em `install/index.php`, preencha a etapa **Website Config** e clique em **Generate Config** para salvar as credenciais, hashes e parâmetros do site. A operação utiliza `file_put_contents`, portanto o arquivo precisa estar com permissão de escrita.【F:install/index.php†L41-L90】【F:install/config.php†L95-L229】【F:install/config.php†L296-L369】
4. **Preencher credenciais do banco de dados e chaves de segurança:** certifique-se de que os campos SQL (`SQL_DB_HOST`, `SQL_DB_NAME`, `SQL_PDO_DRIVER`, etc.) contenham valores válidos; o conector `dB` depende desses dados para inicializar as conexões MSSQL utilizadas em todo o CMS.【F:includes/classes/class.database.php†L9-L61】【F:admincp/modules/website_config.php†L208-L339】
5. **Revisar permissões de escrita:** mantenha as pastas indicadas pelo instalador (`includes/cache`, `includes/license`, `includes/config`, etc.) com permissões de escrita para que cache, logs e arquivos de licença possam ser atualizados sem intervenção manual.【F:install/systemcheck.php†L103-L136】
6. **Validar arquivos XML de módulos:** antes de habilitar cada módulo, confirme que o respectivo XML em `includes/config/modules/` está ativo e configurado corretamente; isso evita telas vazias ou mensagens inesperadas durante os testes.【F:includes/functions/function.config.php†L29-L101】

## Próximos passos recomendados
- Após gerar `includes/config.php`, limpe os caches em `includes/cache` e revalide os módulos mais críticos (login, registros, rankings).
- Considere versionar um `config.php` de exemplo com placeholders (fora do repositório público) para acelerar futuras instalações.
- Automatize a correção do instalador para evitar que o problema retorne em ambientes novos.
- Configure cron jobs e APIs conforme necessário para votações, doações e tarefas automáticas presentes no diretório `cron/` e na pasta `api/`.
