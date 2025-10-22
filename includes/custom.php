<?php
/**
 * ImperiaMuCMS
 * http://imperiamucms.com/
 *
 * @version 2.0.0
 * @author jacubb <admin@imperiamucms.com>
 * @copyright (c) 2014 - 2019, ImperiaMuCMS
 */

/*
 * Classes
 */
$custom['character_class'] = array(
    0 => array('Dark Wizard', 'DW', 'dw.jpg', 'dw_icon.jpg'),
    1 => array('Soul Master', 'SM', 'dw.jpg', 'dw_icon.jpg'),
    2 => array('Grand Master', 'GM', 'dw.jpg', 'dw_icon.jpg'),
    16 => array('Dark Knight', 'DK', 'dk.jpg', 'dk_icon.jpg'),
    17 => array('Blade Knight', 'BK', 'dk.jpg', 'dk_icon.jpg'),
    18 => array('Blade Master', 'BM', 'dk.jpg', 'dk_icon.jpg'),
    32 => array('Elf', 'FE', 'elf.jpg', 'fe_icon.jpg'),
    33 => array('Muse Elf', 'ME', 'elf.jpg', 'fe_icon.jpg'),
    34 => array('High Elf', 'HE', 'elf.jpg', 'fe_icon.jpg'),
    48 => array('Magic Gladiator', 'MG', 'mg.jpg', 'mg_icon.jpg'),
    50 => array('Duel Master', 'DM', 'mg.jpg', 'mg_icon.jpg'),
    64 => array('Dark Lord', 'DL', 'dl.jpg', 'dl_icon.jpg'),
    66 => array('Lord Emperor', 'LE', 'dl.jpg', 'dl_icon.jpg'),
    80 => array('Summoner', 'SU', 'sum.jpg', 'su_icon.jpg'),
    81 => array('Bloody Summoner', 'BS', 'sum.jpg', 'su_icon.jpg'),
    82 => array('Dimension Master', 'DiM', 'sum.jpg', 'su_icon.jpg'),
    96 => array('Rage Fighter', 'RF', 'rf.jpg', 'rf_icon.jpg'),
    98 => array('Fist Master', 'FM', 'rf.jpg', 'rf_icon.jpg'),
);

// Grow Lancer
if ($config['server_files_season'] >= 100) {
    $custom['character_class'][112] = array('Grow Lancer', 'GL', 'gl.jpg', 'gl_icon.jpg');
    $custom['character_class'][114] = array('Mirage Lancer', 'ML', 'gl.jpg', 'gl_icon.jpg');
}

// 4th Quest Classes
if ($config['server_files_season'] >= 122) {
    $custom['character_class'][7] = array('Soul Wizard', 'SW', 'dw.jpg', 'dw_icon.jpg');
    $custom['character_class'][23] = array('Dragon Knight', 'DrK', 'dk.jpg', 'dk_icon.jpg');
    $custom['character_class'][39] = array('Noble Elf', 'NE', 'elf.jpg', 'fe_icon.jpg');
    $custom['character_class'][54] = array('Magic Knight', 'MK', 'mg.jpg', 'mg_icon.jpg');
    $custom['character_class'][70] = array('Empire Lord', 'EL', 'dl.jpg', 'dl_icon.jpg');
    $custom['character_class'][87] = array('Dimension Summoner', 'DS', 'sum.jpg', 'su_icon.jpg');
    $custom['character_class'][102] = array('Fist Blazer', 'FB', 'rf.jpg', 'rf_icon.jpg');
    $custom['character_class'][118] = array('Shining Lancer', 'SL', 'gl.jpg', 'gl_icon.jpg');
    ksort($custom['character_class']);
}

