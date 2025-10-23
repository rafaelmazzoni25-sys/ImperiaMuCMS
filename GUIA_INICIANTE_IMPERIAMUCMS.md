# Guia ImperiaMuCMS no XAMPP com License Server

Este documento foi escrito para quem nunca lidou com hospedagem ou programação. Siga cada etapa com calma: começamos instalando o XAMPP no Windows, configuramos o ImperiaMuCMS e terminamos ativando o License Server oficial. Sempre que aparecer uma expressão técnica, consulte o **Glossário** no final.

## 1. Entenda o que você vai instalar
- **ImperiaMuCMS** é o site do seu servidor Mu Online. Ele vem com páginas públicas, painel administrativo (`admincp`) e painel de Game Masters (`gmcp`).【F:README.md†L4-L15】
- A estrutura básica do CMS usa diretórios como `includes/` (núcleo e configurações), `modules/` (módulos do site) e `templates/` (arquivos de layout).【F:README.md†L6-L17】
- Alguns recursos são pagos (Bug Tracker, Market, Wheel of Fortune etc.) e só funcionam quando o CMS encontra arquivos de licença próprios em `includes/license/` e consegue validar com o License Server.【F:MODULE_STATUS.md†L1-L35】
- **License Server** é um aplicativo Windows que simula os servidores oficiais de licença. Ele permite cadastrar clientes, escolher quais módulos cada um usa e responder às verificações do site.【F:tools/license-server/README.md†L3-L125】

## 2. Requisitos antes de começar
1. **Computador com Windows 10/11 (64 bits)** com ao menos 8 GB de RAM e 20 GB livres.
2. **XAMPP 8.x** (Apache + PHP + MariaDB) — usaremos apenas o Apache e o PHP.
3. **PHP 7.2 ou superior** (o XAMPP 8.x já vem com PHP 8.x, que é aceito pelo instalador).【F:install/systemcheck.php†L10-L24】
4. **Extensões PHP obrigatórias**: cURL, BCMath, GD, OpenSSL, Session, SimpleXML, XML, XMLReader, XMLWriter e um driver PDO para SQL Server (`pdo_sqlsrv`, `pdo_dblib` ou `pdo_odbc`).【F:install/systemcheck.php†L16-L101】
5. **Driver ODBC e extensão Microsoft Drivers for PHP for SQL Server** para habilitar `pdo_sqlsrv` (faça download no site da Microsoft e selecione a versão compatível com o PHP do XAMPP).
6. **Servidor Microsoft SQL Server** (local ou remoto) com os bancos `MuOnline`, `Me_MuOnline`, `Events`, `Ranking` e `BattleCore` já criados ou com permissão para criá-los.【F:includes/config.php†L104-L120】
7. **.NET 6.0 Desktop Runtime** ou **Visual Studio 2022** para abrir o projeto do License Server.【F:tools/license-server/README.md†L20-L55】
8. Permissão administrativa no Windows para alterar arquivos dentro de `C:\xampp\` e reservar portas HTTP (porta sugerida: 5000) para o License Server.【F:tools/license-server/README.md†L24-L26】

## 3. Instale o XAMPP
1. Baixe o instalador no site oficial (apachefriends.org) e execute como administrador.
2. Durante a instalação, mantenha selecionados apenas **Apache**, **PHP** e **phpMyAdmin** (podemos desmarcar MySQL se você não usará).
3. Instale em `C:\xampp\` e finalize.
4. Abra o **XAMPP Control Panel**, clique em **Start** na linha do **Apache** e deixe o painel aberto (vamos usá-lo várias vezes).

## 4. Ajuste o PHP do XAMPP
1. No XAMPP Control Panel, clique em **Config → PHP (php.ini)**.
2. Procure a linha `short_open_tag=Off` e altere para `short_open_tag=On`, depois salve.【F:install/systemcheck.php†L22-L28】
3. Ainda no `php.ini`, remova o ponto e vírgula (`;`) do início destas extensões e confirme se elas existem na pasta `php/ext`:
   - `extension=curl`
   - `extension=bcmath`
   - `extension=gd`
   - `extension=openssl`
   - `extension=xml`
   - `extension=xmlreader`
   - `extension=xmlwriter`
   - `extension=simplexml`
   - `extension=php_pdo_sqlsrv` (ou `php_pdo_dblib` / `php_pdo_odbc`, dependendo do driver que instalou)
   - `extension=php_sqlsrv` (opcional, mas recomendado)
   Essas extensões são exigidas pelo instalador e pelos módulos principais.【F:install/systemcheck.php†L16-L101】
4. Salve o arquivo e reinicie o Apache clicando em **Stop** e depois **Start**.
5. Certifique-se de que o módulo **mod_rewrite** está ativo. Abra `C:\xampp\apache\conf\httpd.conf`, procure `#LoadModule rewrite_module` e remova o `#`. Reinicie o Apache.【F:install/systemcheck.php†L45-L54】

