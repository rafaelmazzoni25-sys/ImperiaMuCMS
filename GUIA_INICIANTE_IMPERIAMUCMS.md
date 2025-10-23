# Guia completo do ImperiaMuCMS para iniciantes

Este guia foi pensado para quem nunca instalou ou configurou um site antes. Ele explica passo a passo como colocar o ImperiaMuCMS no ar, desde a preparação do servidor até os ajustes finais e a resolução dos erros mais comuns. Sempre que surgir uma palavra técnica, procure o bloco **Glossário** ao final do documento.

## 1. Conheça o que você está instalando
- **O que é o ImperiaMuCMS?** É um site em PHP feito especialmente para servidores de Mu Online. Ele já traz páginas públicas (login, rankings, cadastro), um painel administrativo para a equipe do servidor e um painel específico para Game Masters.【F:README.md†L4-L17】
- **Como os arquivos estão organizados?**
  - `admincp/`: painel administrativo com gerenciador de módulos e configurações do site.【F:README.md†L9-L15】
  - `gmcp/`: painel para Game Masters com ferramentas próprias.【F:README.md†L13-L15】
  - `modules/`: módulos que formam o site público (login, rankings, user CP).【F:README.md†L15-L17】
  - `includes/`: núcleo com classes, configurações e funções usadas em todo o projeto.【F:README.md†L11-L15】
  - `templates/`: pastas de layout (HTML, CSS e JS) que definem a aparência do site.【F:README.md†L16-L17】
  - `install/`: instalador web que ajuda a verificar o servidor e criar o arquivo de configurações.【F:README.md†L18-L21】

## 2. Antes de começar: requisitos básicos
Verifique estes pontos no seu servidor de hospedagem (ou VPS) antes de enviar os arquivos. Eles são conferidos pelo instalador em `install/systemcheck.php`.

1. **Versão do PHP**: precisa ser 7.2 ou mais atual. Versões anteriores não são aceitas.【F:install/systemcheck.php†L10-L19】
2. **Extensões do PHP**: cURL, BCMath, GD, OpenSSL, Session, SimpleXML, XML, XMLReader, XMLWriter e pelo menos um driver PDO para SQL Server (`pdo_dblib`, `PDO_SQLSRV` ou `PDO_ODBC`).【F:install/systemcheck.php†L16-L67】
3. **Configuração `short_open_tag`**: deve estar ativada no `php.ini`. Sem ela, o CMS não roda.【F:install/systemcheck.php†L20-L28】
4. **Servidor web**: precisa ter o módulo `mod_rewrite` do Apache habilitado (ou o equivalente no seu servidor).【F:install/systemcheck.php†L32-L43】
5. **Permissões de escrita**: algumas pastas e o arquivo `includes/config.php` devem permitir escrita (permissão `0777` ou equivalente). A lista completa está no instalador.【F:install/systemcheck.php†L68-L107】
6. **Banco de dados SQL Server**: o CMS conecta em bancos como `MuOnline`, `Me_MuOnline`, `Events`, `Ranking` e `BattleCore`. Crie esses bancos ou ajuste os nomes mais tarde no arquivo de configuração.【F:includes/config.php†L49-L84】

> **Dica:** se você usa hospedagem compartilhada, envie esta lista para o suporte técnico. Eles costumam ajudar a conferir cada item.

## 3. Prepare o ambiente

1. **Baixe e envie os arquivos**
   - Faça download do pacote do ImperiaMuCMS e envie tudo para a pasta pública do seu site (ex.: `public_html`) usando FTP ou o gerenciador de arquivos do cPanel.
   - Garanta que a pasta `install/` também foi enviada; ela será usada apenas na instalação.

2. **Ajuste as permissões**
   - No gerenciador de arquivos ou via SSH, altere as permissões das pastas listadas no instalador para `0777` (ou “Leitura + Escrita” para todos). Isso inclui `includes/cache/`, `includes/config/`, `includes/license/`, `includes/cache/*` e o arquivo `includes/config.php` propriamente dito.【F:install/systemcheck.php†L68-L107】

3. **Crie o banco de dados**
   - No SQL Server, crie as bases que o CMS espera (`MuOnline`, `Me_MuOnline`, `Events`, `Ranking`, `BattleCore`). Se você usa outros nomes, anote-os para preencher depois no configurador.【F:includes/config.php†L49-L84】
   - Crie um usuário com acesso total a essas bases e anote usuário, senha, host e porta (por padrão `1433`).

## 4. Execute o instalador web

