<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'erpdbase');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'lince');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'caf@xpto#1234');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'FckeV8042hU)L*3i4Z]&|b_tTNgr+Kx5LE#G|pJPTB<m?D71Q;c1UZ&GSdS{]oK_');
define('SECURE_AUTH_KEY',  '33UC2|9iPa1OkF;gb`%~qQ_<>=D.GoQdEa|WYv?D<H`qGV_mk/Mg:g16_Tr<nCMB');
define('LOGGED_IN_KEY',    'hkKQEadI-<OK5p|f-Tej/5Qt[e)P,OByly{{mY~$@VDWLd<8i]F2`[I]#O9|[+(.');
define('NONCE_KEY',        'y?DS2C!0&<3t{s~a!LK|9wW2H1a@QoI/u.r[tH5Kv0%1l$+1.[C#.G+y~bdNODU}');
define('AUTH_SALT',        'U~t}K8n+?L{RX-G.WGPn~e;vAaj:e`,&Q7lsvgp+P=b-5Ce,&HV$.R/JS>}Sy`-j');
define('SECURE_AUTH_SALT', 'G[H</rQCZ`|!I[swE-wM!I@jM2gn#1i,(j-T9gne:yltX4^Of[PYMY}cAsn+v 2l');
define('LOGGED_IN_SALT',   '2c_7]bE_@X,ZHauJko-G-l/W+vYBZl<!j[lO+4f%-?-zNyCvOU=%WZ~jM7ZuBwbS');
define('NONCE_SALT',       'rYG[yd8T*+C>zh[Nj~*A;Y!&#y;m4_T~_Y66FoH@a(i*Y@TK*ZeCfIj7jNFx?^-J');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';


/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