## 5. Instale os drivers do SQL Server
1. Baixe e instale **Microsoft ODBC Driver for SQL Server** correspondente à arquitetura do seu Windows.
2. Baixe o pacote **Microsoft Drivers for PHP for SQL Server** e copie `php_pdo_sqlsrv.dll` e `php_sqlsrv.dll` para `C:\xampp\php\ext\`.
3. Confirme no `php.ini` que as extensões `php_pdo_sqlsrv` e `php_sqlsrv` estão habilitadas (passo anterior).
4. Reinicie o Apache. O instalador verificará `PDO_SQLSRV` na próxima etapa.【F:install/systemcheck.php†L28-L44】

## 6. Prepare o SQL Server
1. Conecte-se ao SQL Server (local ou remoto) usando o SQL Server Management Studio.
2. Crie os bancos com os nomes esperados (`MuOnline`, `Me_MuOnline`, `Events`, `Ranking`, `BattleCore`).【F:includes/config.php†L104-L120】
3. Crie um usuário SQL (`sa` ou outro de sua escolha) com senha forte e permissão de leitura/escrita em todos os bancos.
4. Caso use portas diferentes de `1433`, anote — precisaremos ao configurar o CMS.【F:includes/config.php†L112-L117】

## 7. Copie o ImperiaMuCMS para o XAMPP
1. Extraia o pacote do ImperiaMuCMS em qualquer pasta temporária.
2. Copie todos os arquivos para `C:\xampp\htdocs\imperiamucms\` (se a pasta não existir, crie).
3. Verifique se estas pastas e arquivos estão presentes:
   - `admincp/`, `gmcp/`, `modules/`, `templates/`, `includes/`, `install/` e `index.php`.【F:README.md†L6-L17】
4. Abra o navegador e acesse `http://localhost/imperiamucms/` para confirmar que os arquivos foram copiados (ainda mostrará erros porque o CMS não está configurado, isso é normal).

## 8. Ajuste as permissões de escrita no Windows
1. No Explorador, clique com o botão direito em `C:\xampp\htdocs\imperiamucms\includes\` → **Propriedades → Segurança → Editar**.
2. Para os usuários **SYSTEM** e **Usuários**, marque **Gravar** e **Modificar**.
3. Repita para as subpastas `includes/cache`, `includes/config`, `includes/config/modules`, `includes/license`, `includes/cache/news`, `includes/cache/changelogs`, `includes/cache/profiles`, `includes/cache/daily_rankings`, `includes/cache/weekly_rankings`, `includes/cache/monthly_rankings` e para o arquivo `includes/config.php`. Essas são as pastas que o instalador verifica.【F:install/systemcheck.php†L103-L120】

## 9. Execute o instalador web
1. Com o Apache ligado, abra `http://localhost/imperiamucms/install/`.
2. A primeira tela é o **System Check**. Se algum item aparecer em vermelho, volte aos passos anteriores (especialmente extensões e permissões).【F:install/systemcheck.php†L10-L136】
3. Clique em **Continue** quando tudo estiver verde. Se houver erros, o botão exibirá “Fix errors and reload page” até que tudo esteja correto.【F:install/systemcheck.php†L129-L136】
4. Na etapa **License**, informe os dados da sua licença oficial (se ainda não tiver, deixe em branco para continuar a configuração básica, mas lembre-se de preencher depois).
5. Em **Website Config**, preencha nome do servidor, dados do banco (host, porta, usuário, senha) e outras informações. O instalador grava tudo em `includes/config.php`.【F:install/config.php†L52-L124】
6. Ao finalizar, o instalador pede para remover a pasta `install/`. Apague-a manualmente para evitar acessos indevidos.

## 10. Revise `includes/config.php`
Abra `includes/config.php` em um editor simples (Notepad++ ou VS Code) e confira os campos principais:

| Área | O que ajustar | Onde reflete |
| --- | --- | --- |
| `system_active`, `maintenance_page` | Ativa/desativa o site e define a página de manutenção. | Controla o acesso do site inteiro.【F:includes/config.php†L15-L24】 |
| `website_template`, `server_name`, `website_folder` | Nome do template, nome do servidor e pasta base. | Altera aparência e URLs.【F:includes/config.php†L18-L21】 |
| `encryption_hash`, `admincp_security` | Chaves utilizadas no login e na criptografia. | Necessárias para AdminCP e validações.【F:includes/config.php†L21-L73】 |
| `admins`, `admincp_modules_access` | Lista de contas e níveis do painel. | Define quem acessa o AdminCP.【F:includes/config.php†L75-L95】 |
| `gamemasters`, `gmcp_modules_access` | Permissões do painel de GMs. | Controla o `gmcp/`.【F:includes/config.php†L87-L99】 |
| `SQL_DB_*`, `SQL_PDO_DRIVER` | Conexão com os bancos MuOnline. | Usado por todos os módulos que consultam o banco.【F:includes/config.php†L104-L131】 |
| `server_files`, `server_files_season` | Tipo/versão dos arquivos do servidor. | Ajusta cálculos de itens e season.【F:includes/config.php†L133-L139】 |
| `language_default`, `languages` | Idiomas disponíveis. | Define traduções carregadas em `languages/`.【F:includes/config.php†L142-L149】 |