1. Acesse `http://seu-dominio/install/` pelo navegador. A página inicial roda o **System Check** e mostra se os requisitos estão atendidos.【F:install/systemcheck.php†L1-L112】
2. Clique em **Continue** quando tudo estiver verde. Se algo ficar em vermelho, corrija e aperte “Fix errors and reload page”.【F:install/systemcheck.php†L100-L112】
3. O instalador seguirá para a etapa de licença e, na sequência, exibirá o formulário **Website Config**, que preenche automaticamente o arquivo `includes/config.php` usando os dados informados.【F:install/config.php†L52-L124】
4. Se o instalador não conseguir gravar o arquivo (erro de permissão), volte ao passo 3 e garanta que `includes/config.php` seja gravável.【F:install/systemcheck.php†L96-L107】
5. Depois que tudo estiver configurado e você entrar no site sem problemas, apague a pasta `install/` por segurança.

## 5. Entenda o arquivo `includes/config.php`
O arquivo de configuração guarda todas as opções principais do CMS. Você pode abrir e editar manualmente se preferir (utilize um editor de texto simples). Alguns campos importantes:

| Seção | O que controla | Onde aparece | Citação |
| --- | --- | --- | --- |
| `system_active`, `maintenance_page` | Liga/desliga o site e define o endereço mostrado durante a manutenção. | Afeta todo o site.【F:includes/config.php†L15-L24】 | 【F:includes/config.php†L15-L24】 |
| `website_template`, `server_name`, `website_folder` | Nome do template, nome do servidor e pasta base do site. | Define aparência e URLs.【F:includes/config.php†L18-L21】 | 【F:includes/config.php†L18-L21】 |
| `encryption_hash`, `admincp_security` | Chaves usadas para segurança e login no painel. Guarde em local seguro. | Painel admin.【F:includes/config.php†L20-L43】 | 【F:includes/config.php†L20-L43】 |
| `admins`, `admincp_modules_access` | Lista de contas que podem entrar no painel e seus níveis de acesso. | `admincp/`.【F:includes/config.php†L44-L63】 | 【F:includes/config.php†L44-L63】 |
| `gamemasters`, `gmcp_modules_access` | Permissões do painel de GMs. | `gmcp/`.【F:includes/config.php†L63-L74】 | 【F:includes/config.php†L63-L74】 |
| `SQL_DB_*` e `SQL2_DB_*` | Conexão com o banco principal e secundário. | Todas as funções que consultam o banco.【F:includes/config.php†L49-L88】 | 【F:includes/config.php†L49-L88】 |
| `server_files`, `server_files_season` | Informa ao CMS qual base de arquivos (IGCN/XTEAM) e qual Season o servidor usa. | Ajusta módulos dependentes dessa informação.【F:includes/config.php†L89-L99】 | 【F:includes/config.php†L89-L99】 |
| `language_default`, `languages` | Idiomas disponíveis e padrão. | Controla traduções em `languages/`.【F:includes/config.php†L100-L110】 | 【F:includes/config.php†L100-L110】 |

> **Importante:** mantenha uma cópia de segurança desse arquivo após cada alteração.

## 6. Faça login nos painéis
1. **AdminCP**: acesse `http://seu-dominio/admincp/`. O sistema usa as contas listadas em `$config["admins"]`. Adicione o seu usuário e nível (ex.: `'admin' => 100`) no arquivo de configuração ou pelo módulo **Admins Manager** dentro do próprio painel.【F:includes/config.php†L44-L63】
2. **GMCP**: acesse `http://seu-dominio/gmcp/`. Adicione os usuários em `$config["gamemasters"]` conforme a necessidade.【F:includes/config.php†L63-L74】

## 7. Ative e organize os módulos
- Cada módulo do site possui um arquivo de configuração em `includes/config/modules/`. Eles são lidos pela função `loadModuleConfigs()` que converte o XML para o array `$mconfig`. Use as funções auxiliares `mconfig()` e `gconfig()` para descobrir se um recurso está ativo.【F:includes/functions/function.config.php†L29-L101】
- No painel administrativo, abra **Website Configuration → Modules Manager** para ativar/desativar módulos com poucos cliques.【F:admincp/modules/website_config.php†L208-L339】
- Sempre que mudar o status de um módulo, limpe os arquivos em `includes/cache/` para que as alterações apareçam imediatamente.

## 8. Personalize o visual
- O template ativo fica em `templates/<nome-do-template>/`. Edite os arquivos HTML, CSS e JS dentro dessa pasta para alterar cores, logos e estrutura.【F:README.md†L16-L17】
- Algumas páginas usam o recurso de rolagem automática e contagem regressiva. Essas opções estão em `$config["enable_scroll_down"]` e `$config["show_countdown"]` no arquivo de configuração.【F:includes/config.php†L35-L48】
- Após alterações grandes, limpe o cache do navegador e os arquivos de cache do CMS (`includes/cache/`).