// Season 13 Fix
if ($config['server_files_season'] >= 131) {
    unset($custom['character_class'][2]);
    unset($custom['character_class'][18]);
    unset($custom['character_class'][34]);
    unset($custom['character_class'][82]);

    $custom['character_class'][3] = array('Grand Master', 'GM', 'dw.jpg', 'dw_icon.jpg');
    $custom['character_class'][19] = array('Blade Master', 'BM', 'dk.jpg', 'dk_icon.jpg');
    $custom['character_class'][35] = array('High Elf', 'HE', 'elf.jpg', 'fe_icon.jpg');
    $custom['character_class'][83] = array('Dimension Master', 'DiM', 'sum.jpg', 'su_icon.jpg');
    ksort($custom['character_class']);

    $custom['class_filter'] = array(
        'wizard' => array(0, 1, 3, 7),
        'knight' => array(16, 17, 19, 23),
        'elf' => array(32, 33, 35, 39),
        'gladiator' => array(48, 50, 54),
        'lord' => array(64, 66, 70),
        'summoner' => array(80, 81, 83, 87),
        'fighter' => array(96, 98, 102),
        'lancer' => array(112, 114, 118),
    );
} else {
    $custom['class_filter'] = array(
        'wizard' => array(0, 1, 2, 7),
        'knight' => array(16, 17, 18, 23),
        'elf' => array(32, 33, 34, 39),
        'gladiator' => array(48, 50, 54),
        'lord' => array(64, 66, 70),
        'summoner' => array(80, 81, 82, 87),
        'fighter' => array(96, 98, 102),
        'lancer' => array(112, 114, 118),
    );
}

// Rune Wizard
if ($config['server_files_season'] >= 140) {
    $custom['character_class'][128] = array('Rune Wizard', 'RW', 'rw.jpg', 'rw_icon.jpg');
    $custom['character_class'][129] = array('Rune Spell Master', 'RSM', 'rw.jpg', 'rw_icon.jpg');
    $custom['character_class'][131] = array('Grand Rune Master', 'GRM', 'rw.jpg', 'rw_icon.jpg');
    $custom['character_class'][135] = array('Grand Rune Wizard', 'GRW', 'rw.jpg', 'rw_icon.jpg');

    $custom['class_filter']['rune'] = array(128, 129, 131, 135);
}

// Slayer
if ($config['server_files_season'] >= 150) {
    $custom['character_class'][144] = array('Slayer', 'SR', 'sr.jpg', 'sr_icon.jpg');
    $custom['character_class'][145] = array('Royal Slayer', 'RS', 'sr.jpg', 'sr_icon.jpg');
    $custom['character_class'][147] = array('Master Slayer', 'MS', 'sr.jpg', 'sr_icon.jpg');
    $custom['character_class'][151] = array('Slaughterer', 'SGT', 'sr.jpg', 'sr_icon.jpg');

    $custom['class_filter']['slayer'] = array(144, 145, 147, 151);
}