Guarde uma cópia desse arquivo sempre que fizer mudanças importantes.

## 11. Acesse os painéis e organize módulos
1. Abra `http://localhost/imperiamucms/admincp/` e faça login com uma conta listada em `$config["admins"]` (usa a senha do jogo; não existe senha própria para o painel).【F:includes/config.php†L75-L95】
2. Abra `http://localhost/imperiamucms/gmcp/` para o painel de Game Masters (precisa estar em `$config["gamemasters"]`).【F:includes/config.php†L87-L99】
3. No AdminCP, use **Website Configuration → Modules Manager** para ativar/desativar módulos. Isso altera os XMLs em `includes/config/modules/` e lê as opções com `loadModuleConfigs()` / `mconfig()`.【F:admincp/modules/website_config.php†L208-L339】【F:includes/functions/function.config.php†L29-L101】
4. Sempre que mudar um módulo, limpe os arquivos em `includes/cache/` para ver os efeitos imediatamente.

## 12. Configure o License Server

### 12.1 Preparar o ambiente
1. Instale o **.NET Desktop Runtime 6.0** ou o **Visual Studio 2022** (workload de Desktop).【F:tools/license-server/README.md†L20-L38】
2. Garanta acesso de rede entre o seu computador e o servidor onde o CMS roda. Vamos usar `http://127.0.0.1:5000/` como padrão, mas você pode alterar para outro IP ou porta.【F:tools/license-server/README.md†L20-L26】

### 12.2 Abrir e compilar o projeto
- **Visual Studio**: abra `tools/license-server/LicenseServer.sln`, restaure os pacotes, selecione **Build → Build Solution** e execute com **F5** para abrir a interface.【F:tools/license-server/README.md†L30-L38】
- **.NET CLI**: no Prompt de Comando, navegue até a pasta do projeto e execute `dotnet build tools/license-server/LicenseServer.csproj`. Para testar direto, use `dotnet run --project tools/license-server/LicenseServer.csproj`.【F:tools/license-server/README.md†L40-L55】

### 12.3 Entenda o arquivo `license-config.json`
A interface salva todas as informações em `tools/license-server/license-config.json`.

| Campo | Descrição |
| --- | --- |
| `prefixes` | Endereços HTTP que o servidor escuta (ex.: `http://*:5000/`).【F:tools/license-server/README.md†L61-L73】 |
| `defaultCustomFields` | Lista padrão aplicada a novas licenças (como IPs autorizados).【F:tools/license-server/README.md†L61-L76】 |
| `modules` | Catálogo dos módulos premium com `id` e nome amigável.【F:tools/license-server/README.md†L61-L76】 |
| `users` | Clientes cadastrados com licenças principais e módulos adicionais.【F:tools/license-server/README.md†L61-L95】 |

Use a interface para adicionar usuários, ativar módulos e alterar chaves; clique em **Salvar** para gravar no JSON imediatamente.【F:tools/license-server/README.md†L101-L115】

### 12.4 Cadastre licenças para os módulos premium
1. Na aba **Modules**, marque os módulos que deseja liberar (Bug Tracker, Market, Wheel of Fortune etc.). A lista de módulos corresponde aos arquivos `license_<módulo>.imperiamucms` usados pelo CMS.【F:MODULE_STATUS.md†L9-L33】
2. Para cada módulo, preencha **License Key**, **Usage ID** e **Status**.
3. Salve as mudanças para que o arquivo `license-config.json` seja atualizado.

### 12.5 Aponte o CMS para o License Server
1. No CMS, abra `includes/imperiamucms.php` e altere a constante `__IMPERIAMUCMS_LICENSE_SERVER__` para o endereço do License Server (por exemplo `http://127.0.0.1:5000/` ou o IP da sua máquina).【F:includes/imperiamucms.php†L39-L48】
2. Se o License Server estiver em outra máquina, adicione uma entrada no arquivo `hosts` (Windows: `C:\Windows\System32\drivers\etc\hosts`) para resolver o endereço escolhido.

