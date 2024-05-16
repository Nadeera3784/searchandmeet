<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = array(
                0 =>
                    array(
                        'code' => 'ab',
                        'name' => 'Abkhaz',
                        'native_name' => 'аҧсуа',
                    ),
                1 =>
                    array(
                        'code' => 'aa',
                        'name' => 'Afar',
                        'native_name' => 'Afaraf',
                    ),
                2 =>
                    array(
                        'code' => 'af',
                        'name' => 'Afrikaans',
                        'native_name' => 'Afrikaans',
                    ),
                3 =>
                    array(
                        'code' => 'ak',
                        'name' => 'Akan',
                        'native_name' => 'Akan',
                    ),
                4 =>
                    array(
                        'code' => 'sq',
                        'name' => 'Albanian',
                        'native_name' => 'Shqip',
                    ),
                5 =>
                    array(
                        'code' => 'am',
                        'name' => 'Amharic',
                        'native_name' => 'አማርኛ',
                    ),
                6 =>
                    array(
                        'code' => 'ar',
                        'name' => 'Arabic',
                        'native_name' => 'العربية',
                    ),
                7 =>
                    array(
                        'code' => 'an',
                        'name' => 'Aragonese',
                        'native_name' => 'Aragonés',
                    ),
                8 =>
                    array(
                        'code' => 'hy',
                        'name' => 'Armenian',
                        'native_name' => 'Հայերեն',
                    ),
                9 =>
                    array(
                        'code' => 'as',
                        'name' => 'Assamese',
                        'native_name' => 'অসমীয়া',
                    ),
                10 =>
                    array(
                        'code' => 'av',
                        'name' => 'Avaric',
                        'native_name' => 'авар мацӀ, магӀарул мацӀ',
                    ),
                11 =>
                    array(
                        'code' => 'ae',
                        'name' => 'Avestan',
                        'native_name' => 'avesta',
                    ),
                12 =>
                    array(
                        'code' => 'ay',
                        'name' => 'Aymara',
                        'native_name' => 'aymar aru',
                    ),
                13 =>
                    array(
                        'code' => 'az',
                        'name' => 'Azerbaijani',
                        'native_name' => 'azərbaycan dili',
                    ),
                14 =>
                    array(
                        'code' => 'bm',
                        'name' => 'Bambara',
                        'native_name' => 'bamanankan',
                    ),
                15 =>
                    array(
                        'code' => 'ba',
                        'name' => 'Bashkir',
                        'native_name' => 'башҡорт теле',
                    ),
                16 =>
                    array(
                        'code' => 'eu',
                        'name' => 'Basque',
                        'native_name' => 'euskara, euskera',
                    ),
                17 =>
                    array(
                        'code' => 'be',
                        'name' => 'Belarusian',
                        'native_name' => 'Беларуская',
                    ),
                18 =>
                    array(
                        'code' => 'bn',
                        'name' => 'Bengali',
                        'native_name' => 'বাংলা',
                    ),
                19 =>
                    array(
                        'code' => 'bh',
                        'name' => 'Bihari',
                        'native_name' => 'भोजपुरी',
                    ),
                20 =>
                    array(
                        'code' => 'bi',
                        'name' => 'Bislama',
                        'native_name' => 'Bislama',
                    ),
                21 =>
                    array(
                        'code' => 'bs',
                        'name' => 'Bosnian',
                        'native_name' => 'bosanski jezik',
                    ),
                22 =>
                    array(
                        'code' => 'br',
                        'name' => 'Breton',
                        'native_name' => 'brezhoneg',
                    ),
                23 =>
                    array(
                        'code' => 'bg',
                        'name' => 'Bulgarian',
                        'native_name' => 'български език',
                    ),
                24 =>
                    array(
                        'code' => 'my',
                        'name' => 'Burmese',
                        'native_name' => 'ဗမာစာ',
                    ),
                25 =>
                    array(
                        'code' => 'ca',
                        'name' => 'Catalan; Valencian',
                        'native_name' => 'Català',
                    ),
                26 =>
                    array(
                        'code' => 'ch',
                        'name' => 'Chamorro',
                        'native_name' => 'Chamoru',
                    ),
                27 =>
                    array(
                        'code' => 'ce',
                        'name' => 'Chechen',
                        'native_name' => 'нохчийн мотт',
                    ),
                28 =>
                    array(
                        'code' => 'ny',
                        'name' => 'Chichewa; Chewa; Nyanja',
                        'native_name' => 'chiCheŵa, chinyanja',
                    ),
                29 =>
                    array(
                        'code' => 'zh',
                        'name' => 'Chinese',
                        'native_name' => '中文 (Zhōngwén), 汉语, 漢語',
                    ),
                30 =>
                    array(
                        'code' => 'cv',
                        'name' => 'Chuvash',
                        'native_name' => 'чӑваш чӗлхи',
                    ),
                31 =>
                    array(
                        'code' => 'kw',
                        'name' => 'Cornish',
                        'native_name' => 'Kernewek',
                    ),
                32 =>
                    array(
                        'code' => 'co',
                        'name' => 'Corsican',
                        'native_name' => 'corsu, lingua corsa',
                    ),
                33 =>
                    array(
                        'code' => 'cr',
                        'name' => 'Cree',
                        'native_name' => 'ᓀᐦᐃᔭᐍᐏᐣ',
                    ),
                34 =>
                    array(
                        'code' => 'hr',
                        'name' => 'Croatian',
                        'native_name' => 'hrvatski',
                    ),
                35 =>
                    array(
                        'code' => 'cs',
                        'name' => 'Czech',
                        'native_name' => 'česky, čeština',
                    ),
                36 =>
                    array(
                        'code' => 'da',
                        'name' => 'Danish',
                        'native_name' => 'dansk',
                    ),
                37 =>
                    array(
                        'code' => 'dv',
                        'name' => 'Divehi; Dhivehi; Maldivian;',
                        'native_name' => 'ދިވެހި',
                    ),
                38 =>
                    array(
                        'code' => 'nl',
                        'name' => 'Dutch',
                        'native_name' => 'Nederlands, Vlaams',
                    ),
                39 =>
                    array(
                        'code' => 'en',
                        'name' => 'English',
                        'native_name' => 'English',
                    ),
                40 =>
                    array(
                        'code' => 'eo',
                        'name' => 'Esperanto',
                        'native_name' => 'Esperanto',
                    ),
                41 =>
                    array(
                        'code' => 'et',
                        'name' => 'Estonian',
                        'native_name' => 'eesti, eesti keel',
                    ),
                42 =>
                    array(
                        'code' => 'ee',
                        'name' => 'Ewe',
                        'native_name' => 'Eʋegbe',
                    ),
                43 =>
                    array(
                        'code' => 'fo',
                        'name' => 'Faroese',
                        'native_name' => 'føroyskt',
                    ),
                44 =>
                    array(
                        'code' => 'fj',
                        'name' => 'Fijian',
                        'native_name' => 'vosa Vakaviti',
                    ),
                45 =>
                    array(
                        'code' => 'fi',
                        'name' => 'Finnish',
                        'native_name' => 'suomi, suomen kieli',
                    ),
                46 =>
                    array(
                        'code' => 'fr',
                        'name' => 'French',
                        'native_name' => 'français, langue française',
                    ),
                47 =>
                    array(
                        'code' => 'ff',
                        'name' => 'Fula; Fulah; Pulaar; Pular',
                        'native_name' => 'Fulfulde, Pulaar, Pular',
                    ),
                48 =>
                    array(
                        'code' => 'gl',
                        'name' => 'Galician',
                        'native_name' => 'Galego',
                    ),
                49 =>
                    array(
                        'code' => 'ka',
                        'name' => 'Georgian',
                        'native_name' => 'ქართული',
                    ),
                50 =>
                    array(
                        'code' => 'de',
                        'name' => 'German',
                        'native_name' => 'Deutsch',
                    ),
                51 =>
                    array(
                        'code' => 'el',
                        'name' => 'Greek, Modern',
                        'native_name' => 'Ελληνικά',
                    ),
                52 =>
                    array(
                        'code' => 'gn',
                        'name' => 'Guaraní',
                        'native_name' => 'Avañeẽ',
                    ),
                53 =>
                    array(
                        'code' => 'gu',
                        'name' => 'Gujarati',
                        'native_name' => 'ગુજરાતી',
                    ),
                54 =>
                    array(
                        'code' => 'ht',
                        'name' => 'Haitian; Haitian Creole',
                        'native_name' => 'Kreyòl ayisyen',
                    ),
                55 =>
                    array(
                        'code' => 'ha',
                        'name' => 'Hausa',
                        'native_name' => 'Hausa, هَوُسَ',
                    ),
                56 =>
                    array(
                        'code' => 'he',
                        'name' => 'Hebrew (modern)',
                        'native_name' => 'עברית',
                    ),
                57 =>
                    array(
                        'code' => 'hz',
                        'name' => 'Herero',
                        'native_name' => 'Otjiherero',
                    ),
                58 =>
                    array(
                        'code' => 'hi',
                        'name' => 'Hindi',
                        'native_name' => 'हिन्दी, हिंदी',
                    ),
                59 =>
                    array(
                        'code' => 'ho',
                        'name' => 'Hiri Motu',
                        'native_name' => 'Hiri Motu',
                    ),
                60 =>
                    array(
                        'code' => 'hu',
                        'name' => 'Hungarian',
                        'native_name' => 'Magyar',
                    ),
                61 =>
                    array(
                        'code' => 'ia',
                        'name' => 'Interlingua',
                        'native_name' => 'Interlingua',
                    ),
                62 =>
                    array(
                        'code' => 'id',
                        'name' => 'Indonesian',
                        'native_name' => 'Bahasa Indonesia',
                    ),
                63 =>
                    array(
                        'code' => 'ie',
                        'name' => 'Interlingue',
                        'native_name' => 'Originally called Occidental; then Interlingue after WWII',
                    ),
                64 =>
                    array(
                        'code' => 'ga',
                        'name' => 'Irish',
                        'native_name' => 'Gaeilge',
                    ),
                65 =>
                    array(
                        'code' => 'ig',
                        'name' => 'Igbo',
                        'native_name' => 'Asụsụ Igbo',
                    ),
                66 =>
                    array(
                        'code' => 'ik',
                        'name' => 'Inupiaq',
                        'native_name' => 'Iñupiaq, Iñupiatun',
                    ),
                67 =>
                    array(
                        'code' => 'io',
                        'name' => 'Ido',
                        'native_name' => 'Ido',
                    ),
                68 =>
                    array(
                        'code' => 'is',
                        'name' => 'Icelandic',
                        'native_name' => 'Íslenska',
                    ),
                69 =>
                    array(
                        'code' => 'it',
                        'name' => 'Italian',
                        'native_name' => 'Italiano',
                    ),
                70 =>
                    array(
                        'code' => 'iu',
                        'name' => 'Inuktitut',
                        'native_name' => 'ᐃᓄᒃᑎᑐᑦ',
                    ),
                71 =>
                    array(
                        'code' => 'ja',
                        'name' => 'Japanese',
                        'native_name' => '日本語 (にほんご／にっぽんご)',
                    ),
                72 =>
                    array(
                        'code' => 'jv',
                        'name' => 'Javanese',
                        'native_name' => 'basa Jawa',
                    ),
                73 =>
                    array(
                        'code' => 'kl',
                        'name' => 'Kalaallisut, Greenlandic',
                        'native_name' => 'kalaallisut, kalaallit oqaasii',
                    ),
                74 =>
                    array(
                        'code' => 'kn',
                        'name' => 'Kannada',
                        'native_name' => 'ಕನ್ನಡ',
                    ),
                75 =>
                    array(
                        'code' => 'kr',
                        'name' => 'Kanuri',
                        'native_name' => 'Kanuri',
                    ),
                76 =>
                    array(
                        'code' => 'ks',
                        'name' => 'Kashmiri',
                        'native_name' => 'कश्मीरी, كشميري‎',
                    ),
                77 =>
                    array(
                        'code' => 'kk',
                        'name' => 'Kazakh',
                        'native_name' => 'Қазақ тілі',
                    ),
                78 =>
                    array(
                        'code' => 'km',
                        'name' => 'Khmer',
                        'native_name' => 'ភាសាខ្មែរ',
                    ),
                79 =>
                    array(
                        'code' => 'ki',
                        'name' => 'Kikuyu, Gikuyu',
                        'native_name' => 'Gĩkũyũ',
                    ),
                80 =>
                    array(
                        'code' => 'rw',
                        'name' => 'Kinyarwanda',
                        'native_name' => 'Ikinyarwanda',
                    ),
                81 =>
                    array(
                        'code' => 'ky',
                        'name' => 'Kirghiz, Kyrgyz',
                        'native_name' => 'кыргыз тили',
                    ),
                82 =>
                    array(
                        'code' => 'kv',
                        'name' => 'Komi',
                        'native_name' => 'коми кыв',
                    ),
                83 =>
                    array(
                        'code' => 'kg',
                        'name' => 'Kongo',
                        'native_name' => 'KiKongo',
                    ),
                84 =>
                    array(
                        'code' => 'ko',
                        'name' => 'Korean',
                        'native_name' => '한국어 (韓國語), 조선말 (朝鮮語)',
                    ),
                85 =>
                    array(
                        'code' => 'ku',
                        'name' => 'Kurdish',
                        'native_name' => 'Kurdî, كوردی‎',
                    ),
                86 =>
                    array(
                        'code' => 'kj',
                        'name' => 'Kwanyama, Kuanyama',
                        'native_name' => 'Kuanyama',
                    ),
                87 =>
                    array(
                        'code' => 'la',
                        'name' => 'Latin',
                        'native_name' => 'latine, lingua latina',
                    ),
                88 =>
                    array(
                        'code' => 'lb',
                        'name' => 'Luxembourgish, Letzeburgesch',
                        'native_name' => 'Lëtzebuergesch',
                    ),
                89 =>
                    array(
                        'code' => 'lg',
                        'name' => 'Luganda',
                        'native_name' => 'Luganda',
                    ),
                90 =>
                    array(
                        'code' => 'li',
                        'name' => 'Limburgish, Limburgan, Limburger',
                        'native_name' => 'Limburgs',
                    ),
                91 =>
                    array(
                        'code' => 'ln',
                        'name' => 'Lingala',
                        'native_name' => 'Lingála',
                    ),
                92 =>
                    array(
                        'code' => 'lo',
                        'name' => 'Lao',
                        'native_name' => 'ພາສາລາວ',
                    ),
                93 =>
                    array(
                        'code' => 'lt',
                        'name' => 'Lithuanian',
                        'native_name' => 'lietuvių kalba',
                    ),
                94 =>
                    array(
                        'code' => 'lu',
                        'name' => 'Luba-Katanga',
                        'native_name' => '',
                    ),
                95 =>
                    array(
                        'code' => 'lv',
                        'name' => 'Latvian',
                        'native_name' => 'latviešu valoda',
                    ),
                96 =>
                    array(
                        'code' => 'gv',
                        'name' => 'Manx',
                        'native_name' => 'Gaelg, Gailck',
                    ),
                97 =>
                    array(
                        'code' => 'mk',
                        'name' => 'Macedonian',
                        'native_name' => 'македонски јазик',
                    ),
                98 =>
                    array(
                        'code' => 'mg',
                        'name' => 'Malagasy',
                        'native_name' => 'Malagasy fiteny',
                    ),
                99 =>
                    array(
                        'code' => 'ms',
                        'name' => 'Malay',
                        'native_name' => 'bahasa Melayu, بهاس ملايو‎',
                    ),
                100 =>
                    array(
                        'code' => 'ml',
                        'name' => 'Malayalam',
                        'native_name' => 'മലയാളം',
                    ),
                101 =>
                    array(
                        'code' => 'mt',
                        'name' => 'Maltese',
                        'native_name' => 'Malti',
                    ),
                102 =>
                    array(
                        'code' => 'mi',
                        'name' => 'Māori',
                        'native_name' => 'te reo Māori',
                    ),
                103 =>
                    array(
                        'code' => 'mr',
                        'name' => 'Marathi (Marāṭhī)',
                        'native_name' => 'मराठी',
                    ),
                104 =>
                    array(
                        'code' => 'mh',
                        'name' => 'Marshallese',
                        'native_name' => 'Kajin M̧ajeļ',
                    ),
                105 =>
                    array(
                        'code' => 'mn',
                        'name' => 'Mongolian',
                        'native_name' => 'монгол',
                    ),
                106 =>
                    array(
                        'code' => 'na',
                        'name' => 'Nauru',
                        'native_name' => 'Ekakairũ Naoero',
                    ),
                107 =>
                    array(
                        'code' => 'nv',
                        'name' => 'Navajo, Navaho',
                        'native_name' => 'Diné bizaad, Dinékʼehǰí',
                    ),
                108 =>
                    array(
                        'code' => 'nb',
                        'name' => 'Norwegian Bokmål',
                        'native_name' => 'Norsk bokmål',
                    ),
                109 =>
                    array(
                        'code' => 'nd',
                        'name' => 'North Ndebele',
                        'native_name' => 'isiNdebele',
                    ),
                110 =>
                    array(
                        'code' => 'ne',
                        'name' => 'Nepali',
                        'native_name' => 'नेपाली',
                    ),
                111 =>
                    array(
                        'code' => 'ng',
                        'name' => 'Ndonga',
                        'native_name' => 'Owambo',
                    ),
                112 =>
                    array(
                        'code' => 'nn',
                        'name' => 'Norwegian Nynorsk',
                        'native_name' => 'Norsk nynorsk',
                    ),
                113 =>
                    array(
                        'code' => 'no',
                        'name' => 'Norwegian',
                        'native_name' => 'Norsk',
                    ),
                114 =>
                    array(
                        'code' => 'ii',
                        'name' => 'Nuosu',
                        'native_name' => 'ꆈꌠ꒿ Nuosuhxop',
                    ),
                115 =>
                    array(
                        'code' => 'nr',
                        'name' => 'South Ndebele',
                        'native_name' => 'isiNdebele',
                    ),
                116 =>
                    array(
                        'code' => 'oc',
                        'name' => 'Occitan',
                        'native_name' => 'Occitan',
                    ),
                117 =>
                    array(
                        'code' => 'oj',
                        'name' => 'Ojibwe, Ojibwa',
                        'native_name' => 'ᐊᓂᔑᓈᐯᒧᐎᓐ',
                    ),
                118 =>
                    array(
                        'code' => 'cu',
                        'name' => 'Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',
                        'native_name' => 'ѩзыкъ словѣньскъ',
                    ),
                119 =>
                    array(
                        'code' => 'om',
                        'name' => 'Oromo',
                        'native_name' => 'Afaan Oromoo',
                    ),
                120 =>
                    array(
                        'code' => 'or',
                        'name' => 'Oriya',
                        'native_name' => 'ଓଡ଼ିଆ',
                    ),
                121 =>
                    array(
                        'code' => 'os',
                        'name' => 'Ossetian, Ossetic',
                        'native_name' => 'ирон æвзаг',
                    ),
                122 =>
                    array(
                        'code' => 'pa',
                        'name' => 'Panjabi, Punjabi',
                        'native_name' => 'ਪੰਜਾਬੀ, پنجابی‎',
                    ),
                123 =>
                    array(
                        'code' => 'pi',
                        'name' => 'Pāli',
                        'native_name' => 'पाऴि',
                    ),
                124 =>
                    array(
                        'code' => 'fa',
                        'name' => 'Persian',
                        'native_name' => 'فارسی',
                    ),
                125 =>
                    array(
                        'code' => 'pl',
                        'name' => 'Polish',
                        'native_name' => 'polski',
                    ),
                126 =>
                    array(
                        'code' => 'ps',
                        'name' => 'Pashto, Pushto',
                        'native_name' => 'پښتو',
                    ),
                127 =>
                    array(
                        'code' => 'pt',
                        'name' => 'Portuguese',
                        'native_name' => 'Português',
                    ),
                128 =>
                    array(
                        'code' => 'qu',
                        'name' => 'Quechua',
                        'native_name' => 'Runa Simi, Kichwa',
                    ),
                129 =>
                    array(
                        'code' => 'rm',
                        'name' => 'Romansh',
                        'native_name' => 'rumantsch grischun',
                    ),
                130 =>
                    array(
                        'code' => 'rn',
                        'name' => 'Kirundi',
                        'native_name' => 'kiRundi',
                    ),
                131 =>
                    array(
                        'code' => 'ro',
                        'name' => 'Romanian, Moldavian, Moldovan',
                        'native_name' => 'română',
                    ),
                132 =>
                    array(
                        'code' => 'ru',
                        'name' => 'Russian',
                        'native_name' => 'русский язык',
                    ),
                133 =>
                    array(
                        'code' => 'sa',
                        'name' => 'Sanskrit (Saṁskṛta)',
                        'native_name' => 'संस्कृतम्',
                    ),
                134 =>
                    array(
                        'code' => 'sc',
                        'name' => 'Sardinian',
                        'native_name' => 'sardu',
                    ),
                135 =>
                    array(
                        'code' => 'sd',
                        'name' => 'Sindhi',
                        'native_name' => 'सिन्धी, سنڌي، سندھی‎',
                    ),
                136 =>
                    array(
                        'code' => 'se',
                        'name' => 'Northern Sami',
                        'native_name' => 'Davvisámegiella',
                    ),
                137 =>
                    array(
                        'code' => 'sm',
                        'name' => 'Samoan',
                        'native_name' => 'gagana faa Samoa',
                    ),
                138 =>
                    array(
                        'code' => 'sg',
                        'name' => 'Sango',
                        'native_name' => 'yângâ tî sängö',
                    ),
                139 =>
                    array(
                        'code' => 'sr',
                        'name' => 'Serbian',
                        'native_name' => 'српски језик',
                    ),
                140 =>
                    array(
                        'code' => 'gd',
                        'name' => 'Scottish Gaelic; Gaelic',
                        'native_name' => 'Gàidhlig',
                    ),
                141 =>
                    array(
                        'code' => 'sn',
                        'name' => 'Shona',
                        'native_name' => 'chiShona',
                    ),
                142 =>
                    array(
                        'code' => 'si',
                        'name' => 'Sinhala, Sinhalese',
                        'native_name' => 'සිංහල',
                    ),
                143 =>
                    array(
                        'code' => 'sk',
                        'name' => 'Slovak',
                        'native_name' => 'slovenčina',
                    ),
                144 =>
                    array(
                        'code' => 'sl',
                        'name' => 'Slovene',
                        'native_name' => 'slovenščina',
                    ),
                145 =>
                    array(
                        'code' => 'so',
                        'name' => 'Somali',
                        'native_name' => 'Soomaaliga, af Soomaali',
                    ),
                146 =>
                    array(
                        'code' => 'st',
                        'name' => 'Southern Sotho',
                        'native_name' => 'Sesotho',
                    ),
                147 =>
                    array(
                        'code' => 'es',
                        'name' => 'Spanish; Castilian',
                        'native_name' => 'español, castellano',
                    ),
                148 =>
                    array(
                        'code' => 'su',
                        'name' => 'Sundanese',
                        'native_name' => 'Basa Sunda',
                    ),
                149 =>
                    array(
                        'code' => 'sw',
                        'name' => 'Swahili',
                        'native_name' => 'Kiswahili',
                    ),
                150 =>
                    array(
                        'code' => 'ss',
                        'name' => 'Swati',
                        'native_name' => 'SiSwati',
                    ),
                151 =>
                    array(
                        'code' => 'sv',
                        'name' => 'Swedish',
                        'native_name' => 'svenska',
                    ),
                152 =>
                    array(
                        'code' => 'ta',
                        'name' => 'Tamil',
                        'native_name' => 'தமிழ்',
                    ),
                153 =>
                    array(
                        'code' => 'te',
                        'name' => 'Telugu',
                        'native_name' => 'తెలుగు',
                    ),
                154 =>
                    array(
                        'code' => 'tg',
                        'name' => 'Tajik',
                        'native_name' => 'тоҷикӣ, toğikī, تاجیکی‎',
                    ),
                155 =>
                    array(
                        'code' => 'th',
                        'name' => 'Thai',
                        'native_name' => 'ไทย',
                    ),
                156 =>
                    array(
                        'code' => 'ti',
                        'name' => 'Tigrinya',
                        'native_name' => 'ትግርኛ',
                    ),
                157 =>
                    array(
                        'code' => 'bo',
                        'name' => 'Tibetan Standard, Tibetan, Central',
                        'native_name' => 'བོད་ཡིག',
                    ),
                158 =>
                    array(
                        'code' => 'tk',
                        'name' => 'Turkmen',
                        'native_name' => 'Türkmen, Түркмен',
                    ),
                159 =>
                    array(
                        'code' => 'tl',
                        'name' => 'Tagalog',
                        'native_name' => 'Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔',
                    ),
                160 =>
                    array(
                        'code' => 'tn',
                        'name' => 'Tswana',
                        'native_name' => 'Setswana',
                    ),
                161 =>
                    array(
                        'code' => 'to',
                        'name' => 'Tonga (Tonga Islands)',
                        'native_name' => 'faka Tonga',
                    ),
                162 =>
                    array(
                        'code' => 'tr',
                        'name' => 'Turkish',
                        'native_name' => 'Türkçe',
                    ),
                163 =>
                    array(
                        'code' => 'ts',
                        'name' => 'Tsonga',
                        'native_name' => 'Xitsonga',
                    ),
                164 =>
                    array(
                        'code' => 'tt',
                        'name' => 'Tatar',
                        'native_name' => 'татарча, tatarça, تاتارچا‎',
                    ),
                165 =>
                    array(
                        'code' => 'tw',
                        'name' => 'Twi',
                        'native_name' => 'Twi',
                    ),
                166 =>
                    array(
                        'code' => 'ty',
                        'name' => 'Tahitian',
                        'native_name' => 'Reo Tahiti',
                    ),
                167 =>
                    array(
                        'code' => 'ug',
                        'name' => 'Uighur, Uyghur',
                        'native_name' => 'Uyƣurqə, ئۇيغۇرچە‎',
                    ),
                168 =>
                    array(
                        'code' => 'uk',
                        'name' => 'Ukrainian',
                        'native_name' => 'українська',
                    ),
                169 =>
                    array(
                        'code' => 'ur',
                        'name' => 'Urdu',
                        'native_name' => 'اردو',
                    ),
                170 =>
                    array(
                        'code' => 'uz',
                        'name' => 'Uzbek',
                        'native_name' => 'zbek, Ўзбек, أۇزبېك‎',
                    ),
                171 =>
                    array(
                        'code' => 've',
                        'name' => 'Venda',
                        'native_name' => 'Tshivenḓa',
                    ),
                172 =>
                    array(
                        'code' => 'vi',
                        'name' => 'Vietnamese',
                        'native_name' => 'Tiếng Việt',
                    ),
                173 =>
                    array(
                        'code' => 'vo',
                        'name' => 'Volapük',
                        'native_name' => 'Volapük',
                    ),
                174 =>
                    array(
                        'code' => 'wa',
                        'name' => 'Walloon',
                        'native_name' => 'Walon',
                    ),
                175 =>
                    array(
                        'code' => 'cy',
                        'name' => 'Welsh',
                        'native_name' => 'Cymraeg',
                    ),
                176 =>
                    array(
                        'code' => 'wo',
                        'name' => 'Wolof',
                        'native_name' => 'Wollof',
                    ),
                177 =>
                    array(
                        'code' => 'fy',
                        'name' => 'Western Frisian',
                        'native_name' => 'Frysk',
                    ),
                178 =>
                    array(
                        'code' => 'xh',
                        'name' => 'Xhosa',
                        'native_name' => 'isiXhosa',
                    ),
                179 =>
                    array(
                        'code' => 'yi',
                        'name' => 'Yiddish',
                        'native_name' => 'ייִדיש',
                    ),
                180 =>
                    array(
                        'code' => 'yo',
                        'name' => 'Yoruba',
                        'native_name' => 'Yorùbá',
                    ),
                181 =>
                    array(
                        'code' => 'za',
                        'name' => 'Zhuang, Chuang',
                        'native_name' => 'Saɯ cueŋƅ, Saw cuengh',
                    ),
            );

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