## 9. Configure sistemas extras
- **Integrações de doações**: o painel tem seções para PayPal, PagSeguro, MercadoPago e outros gateways. Eles aparecem em **Credits → <Gateway>** no AdminCP.【F:admincp/index.php†L26-L83】
- **Tarefas automáticas**: scripts recorrentes moram em `cron/`. Agende-os no seu servidor (via `cron` ou agendador do painel de hospedagem) para que rankings, recompensas e limpezas rodem sozinhos.【F:README.md†L12-L17】
- **API externa**: os endpoints ficam em `api/`. Use-os para integração com sistemas de votação ou lojas externas.【F:README.md†L9-L17】

## 10. Verifique licenças de módulos premium
Alguns recursos avançados (Bug Tracker, Market, Cash Shop, Wheel of Fortune, etc.) só funcionam se houver arquivos de licença específicos em `includes/license/`. Caso falte um arquivo `license_<módulo>.imperiamucms`, o sistema gera erros como `[700] License file ... does not exist` e bloqueia o módulo.【F:MODULE_STATUS.md†L1-L41】

## 11. Testes rápidos antes de liberar o site
1. Crie uma conta e faça login pelo site para validar o módulo `login`.
2. Entre no AdminCP e cheque se as permissões foram aplicadas corretamente.
3. Visite páginas como rankings, notícias e loja para confirmar que não há mensagens de erro.
4. Se ativou sistemas de doação ou voto, execute um teste com valores pequenos.

## 12. Solução de problemas comuns
| Problema | Causa provável | Como resolver |
| --- | --- | --- |
| Página em branco ou erro ao acessar o site | Arquivo `includes/config.php` faltando ou com dados errados. | Execute o instalador novamente ou edite manualmente as chaves, garantindo que o arquivo esteja com permissão de escrita.【F:includes/imperiamucms.php†L10-L123】【F:includes/config.php†L15-L88】 |
| Não consigo entrar no AdminCP | Conta não está listada em `$config["admins"]` ou senha inválida. | Cadastre a conta manualmente no arquivo de configuração e use a senha do jogo para logar (o CMS valida direto no banco).【F:includes/config.php†L44-L63】 |
| Módulo aparece “desativado” mesmo depois de ligar | O XML correspondente ainda está com `active = 0` ou há cache antigo. | Edite o módulo em **Modules Manager** e limpe `includes/cache/`.【F:includes/functions/function.config.php†L29-L101】【F:admincp/modules/website_config.php†L208-L339】 |
| Erro `[700] License file ... does not exist` | Faltam licenças individuais para recursos premium. | Solicite as licenças aos desenvolvedores do CMS ou desabilite o módulo na configuração até tê-las.【F:MODULE_STATUS.md†L24-L41】 |
| Logs gigantes em `__logs/` | Opção `$config["enable_logs"]` ativada. | Desligue se não estiver diagnosticando nenhum problema.【F:admincp/index.php†L44-L63】 |

## 13. Checklist final
- [ ] Backup do `includes/config.php` guardado em local seguro.
- [ ] Pasta `install/` removida do servidor.
- [ ] Admins e GMs configurados com os níveis corretos.
- [ ] Permissões ajustadas apenas onde necessário (evite manter `0777` além do indispensável).
- [ ] Cron jobs e integrações de doação testados.
- [ ] Página inicial carregando sem erros visíveis.

## Glossário rápido
- **Chmod 0777**: forma técnica de dizer “todos podem ler e escrever nesta pasta/arquivo”. Use apenas quando for realmente necessário.
- **PDO Driver**: componente que permite ao PHP conversar com o banco SQL Server. Sem ele, o site não consegue acessar os dados do jogo.【F:install/systemcheck.php†L40-L67】
- **Template**: conjunto de arquivos que define o visual do site. No ImperiaMuCMS você pode trocar o template mudando o nome em `$config["website_template"]`.【F:includes/config.php†L18-L24】
- **Módulo**: pedaço do site responsável por uma funcionalidade (login, cadastro, rankings etc.). Eles moram na pasta `modules/` e podem ser ativados ou desativados individualmente.【F:README.md†L15-L17】【F:includes/functions/function.config.php†L29-L101】

Com este guia você tem o passo a passo completo para colocar o ImperiaMuCMS no ar com segurança. Salve o documento para consultas futuras e mantenha seu site sempre atualizado!
