# Diagnóstico dos módulos licenciados

## Como a checagem de licença funciona
O CMS invoca `xGeneral->ifn9fJgdGKPP_check_jhd7cBDv_Module_fnub7Hda_License()` e `xGeneral->fjbaYbddafFF_check_jf7bSC_Local_kgfjJG_Module_jGGrOZnf_License()` antes de liberar os recursos premium. Essas rotinas descriptografam os arquivos `includes/license/license_<módulo>.imperiamucms` e consultam o servidor da ImperiaMuCMS; se o arquivo não existir, a execução lança exceções como `[700] License file ... does not exist.`.【F:includes/classes/class.database.php†L520-L724】

## Situação no repositório
O diretório `includes/license/` contém apenas `license.imperiamucms`, e o arquivo traz somente a string `http://mu-loc.com`. Por isso, `json_decode()` retorna `null` e `General->checkLicense()` dispara o erro “Trying to get property 'last_checked' of non-object” antes mesmo de chegar aos módulos.【F:includes/license/license.imperiamucms†L1】【F:includes/classes/class.general.php†L132-L216】 Além disso, nenhum `license_<módulo>.imperiamucms` acompanha o repositório; nessa condição, toda chamada às rotinas de licença resulta nas exceções `[700]`–`[706]` descritas acima.【F:includes/classes/class.database.php†L603-L724】

## Impacto nos módulos solicitados
| Módulo | Arquivo carregado | Evidência da checagem de licença |
| --- | --- | --- |
| Bug Tracker | `modules/bugtracker.php` | Instancia `xGeneral` e executa as duas validações de licença antes de carregar a lista de bugs.【F:modules/bugtracker.php†L9-L18】 |
| Rename Character | `modules/usercp/changename.php` | Verifica as duas rotinas de licença logo após confirmar que o módulo está ativo.【F:modules/usercp/changename.php†L33-L45】 |
| Market | `modules/usercp/market.php` | Bloqueia o restante do fluxo (listagem, compra e venda) se a checagem de licença falhar.【F:modules/usercp/market.php†L17-L45】 |
| Web Bank | `modules/usercp/webbank.php` | Executa as validações antes de permitir depósitos/saques de jóias, zen ou itens.【F:modules/usercp/webbank.php†L9-L63】 |
| Transfer Coins | `modules/usercp/transfercoins.php` | Chama a checagem de licença e só então permite transferências entre contas.【F:modules/usercp/transfercoins.php†L10-L39】 |
| My Vault | `modules/usercp/vault.php` | O carregamento do baú e a interação com o Market ficam condicionados à licença.【F:modules/usercp/vault.php†L10-L41】 |
| Recruit a Friend | `modules/usercp/recruit.php` | A tela de convite só renderiza após a validação do módulo premium.【F:modules/usercp/recruit.php†L10-L38】 |
| Claim Reward | `modules/usercp/claimreward.php` | A listagem de recompensas e o formulário dependem da licença do módulo.【F:modules/usercp/claimreward.php†L10-L40】 |
| Items Inventory | `modules/usercp/items.php` | Verifica a licença antes de liberar o inventário webshop do usuário.【F:modules/usercp/items.php†L13-L33】 |
| Activity Reward | `modules/usercp/activityrewards.php` | Só calcula elegibilidade e recompensas após passar pelas duas verificações.【F:modules/usercp/activityrewards.php†L10-L33】 |
| Badges | `modules/profile/player.php`, `modules/profile/guild.php` | Ambos os perfis consultam as rotinas de licença antes de carregar `loadConfigurations("badges")` e exibir insígnias.【F:modules/profile/player.php†L226-L244】【F:modules/profile/guild.php†L62-L74】 |
| Lottery | `modules/usercp/lottery.php` | Garante a licença antes de aceitar apostas e registrar números sorteados.【F:modules/usercp/lottery.php†L14-L78】 |
| Architect | `modules/usercp/architect.php` | A gestão de construções do castelo só é habilitada após as validações.【F:modules/usercp/architect.php†L10-L35】 |
| Auctions | `modules/usercp/auction.php` | O módulo de leilões realiza as duas checagens de licença e aborta se falharem.【F:modules/usercp/auction.php†L17-L35】 |
| Achievements | `modules/usercp/achievements.php` | O painel exige licença para processar envios de itens e conceder recompensas.【F:modules/usercp/achievements.php†L27-L52】 |
| Cash Shop | `modules/usercp/cashshop.php` | Sem licença, o catálogo de compras e o fluxo de compra ficam indisponíveis.【F:modules/usercp/cashshop.php†L14-L33】 |
| Dual Skill Tree | `modules/usercp/dualskilltree.php` | Verifica a licença antes de habilitar desbloqueio e alternância de árvores.【F:modules/usercp/dualskilltree.php†L13-L44】 |
| Dual Stats | `modules/usercp/dualstats.php` | Controla o desbloqueio/alternância de builds mediante validação de licença.【F:modules/usercp/dualstats.php†L13-L45】 |
| Starting Kit | `modules/usercp/startingkit.php` | Chama as rotinas de licença antes de permitir a retirada de kits iniciais.【F:modules/usercp/startingkit.php†L10-L41】 |
| Guild Web Bank | `modules/usercp/webbankguild.php` | Reutiliza a licença do módulo Architect para movimentar o banco da guilda.【F:modules/usercp/webbankguild.php†L9-L68】 |
| Wheel of Fortune | `modules/usercp/wheeloffortune.php` | A roleta verifica as duas rotinas antes de calcular custo, prêmios e histórico.【F:modules/usercp/wheeloffortune.php†L85-L105】 |

## Conclusão
Sem os arquivos `license_<módulo>.imperiamucms`, o CMS entende que não há licença válida para nenhum dos módulos acima e interrompe o processamento com exceções específicas. Para reativá-los é necessário provisionar as licenças correspondentes ou ajustar o código para ignorar a verificação (somente em ambientes autorizados).