$custom['rankings_menu'] = array(
    array('rankings_txt_54', 'characters', 'rankings_enable_characters'),
    array('rankings_txt_94', 'monsterhunter', 'rankings_enable_monster_hunter'),
    array('rankings_txt_70', 'honor', 'rankings_enable_honor'),
    array('rankings_txt_67', 'score', 'rankings_enable_score'),
    array('rankings_txt_4', 'guilds', 'rankings_enable_guilds'),
    array('rankings_txt_98', 'fastresets', 'rankings_enable_fast_resets'),
    array('rankings_txt_99', 'fastgresets', 'rankings_enable_fast_gresets'),
    array('rankings_txt_55', 'onlineplayers', 'rankings_enable_online_players'),
    array('rankings_txt_1', 'level', 'rankings_enable_level'),
    array('rankings_txt_22', 'master', 'rankings_enable_master'),
    array('rankings_txt_2', 'resets', 'rankings_enable_resets'),
    array('rankings_txt_5', 'grandresets', 'rankings_enable_gr'),
    array('rankings_txt_3', 'killers', 'rankings_enable_pk'),
    array('rankings_txt_56', 'duels', 'rankings_enable_duels'),
    array('rankings_txt_6', 'online', 'rankings_enable_online'),
    array('rankings_txt_71', 'afk', 'rankings_enable_afk'),
    array('rankings_txt_8', 'gens', 'rankings_enable_gens'),
    array('rankings_txt_7', 'votes', 'rankings_enable_votes'),
    array('rankings_txt_24', 'pvplaststand', 'rankings_enable_pvplaststand'),
    array('rankings_txt_57', 'achievements', 'rankings_enable_achievements'),
    array('rankings_txt_65', 'married', 'rankings_enable_married'),
    array('rankings_txt_58', 'devilsquare', 'rankings_enable_devilsquare'),
    array('rankings_txt_59', 'bloodcastle', 'rankings_enable_bloodcastle'),
    array('rankings_txt_60', 'chaoscastle', 'rankings_enable_chaoscastle'),
    array('rankings_txt_61', 'illusiontemple', 'rankings_enable_illusiontemple'),
    array('rankings_txt_62', 'cshistory', 'rankings_enable_cshistory'),
    array('arkawar_txt_1', 'arkawar_history', 'rankings_enable_arkawar_history'),
    array('icewindvalley_txt_1', 'icewindvalley_history', 'rankings_enable_icewindvalley_history'),
);

/*
 * Exclude character names from rankings
 */
$custom['rankings_exclude'] = array(
    'GmName1',
    'GmName2',
);

/*
 * Secret Questions for Register Page
 */
$custom['secret_questions'] = array(
    1 => 'Your city of birth?',
    2 => 'Mother’s city of birth?',
    3 => 'Father’s city of birth?',
    4 => 'Model of your first car?',
    5 => 'Best friend in high school?',
    6 => 'First elementary school I attended?',
    7 => 'What was your first MU character name?',
    8 => 'Name of your first pet?',
);

/*
 * Map Codes for Profile module
 */
$custom['map_codes'] = array(
    0 => 'Lorencia',
    1 => 'Dungeon',
    2 => 'Devias',
    3 => 'Noria',
    4 => 'Lost Tower',
    5 => 'Exile',
    6 => 'Arena',
    7 => 'Atlans',
    8 => 'Tarkan',
    9 => 'Devil Square (1 ~ 4)',
    10 => 'Icarus',
    11 => 'Blood Castle 1',
    12 => 'Blood Castle 2',
    13 => 'Blood Castle 3',
    14 => 'Blood Castle 4',
    15 => 'Blood Castle 5',
    16 => 'Blood Castle 6',
    17 => 'Blood Castle 7',
    52 => 'Blood Castle 8',
    18 => 'Chaos Castle',
    19 => 'Chaos Castle',
    20 => 'Chaos Castle',
    21 => 'Chaos Castle',
    22 => 'Chaos Castle',
    23 => 'Chaos Castle',
    53 => 'Chaos Castle',
    24 => 'Kalima 1',
    25 => 'Kalima 2',
    26 => 'Kalima 3',
    27 => 'Kalima 4',
    28 => 'Kalima 5',
    29 => 'Kalima 6',
    30 => 'Valley of Loren',
    31 => 'Land Of Trials',
    32 => 'Devil Square (5 ~ 7)',
    33 => 'Aida',
    34 => 'Crywolf',
    36 => 'Kalima 7',
    37 => 'Kanturu',
    38 => 'Kanturu Relics',
    39 => 'Kanturu',
    45 => 'Illusion Temple 1',
    46 => 'Illusion Temple 2',
    47 => 'Illusion Temple 3',
    48 => 'Illusion Temple 4',
    49 => 'Illusion Temple 5',
    50 => 'Illusion Temple 6',
    41 => 'Barracks Of Balgass',
    42 => 'Refuge Balgass',
    40 => 'Silent Map',
    51 => 'Elveland',
    56 => 'Swamp',
    57 => 'La Cleon',
    58 => 'Hatchery',
    62 => 'Santa Land',
    63 => 'Vulcanus',
    64 => 'Duel Area',
    65 => 'Double Goer',
    66 => 'Double Goer',
    67 => 'Double Goer',
    68 => 'Double Goer',
    69 => 'Varka',
    70 => 'Varka',
    71 => 'Varka',
    72 => 'Varka',
    79 => 'Loren Market',
    80 => 'Karutan 1',
    81 => 'Karutan 2',
    91 => 'Acheron',
    92 => 'Arca War',
    95 => 'Debenter',
    96 => 'Debenter (Arca Battle)',
    97 => 'Chaos Castle Survival',
    98 => 'Illusion Temple League',
    99 => 'Illusion Temple League',
    100 => 'Urk Mountain 1',
    101 => 'Urk Mountain 2',
    102 => 'Tormented Square of the Fittest',
    103 => 'Tormented Square 1',
    104 => 'Tormented Square 2',
    105 => 'Tormented Square 3',
    106 => 'Tormented Square 4',
    110 => 'Nars',
    112 => 'Ferea',
    113 => 'Nixie Lake',
    114 => 'Labyrinth Entrance',
    115 => 'Labyrinth',
    116 => 'Deep Dungeon 1',
    117 => 'Deep Dungeon 2',
    118 => 'Deep Dungeon 3',
    119 => 'Deep Dungeon 4',
    120 => 'Deep Dungeon 5',
    121 => '4th Quest',
    122 => 'Swamp of Darkness',
    123 => 'Kubera Mine',
    124 => 'Kubera Mine',
    125 => 'Kubera Mine',
    126 => 'Kubera Mine',
    127 => 'Kubera Mine',
    128 => 'Atlans Abyss',
    129 => 'Atlans Abyss 2',
    130 => 'Atlans Abyss 3',
    131 => 'Scorched Canyon',
);