### 12.6 Gere os arquivos de licença locais
1. Para cada módulo habilitado, crie um arquivo em `includes/license/` chamado `license_<nome>.imperiamucms` e cole o conteúdo fornecido pelo License Server (ou pelas licenças oficiais).【F:MODULE_STATUS.md†L1-L33】
2. Mantenha sempre `includes/license/license.imperiamucms` atualizado com a licença principal.
3. Se faltar algum arquivo, o CMS exibirá erros como `[700] License file ... does not exist`. Isso indica que o módulo não reconheceu a licença local.【F:MODULE_STATUS.md†L3-L35】

### 12.7 Execute o License Server
1. Inicie o programa `LicenseServer.exe` (ou use `dotnet run`). Ele abre uma janela com abas **Users**, **Modules**, **Server** e **Logs**.【F:tools/license-server/README.md†L101-L115】
2. Na aba **Server**, confirme o prefixo (porta) e clique em **Salvar**. O listener HTTP reinicia automaticamente.【F:tools/license-server/README.md†L12-L26】【F:tools/license-server/README.md†L101-L115】
3. Deixe a aplicação minimizada; o CMS consulta o servidor periodicamente.

## 13. Testes rápidos
1. No navegador, acesse `http://localhost/imperiamucms/` e crie uma conta para validar o módulo de cadastro/login.
2. Entre no AdminCP e confirme que os painéis carregam sem erros.
3. Abra módulos premium (por exemplo o Market) para verificar se não aparecem mensagens de licença.
4. Pare o License Server para confirmar que o CMS bloqueia os módulos premium, depois ligue novamente e atualize a página para ver o desbloqueio imediato.【F:MODULE_STATUS.md†L1-L35】【F:tools/license-server/README.md†L117-L125】

## 14. Solução de problemas

| Problema | Causa provável | Como resolver |
| --- | --- | --- |
| Erros vermelhos no System Check | Extensões PHP desativadas, `short_open_tag` em Off ou mod_rewrite sem carregar. | Revise o `php.ini` e o `httpd.conf`, habilitando os itens listados na seção 4.【F:install/systemcheck.php†L16-L54】 |
| “PDO Driver ... not loaded” | Driver do SQL Server não instalado ou DLL fora da pasta `ext`. | Reinstale os drivers da Microsoft e habilite `php_pdo_sqlsrv` no `php.ini`. Reinicie o Apache.【F:install/systemcheck.php†L28-L44】 |
| CMS não consegue gravar `includes/config.php` | Permissões de escrita ausentes nas pastas/arquivos monitorados. | Ajuste permissões em `includes/config.php` e nas pastas de cache/config listadas no instalador.【F:install/systemcheck.php†L103-L120】 |
| Erro `[700] License file ... does not exist` | Falta de arquivos `license_<módulo>.imperiamucms` ou License Server desligado. | Gere os arquivos locais e mantenha o License Server em execução para validar os módulos.【F:MODULE_STATUS.md†L3-L35】【F:tools/license-server/README.md†L117-L125】 |
| Porta 5000 em uso no License Server | Outro programa ocupando a porta. | Na aba **Server**, altere o prefixo para outra porta livre (ex.: 5001) e salve; o listener reinicia automaticamente.【F:tools/license-server/README.md†L12-L26】【F:tools/license-server/README.md†L101-L115】 |

## 15. Checklist final
- [ ] Apache do XAMPP inicia sem erros e `phpinfo()` mostra as extensões habilitadas.
- [ ] Bancos SQL Server criados e acessíveis com o usuário configurado.
- [ ] `includes/config.php` preenchido e salvo em local seguro.
- [ ] Pasta `install/` removida.
- [ ] Painéis `admincp` e `gmcp` acessíveis com as contas corretas.
- [ ] License Server em execução com os módulos necessários ativados.
- [ ] Módulos premium testados e respondendo corretamente.

## Glossário
- **Apache**: servidor web que entrega as páginas do CMS para o navegador.
- **XAMPP**: pacote que instala Apache, PHP e ferramentas auxiliares em um clique.
- **PDO_SQLSRV**: driver que permite ao PHP conversar com o Microsoft SQL Server via PDO.【F:install/systemcheck.php†L28-L44】
- **License Key / Usage ID**: códigos que identificam e autorizam módulos premium dentro do License Server.【F:tools/license-server/README.md†L61-L115】
- **mod_rewrite**: módulo do Apache que reescreve URLs e é exigido pelo CMS para gerar links amigáveis.【F:install/systemcheck.php†L45-L54】
- **Cache**: arquivos temporários salvos em `includes/cache/` para agilizar carregamentos; podem ser apagados com segurança após mudanças.【F:install/systemcheck.php†L103-L110】【F:README.md†L6-L17】

Siga este guia sempre que precisar reinstalar o ambiente. Com paciência e atenção aos detalhes, o ImperiaMuCMS fica pronto para uso local no XAMPP e com os módulos premium desbloqueados pelo License Server.