/*
 * PK Level Codes
 */
$custom['pklevel'] = array(
    1 => 'Hero Level 2',
    2 => 'Hero Level 1',
    3 => 'Normal',
    4 => 'PK Level 1',
    5 => 'PK Level 2',
    6 => 'Murder Level'
);

/*
 * Countries
 */
$custom['countries'] = array(
    'af' => 'Afghanistan',
    'ax' => 'Åland Islands',
    'al' => 'Albania',
    'dz' => 'Algeria',
    'as' => 'American Samoa',
    'ad' => 'Andorra',
    'ao' => 'Angola',
    'ai' => 'Anguilla',
    'aq' => 'Antarctica',
    'ag' => 'Antigua and Barbuda',
    'ar' => 'Argentina',
    'am' => 'Armenia',
    'aw' => 'Aruba',
    'au' => 'Australia',
    'at' => 'Austria',
    'az' => 'Azerbaijan',
    'bs' => 'Bahamas',
    'bh' => 'Bahrain',
    'bd' => 'Bangladesh',
    'bb' => 'Barbados',
    'by' => 'Belarus',
    'be' => 'Belgium',
    'bz' => 'Belize',
    'bj' => 'Benin',
    'bm' => 'Bermuda',
    'bt' => 'Bhutan',
    'bo' => 'Bolivia',
    'ba' => 'Bosnia and Herzegovina',
    'bw' => 'Botswana',
    'bv' => 'Bouvet Island',
    'br' => 'Brazil',
    'io' => 'British Indian Ocean Territory',
    'bn' => 'Brunei Darussalam',
    'bg' => 'Bulgaria',
    'bf' => 'Burkina Faso',
    'bi' => 'Burundi',
    'kh' => 'Cambodia',
    'cm' => 'Cameroon',
    'ca' => 'Canada',
    'cv' => 'Cape Verde',
    'ky' => 'Cayman Islands',
    'cf' => 'Central African Republic',
    'td' => 'Chad',
    'cl' => 'Chile',
    'cn' => 'China',
    'cx' => 'Christmas Island',
    'cc' => 'Cocos (Keeling) Islands',
    'co' => 'Colombia',
    'km' => 'Comoros',
    'cg' => 'Congo',
    'cd' => 'Congo, The Democratic Republic of The',
    'ck' => 'Cook Islands',
    'cr' => 'Costa Rica',
    'ci' => 'Cote D\'ivoire',
    'hr' => 'Croatia',
    'cu' => 'Cuba',
    'cy' => 'Cyprus',
    'cz' => 'Czech Republic',
    'dk' => 'Denmark',
    'dj' => 'Djibouti',
    'dm' => 'Dominica',
    'do' => 'Dominican Republic',
    'ec' => 'Ecuador',
    'eg' => 'Egypt',
    'sv' => 'El Salvador',
    'gq' => 'Equatorial Guinea',
    'er' => 'Eritrea',
    'ee' => 'Estonia',
    'et' => 'Ethiopia',
    'fk' => 'Falkland Islands (Malvinas)',
    'fo' => 'Faroe Islands',
    'fj' => 'Fiji',
    'fi' => 'Finland',
    'fr' => 'France',
    'gf' => 'French Guiana',
    'pf' => 'French Polynesia',
    'tf' => 'French Southern Territories',
    'ga' => 'Gabon',
    'gm' => 'Gambia',
    'ge' => 'Georgia',
    'de' => 'Germany',
    'gh' => 'Ghana',
    'gi' => 'Gibraltar',
    'gr' => 'Greece',
    'gl' => 'Greenland',
    'gd' => 'Grenada',
    'gp' => 'Guadeloupe',
    'gu' => 'Guam',
    'gt' => 'Guatemala',
    'gg' => 'Guernsey',
    'gn' => 'Guinea',
    'gw' => 'Guinea-bissau',
    'gy' => 'Guyana',
    'ht' => 'Haiti',
    'hm' => 'Heard Island and Mcdonald Islands',
    'va' => 'Holy See (Vatican City State)',
    'hn' => 'Honduras',
    'hk' => 'Hong Kong',
    'hu' => 'Hungary',
    'is' => 'Iceland',
    'in' => 'India',
    'id' => 'Indonesia',
    'ir' => 'Iran, Islamic Republic of',
    'iq' => 'Iraq',
    'ie' => 'Ireland',
    'im' => 'Isle of Man',
    'il' => 'Israel',
    'it' => 'Italy',
    'jm' => 'Jamaica',
    'jp' => 'Japan',
    'je' => 'Jersey',
    'jo' => 'Jordan',
    'kz' => 'Kazakhstan',
    'ke' => 'Kenya',
    'ki' => 'Kiribati',
    'kp' => 'Korea, Democratic People\'s Republic of',
    'kr' => 'Korea, Republic of',
    'kw' => 'Kuwait',
    'kg' => 'Kyrgyzstan',
    'la' => 'Lao People\'s Democratic Republic',
    'lv' => 'Latvia',
    'lb' => 'Lebanon',
    'ls' => 'Lesotho',
    'lr' => 'Liberia',
    'ly' => 'Libyan Arab Jamahiriya',
    'li' => 'Liechtenstein',
    'lt' => 'Lithuania',
    'lu' => 'Luxembourg',
    'mo' => 'Macao',
    'mk' => 'Macedonia, The Former Yugoslav Republic of',
    'mg' => 'Madagascar',
    'mw' => 'Malawi',
    'my' => 'Malaysia',
    'mv' => 'Maldives',
    'ml' => 'Mali',
    'mt' => 'Malta',
    'mh' => 'Marshall Islands',
    'mq' => 'Martinique',
    'mr' => 'Mauritania',
    'mu' => 'Mauritius',
    'yt' => 'Mayotte',
    'mx' => 'Mexico',
    'fm' => 'Micronesia, Federated States of',
    'md' => 'Moldova, Republic of',
    'mc' => 'Monaco',
    'mn' => 'Mongolia',
    'me' => 'Montenegro',
    'ms' => 'Montserrat',
    'ma' => 'Morocco',
    'mz' => 'Mozambique',
    'mm' => 'Myanmar',
    'na' => 'Namibia',
    'nr' => 'Nauru',
    'np' => 'Nepal',
    'nl' => 'Netherlands',
    'an' => 'Netherlands Antilles',
    'nc' => 'New Caledonia',
    'nz' => 'New Zealand',
    'ni' => 'Nicaragua',
    'ne' => 'Niger',
    'ng' => 'Nigeria',
    'nu' => 'Niue',
    'nf' => 'Norfolk Island',
    'mp' => 'Northern Mariana Islands',
    'no' => 'Norway',
    'om' => 'Oman',
    'pk' => 'Pakistan',
    'pw' => 'Palau',
    'ps' => 'Palestinian Territory, Occupied',
    'pa' => 'Panama',
    'pg' => 'Papua New Guinea',
    'py' => 'Paraguay',
    'pe' => 'Peru',
    'ph' => 'Philippines',
    'pn' => 'Pitcairn',
    'pl' => 'Poland',
    'pt' => 'Portugal',
    'pr' => 'Puerto Rico',
    'qa' => 'Qatar',
    're' => 'Reunion',
    'ro' => 'Romania',
    'ru' => 'Russian Federation',
    'rw' => 'Rwanda',
    'sh' => 'Saint Helena',
    'kn' => 'Saint Kitts and Nevis',
    'lc' => 'Saint Lucia',
    'pm' => 'Saint Pierre and Miquelon',
    'vc' => 'Saint Vincent and The Grenadines',
    'ws' => 'Samoa',
    'sm' => 'San Marino',
    'st' => 'Sao Tome and Principe',
    'sa' => 'Saudi Arabia',
    'sn' => 'Senegal',
    'rs' => 'Serbia',
    'sc' => 'Seychelles',
    'sl' => 'Sierra Leone',
    'sg' => 'Singapore',
    'sk' => 'Slovakia',
    'si' => 'Slovenia',
    'sb' => 'Solomon Islands',
    'so' => 'Somalia',
    'za' => 'South Africa',
    'gs' => 'South Georgia and The South Sandwich Islands',
    'es' => 'Spain',
    'lk' => 'Sri Lanka',
    'sd' => 'Sudan',
    'sr' => 'Suriname',
    'sj' => 'Svalbard and Jan Mayen',
    'sz' => 'Swaziland',
    'se' => 'Sweden',
    'ch' => 'Switzerland',
    'sy' => 'Syrian Arab Republic',
    'tw' => 'Taiwan, Province of China',
    'tj' => 'Tajikistan',
    'tz' => 'Tanzania, United Republic of',
    'th' => 'Thailand',
    'tl' => 'Timor-leste',
    'tg' => 'Togo',
    'tk' => 'Tokelau',
    'to' => 'Tonga',
    'tt' => 'Trinidad and Tobago',
    'tn' => 'Tunisia',
    'tr' => 'Turkey',
    'tm' => 'Turkmenistan',
    'tc' => 'Turks and Caicos Islands',
    'tv' => 'Tuvalu',
    'ug' => 'Uganda',
    'ua' => 'Ukraine',
    'ae' => 'United Arab Emirates',
    'gb' => 'United Kingdom',
    'us' => 'United States',
    'um' => 'United States Minor Outlying Islands',
    'uy' => 'Uruguay',
    'uz' => 'Uzbekistan',
    'vu' => 'Vanuatu',
    've' => 'Venezuela',
    'vn' => 'Viet Nam',
    'vg' => 'Virgin Islands, British',
    'vi' => 'Virgin Islands, U.S.',
    'wf' => 'Wallis and Futuna',
    'eh' => 'Western Sahara',
    'ye' => 'Yemen',
    'zm' => 'Zambia',
    'zw' => 'Zimbabwe',
);