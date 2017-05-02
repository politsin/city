<?php

namespace Drupal\city\Feeds\Fetcher\Data;

use Drupal\Component\Serialization\Json;
use Drupal\Component\Transliteration\PhpTransliteration;

/**
 * Provides RussiaYandex.
 */
class RussiaYandex {

  /**
   * {@inheritdoc}
   */
  public static function get($count = 0) {
    $csv = self::csv();
    $arr = explode("\n", $csv);
    $result = [];
    $header = [];
    foreach ($arr as $key => $value) {
      if (!$key) {
        $header = explode(",", $value);
      }
      else {
        $line = explode(",", $value);
        $row = [];
        foreach ($line as $k => $v) {
          $kk = $header[$k];
          $row[$kk] = $v;
        }
        if ($row['count'] >= $count) {
          $name = mb_strtolower($row['name']);
          $name = str_replace(' ', '-', $name);
          $ru = preg_replace('/\-+/', '-', $name);
          $trans = new PhpTransliteration();
          $en = $trans->transliterate($name, '');
          $row['ru'] = $name;
          $row['en'] = $en;
          $result[] = $row;
        }
      }
    }

    $data = [
      'header' => $header,
      'data' => $result,
    ];
    $d = json_encode($data, JSON_UNESCAPED_UNICODE);
    return $d;
  }

  /**
   * {@inheritdoc}
   */
  public static function csv() {

    $csv = 'key,name,parent,region,rid,pid,in,count
213,Москва,Столицы,Россия,225,225X,Москве,12198
2,Санкт-Петербург,Столицы,Россия,225,225X,Санкт-Петербурге,5192
4,Белгород,Белгородская область,Центр,3,10645,Белгороде,384
10646,Губкин,Белгородская область,Центр,3,10645,Губкине,87
10649,Старый Оскол,Белгородская область,Центр,3,10645,Старом Осколе,221
20192,Алексеевка,Белгородская область,Центр,3,10645,Алексеевке,38
20196,Шебекино,Белгородская область,Центр,3,10645,Шебекино,42
20587,Строитель,Белгородская область,Центр,3,10645,Строителе,57
191,Брянск,Брянская область,Центр,3,10650,Брянске,407
10653,Клинцы,Брянская область,Центр,3,10650,Клинцах,62
192,Владимир,Владимирская область,Центр,3,10658,Владимире,353
10661,Гусь-Хрустальный,Владимирская область,Центр,3,10658,Гусе-Хрустальном,56
10664,Ковров,Владимирская область,Центр,3,10658,Коврове,140
10668,Муром,Владимирская область,Центр,3,10658,Муроме,111
10656,Александров,Владимирская область,Центр,3,10658,Александрове,59
10663,Киржач,Владимирская область,Центр,3,10658,Киржаче,27
37129,Покров,Владимирская область,Центр,3,10658,Покрове,17
193,Воронеж,Воронежская область,Центр,3,10672,Воронеже,1024
10681,Россошь,Воронежская область,Центр,3,10672,Россоши,62
5,Иваново,Ивановская область,Центр,3,10687,Иваново,409
10689,Кинешма,Ивановская область,Центр,3,10687,Кинешме,84
10691,Шуя,Ивановская область,Центр,3,10687,Шуе,58
6,Калуга,Калужская область,Центр,3,10693,Калуге,343
967,Обнинск,Калужская область,Центр,3,10693,Обнинске,109
10697,Малоярославец,Калужская область,Центр,3,10693,Малоярославце,28
7,Кострома,Костромская область,Центр,3,10699,Костроме,276
8,Курск,Курская область,Центр,3,10705,Курске,435
20086,Железногорск,Красноярский край,Сибирь,59,11309,Железногорске,84
20707,Курчатов,Курская область,Центр,3,10705,Курчатове,38
9,Липецк,Липецкая область,Центр,3,10712,Липецке,510
10713,Елец,Липецкая область,Центр,3,10712,Ельце,106
10,Орёл,Орловская область,Центр,3,10772,Орле,320
11,Рязань,Рязанская область,Центр,3,10776,Рязани,533
10773,Касимов,Рязанская область,Центр,3,10776,Касимове,30
12,Смоленск,Смоленская область,Центр,3,10795,Смоленске,330
10782,Вязьма,Смоленская область,Центр,3,10795,Вязьме,53
10783,Гагарин,Смоленская область,Центр,3,10795,Гагарине,29
10801,Ярцево,Смоленская область,Центр,3,10795,Ярцево,45
13,Тамбов,Тамбовская область,Центр,3,10802,Тамбове,289
10803,Мичуринск,Тамбовская область,Центр,3,10802,Мичуринске,94
14,Тверь,Тверская область,Центр,3,10819,Твери,414
10807,Вышний Волочёк,Тверская область,Центр,3,10819,Вышнем Волочке,48
10811,Кимры,Тверская область,Центр,3,10819,Кимрах,46
10820,Ржев,Тверская область,Центр,3,10819,Ржеве,60
10805,Бологое,Тверская область,Центр,3,10819,Бологом,21
10812,Конаково,Тверская область,Центр,3,10819,Конаково,39
10824,Удомля,Тверская область,Центр,3,10819,Удомле,28
15,Тула,Тульская область,Центр,3,10832,Туле,488
10828,Ефремов,Тульская область,Центр,3,10832,Ефремове,36
10830,Новомосковск,Тульская область,Центр,3,10832,Новомосковске,127
20667,Богородицк,Тульская область,Центр,3,10832,Богородицке,32
16,Ярославль,Ярославская область,Центр,3,10841,Ярославле,604
10837,Переславль-Залесский,Ярославская область,Центр,3,10841,Переславле-Залесском,39
10839,Рыбинск,Ярославская область,Центр,3,10841,Рыбинске,193
21154,Тутаев,Ярославская область,Центр,3,10841,Тутаеве,40
10840,Углич,Ярославская область,Центр,3,10841,Угличе,32
216,Зеленоград,Московская область,Центр,3,1,Зеленограде,237
21624,Щербинка,Московская область,Центр,3,1,Щербинке,42
214,Долгопрудный,Московская область,Центр,3,1,Долгопрудном,104
215,Дубна,Московская область,Центр,3,1,Дубне,75
217,Пущино,Московская область,Центр,3,1,Пущино,21
219,Черноголовка,Московская область,Центр,3,1,Черноголовке,21
10716,Балашиха,Московская область,Центр,3,1,Балашихе,261
10717,Бронницы,Московская область,Центр,3,1,Бронницах,22
10725,Домодедово,Московская область,Центр,3,1,Домодедово,112
10729,Звенигород,Московская область,Центр,3,1,Звенигороде,22
10734,Коломна,Московская область,Центр,3,1,Коломне,144
10745,Орехово-Зуево,Московская область,Центр,3,1,Орехово-Зуево,120
10747,Подольск,Московская область,Центр,3,1,Подольске,224
10754,Серпухов,Московская область,Центр,3,1,Серпухове,127
10758,Химки,Московская область,Центр,3,1,Химках,232
20523,Электросталь,Московская область,Центр,3,1,Электростали,158
20571,Жуковский,Московская область,Центр,3,1,Жуковском,108
20576,Протвино,Московская область,Центр,3,1,Протвино,36
20728,Королёв,Московская область,Центр,3,1,Королёве,221
21619,Фрязино,Московская область,Центр,3,1,Фрязино,60
21621,Реутов,Московская область,Центр,3,1,Реутове,100
21623,Ивантеевка,Московская область,Центр,3,1,Ивантеевке,75
21630,Лыткарино,Московская область,Центр,3,1,Лыткарино,58
21635,Лосино-Петровский,Московская область,Центр,3,1,Лосино-Петровском,25
21641,Лобня,Московская область,Центр,3,1,Лобне,87
21647,Краснознаменск,Московская область,Центр,3,1,Краснознаменске,41
21735,Дзержинский,Московская область,Центр,3,1,Дзержинском,55
10721,Волоколамск,Московская область,Центр,3,1,Волоколамске,20
10722,Воскресенск,Московская область,Центр,3,1,Воскресенске,94
10723,Дмитров,Московская область,Центр,3,1,Дмитрове,67
10727,Егорьевск,Московская область,Центр,3,1,Егорьевске,74
10728,Зарайск,Московская область,Центр,3,1,Зарайске,23
10731,Истра,Московская область,Центр,3,1,Истре,35
21627,Дедовск,Московская область,Центр,3,1,Дедовске,30
10732,Кашира,Московская область,Центр,3,1,Кашире,49
10733,Клин,Московская область,Центр,3,1,Клине,79
10735,Красногорск,Московская область,Центр,3,1,Красногорске,138
21745,Нахабино,Московская область,Центр,3,1,Нахабино,41
10719,Видное,Московская область,Центр,3,1,Видном,65
10737,Луховицы,Московская область,Центр,3,1,Луховицах,30
10738,Люберцы,Московская область,Центр,3,1,Люберцах,189
10739,Можайск,Московская область,Центр,3,1,Можайске,30
10740,Мытищи,Московская область,Центр,3,1,Мытищах,187
10715,Апрелевка,Московская область,Центр,3,1,Апрелевке,27
10741,Наро-Фоминск,Московская область,Центр,3,1,Наро-Фоминске,62
10742,Ногинск,Московская область,Центр,3,1,Ногинске,102
21642,Электроугли,Московская область,Центр,3,1,Электроуглях,21
21656,Старая Купавна,Московская область,Центр,3,1,Старой Купавне,22
10743,Одинцово,Московская область,Центр,3,1,Одинцово,141
21625,Кубинка,Московская область,Центр,3,1,Кубинке,20
21646,Голицыно,Московская область,Центр,3,1,Голицыно,18
10746,Павловский Посад,Московская область,Центр,3,1,Павловском Посаде,65
10748,Пушкино,Московская область,Центр,3,1,Пушкино,108
10750,Раменское,Московская область,Центр,3,1,Раменском,106
10751,Руза,Московская область,Центр,3,1,Рузе,13
10756,Ступино,Московская область,Центр,3,1,Ступино,66
10752,Сергиев Посад,Московская область,Центр,3,1,Сергиев Посаде,106
21645,Хотьково,Московская область,Центр,3,1,Хотьково,21
10755,Солнечногорск,Московская область,Центр,3,1,Солнечногорске,53
10761,Чехов,Московская область,Центр,3,1,Чехове,71
10762,Шатура,Московская область,Центр,3,1,Шатурае,33
10765,Щелково,Московская область,Центр,3,1,Щёлково,125
100471,Красноармейск,Московская область,Центр,3,1,Красноармейске,26
10902,Нарьян-Мар,Ненецкий автономный округ,Северо-Запад,17,10176,Нарьян-Маре,24
20,Архангельск,Архангельская область,Северо-Запад,17,10842,Архангельске,351
10846,Котлас,Архангельская область,Северо-Запад,17,10842,Котласе,61
10849,Северодвинск,Архангельская область,Северо-Запад,17,10842,Северодвинске,186
21,Вологда,Вологодская область,Северо-Запад,17,10853,Вологде,311
968,Череповец,Вологодская область,Северо-Запад,17,10853,Череповце,318
22,Калининград,Калининградская область,Северо-Запад,17,10857,Калининграде,453
10860,Советск,Калининградская область,Северо-Запад,17,10857,Советске,40
23,Мурманск,Мурманская область,Северо-Запад,17,10897,Мурманске,305
10894,Апатиты,Мурманская область,Северо-Запад,17,10897,Апатитах,56
10896,Мончегорск,Мурманская область,Северо-Запад,17,10897,Мончегорске,42
20155,Оленегорск,Мурманская область,Северо-Запад,17,10897,Оленегорске,21
10895,Кандалакша,Мурманская область,Северо-Запад,17,10897,Кандалакша,32
24,Великий Новгород,Новгородская область,Северо-Запад,17,10904,Великом Новгороде,222
10906,Боровичи,Новгородская область,Северо-Запад,17,10904,Боровичах,51
10923,Старая Русса,Новгородская область,Северо-Запад,17,10904,Старой Руссе,29
25,Псков,Псковская область,Северо-Запад,17,10926,Пскове,208
10928,Великие Луки,Псковская область,Северо-Запад,17,10926,Великих Луках,92
18,Петрозаводск,Республика Карелия,Северо-Запад,17,10933,Петрозаводске,275
10935,Костомукша,Республика Карелия,Северо-Запад,17,10933,Костомукше,30
10934,Кондопога,Республика Карелия,Северо-Запад,17,10933,Кондопоге,31
10936,Сегежа,Республика Карелия,Северо-Запад,17,10933,Сегеже,27
10937,Сортавала,Республика Карелия,Северо-Запад,17,10933,Сортавале,18
19,Сыктывкар,Республика Коми,Северо-Запад,17,10939,Сыктывкаре,243
10940,Воркута,Республика Коми,Северо-Запад,17,10939,Воркуте,59
10941,Инта,Республика Коми,Северо-Запад,17,10939,Инте,26
10944,Усинск,Республика Коми,Северо-Запад,17,10939,Усинске,39
10945,Ухта,Республика Коми,Северо-Запад,17,10939,Ухте,98
10942,Печора,Республика Коми,Северо-Запад,17,10939,Печоре,40
10891,Сосновый Бор,Ленинградская область,Северо-Запад,17,10174,Сосновом Бору,67
10864,Волхов,Ленинградская область,Северо-Запад,17,10174,Волхове,45
10865,Всеволожск,Ленинградская область,Северо-Запад,17,10174,Всеволожске,68
969,Выборг,Ленинградская область,Северо-Запад,17,10174,Выборге,79
10867,Гатчина,Ленинградская область,Северо-Запад,17,10174,Гатчине,95
10870,Кингисепп,Ленинградская область,Северо-Запад,17,10174,Кингисеппе,47
10871,Кириши,Ленинградская область,Северо-Запад,17,10174,Киришах,52
10872,Кировск,Ленинградская область,Северо-Запад,17,10174,Кировске,25
10876,Луга,Ленинградская область,Северо-Запад,17,10174,Луге,36
10881,Подпорожье,Ленинградская область,Северо-Запад,17,10174,Подпорожье,17
10883,Приозерск,Ленинградская область,Северо-Запад,17,10174,Приозерске,18
10888,Сланцы,Ленинградская область,Северо-Запад,17,10174,Сланцах,33
10892,Тихвин,Ленинградская область,Северо-Запад,17,10174,Тихвине,57
10893,Тосно,Ленинградская область,Северо-Запад,17,10174,Тосно,38
37,Астрахань,Астраханская область,Юг,26,10946,Астрахани,533
20167,Ахтубинск,Астраханская область,Юг,26,10946,Ахтубинске,38
38,Волгоград,Волгоградская область,Юг,26,10950,Волгограде,1017
10951,Волжский,Волгоградская область,Юг,26,10950,Волжском,327
10959,Камышин,Волгоградская область,Юг,26,10950,Камышине,113
10965,Михайловка,Волгоградская область,Юг,26,10950,Михайловке,58
10981,Урюпинск,Волгоградская область,Юг,26,10950,Урюпинске,38
35,Краснодар,Краснодарский край,Юг,26,10995,Краснодаре,830
239,Сочи,Краснодарский край,Юг,26,10995,Сочи,390
970,Новороссийск,Краснодарский край,Юг,26,10995,Новороссийске,262
1107,Анапа,Краснодарский край,Юг,26,10995,Анапе,73
10987,Армавир,Краснодарский край,Юг,26,10995,Армавире,192
10990,Геленджик,Краснодарский край,Юг,26,10995,Геленджике,72
10988,Белореченск,Краснодарский край,Юг,26,10995,Белореченске,52
10993,Ейск,Краснодарский край,Юг,26,10995,Ейске,85
10996,Кропоткин,Краснодарский край,Юг,26,10995,Кропоткине,79
10997,Крымск,Краснодарский край,Юг,26,10995,Крымске,57
20704,Славянск-на-Кубани,Краснодарский край,Юг,26,10995,Славянске-на-Кубани,66
21141,Тимашёвск,Краснодарский край,Юг,26,10995,Тимашёвске,52
11002,Тихорецк,Краснодарский край,Юг,26,10995,Тихорецке,59
1058,Туапсе,Краснодарский край,Юг,26,10995,Туапсе,63
1093,Майкоп,Республика Адыгея,Юг,26,11004,Майкопе,144
1094,Элиста,Республика Калмыкия,Юг,26,11015,Элисте,104
39,Ростов-на-Дону,Ростовская область,Юг,26,11029,Ростове-на-Дону,1115
238,Новочеркасск,Ростовская область,Юг,26,11029,Новочеркасске,173
971,Таганрог,Ростовская область,Юг,26,11029,Таганроге,253
11030,Азов,Ростовская область,Юг,26,11029,Азове,81
11036,Волгодонск,Ростовская область,Юг,26,11029,Волгодонске,170
11043,Каменск-Шахтинский,Ростовская область,Юг,26,11029,Каменске-Шахтинском,90
11053,Шахты,Ростовская область,Юг,26,11029,Шахтах,237
11034,Белая Калитва,Ростовская область,Юг,26,11029,Белой Калитве,41
146,Симферополь,Крым,Юг,26,977,Симферополе,333
959,Севастополь,Крым,Юг,26,977,Севастополе,399
11463,Евпатория,Крым,Юг,26,977,Евпатории,106
11464,Керчь,Крым,Юг,26,977,Керчи,148
11469,Феодосия,Крым,Юг,26,977,Феодосии,67
11470,Ялта,Крым,Юг,26,977,Ялте,78
11471,Алушта,Крым,Юг,26,977,Алуште,30
11472,Судак,Крым,Юг,26,977,Судаке,17
20556,Саки,Крым,Юг,26,977,Саках,24
27217,Бахчисарай,Крым,Юг,26,977,Бахчисарае,27
28786,Щёлкино,Крым,Юг,26,977,Щёлкино,10
27555,Джанкой,Крым,Юг,26,977,Джанкое,38
27693,Красноперекопск,Крым,Юг,26,977,Красноперекопске,25
28892,Армянск,Крым,Юг,26,977,Армянске,21
46,Киров,Кировская область,Поволжье,40,11070,Кирове,493
11071,Кирово-Чепецк,Кировская область,Поволжье,40,11070,Кирово-Чепецке,73
20020,Вятские Поляны,Кировская область,Поволжье,40,11070,Вятских Полянах,32
41,Йошкар-Ола,Республика Марий Эл,Поволжье,40,11077,Йошкар-Оле,263
20721,Волжск,Республика Марий Эл,Поволжье,40,11077,Волжске,54
47,Нижний Новгород,Нижегородская область,Поволжье,40,11079,Нижнем Новгороде,1268
972,Дзержинск,Нижегородская область,Поволжье,40,11079,Дзержинске,234
11080,Арзамас,Нижегородская область,Поволжье,40,11079,Арзамасе,105
11083,Саров,Нижегородская область,Поволжье,40,11079,Сарове,94
20040,Выкса,Нижегородская область,Поволжье,40,11079,Выксе,53
20044,Кстово,Нижегородская область,Поволжье,40,11079,Кстово,67
11082,Павлово,Нижегородская область,Поволжье,40,11079,Павлово,58
48,Оренбург,Оренбургская область,Поволжье,40,11084,Оренбурге,561
11086,Бузулук,Оренбургская область,Поволжье,40,11084,Бузулуке,86
11087,Гай,Оренбургская область,Поволжье,40,11084,Гае,35
11090,Новотроицк,Оренбургская область,Поволжье,40,11084,Новотроицке,89
11091,Орск,Оренбургская область,Поволжье,40,11084,Орске,233
49,Пенза,Пензенская область,Поволжье,40,11095,Пензе,523
11101,Кузнецк,Пензенская область,Поволжье,40,11095,Кузнецке,84
50,Пермь,Пермский край,Поволжье,40,11108,Перми,1036
11110,Соликамск,Пермский край,Поволжье,40,11108,Соликамске,95
20237,Березники,Пермский край,Поволжье,40,11108,Березниках,149
20244,Лысьва,Пермский край,Поволжье,40,11108,Лысьве,63
20243,Чайковский,Пермский край,Поволжье,40,11108,Чайковском,83
172,Уфа,Республика Башкортостан,Поволжье,40,11111,Уфе,1106
11113,Кумертау,Республика Башкортостан,Поволжье,40,11111,Кумертау,61
11114,Нефтекамск,Республика Башкортостан,Поволжье,40,11111,Нефтекамске,125
11115,Салават,Республика Башкортостан,Поволжье,40,11111,Салавате,156
11116,Стерлитамак,Республика Башкортостан,Поволжье,40,11111,Стерлитамаке,279
20235,Октябрьский,Республика Башкортостан,Поволжье,40,11111,Октябрьском,112
20716,Сибай,Республика Башкортостан,Поволжье,40,11111,Сибае,61
20714,Белебей,Республика Башкортостан,Поволжье,40,11111,Белебее,59
20259,Белорецк,Республика Башкортостан,Поволжье,40,11111,Белорецке,66
20718,Ишимбай,Республика Башкортостан,Поволжье,40,11111,Ишимбае,65
20715,Мелеуз,Республика Башкортостан,Поволжье,40,11111,Мелеузе,59
20717,Туймазы,Республика Башкортостан,Поволжье,40,11111,Туймазах,68
20680,Учалы,Республика Башкортостан,Поволжье,40,11111,Учалы,37
42,Саранск,Республика Мордовия,Поволжье,40,11117,Саранске,303
20010,Рузаевка,Республика Мордовия,Поволжье,40,11117,Рузаевке,46
43,Казань,Республика Татарстан,Поволжье,40,11119,Казани,1206
236,Набережные Челны,Республика Татарстан,Поволжье,40,11119,Набережных Челнах,524
11121,Альметьевск,Республика Татарстан,Поволжье,40,11119,Альметьевске,151
11122,Бугульма,Республика Татарстан,Поволжье,40,11119,Бугульме,86
11127,Нижнекамск,Республика Татарстан,Поволжье,40,11119,Нижнекамске,236
51,Самара,Самарская область,Поволжье,40,11131,Самаре,1172
240,Тольятти,Самарская область,Поволжье,40,11131,Тольятти,720
11132,Жигулёвск,Самарская область,Поволжье,40,11131,Жигулёвске,55
11139,Сызрань,Самарская область,Поволжье,40,11131,Сызрани,175
194,Саратов,Саратовская область,Поволжье,40,11146,Саратове,842
11143,Балаково,Саратовская область,Поволжье,40,11146,Балаково,194
11144,Балашов,Саратовская область,Поволжье,40,11146,Балашове,78
11147,Энгельс,Саратовская область,Поволжье,40,11146,Энгельсе,222
44,Ижевск,Удмуртская Республика,Поволжье,40,11148,Ижевске,642
11149,Воткинск,Удмуртская Республика,Поволжье,40,11148,Воткинске,98
11150,Глазов,Удмуртская Республика,Поволжье,40,11148,Глазове,93
11152,Сарапул,Удмуртская Республика,Поволжье,40,11148,Сарапуле,98
195,Ульяновск,Ульяновская область,Поволжье,40,11153,Ульяновске,619
11155,Димитровград,Ульяновская область,Поволжье,40,11153,Димитровграде,117
45,Чебоксары,Чувашская Республика,Поволжье,40,11156,Чебоксарах,474
20078,Шумерля,Чувашская Республика,Поволжье,40,11156,Шумерле,29
37133,Новочебоксарск,Чувашская Республика,Поволжье,40,11156,Новочебоксарске,125
53,Курган,Курганская область,Урал,52,11158,Кургане,326
11159,Шадринск,Курганская область,Урал,52,11158,Шадринске,76
54,Екатеринбург,Свердловская область,Урал,52,11162,Екатеринбурге,1428
11160,Асбест,Свердловская область,Урал,52,11162,Асбесте,65
11161,Верхняя Салда,Свердловская область,Урал,52,11162,Верхней Салде,43
11164,Каменск-Уральский,Свердловская область,Урал,52,11162,Каменск-Уральске,171
11165,Краснотурьинск,Свердловская область,Урал,52,11162,Краснотурьинске,58
11166,Кушва,Свердловская область,Урал,52,11162,Кушве,28
11167,Лесной,Свердловская область,Урал,52,11162,Лесном,49
11168,Нижний Тагил,Свердловская область,Урал,52,11162,Нижнем Тагиле,357
11169,Нижняя Тура,Свердловская область,Урал,52,11162,Нижней Туре,20
11170,Новоуральск,Свердловская область,Урал,52,11162,Новоуральске,81
11171,Первоуральск,Свердловская область,Урал,52,11162,Первоуральске,125
11172,Серов,Свердловская область,Урал,52,11162,Серове,97
20224,Ревда,Свердловская область,Урал,52,11162,Ревде,62
20234,Качканар,Свердловская область,Урал,52,11162,Качканаре,39
20654,Невьянск,Свердловская область,Урал,52,11162,Невьянске,23
20672,Североуральск,Свердловская область,Урал,52,11162,Североуральске,26
20684,Реж,Свердловская область,Урал,52,11162,Реже,37
20691,Красноуфимск,Свердловская область,Урал,52,11162,Красноуфимске,38
20720,Верхняя Пышма,Свердловская область,Урал,52,11162,Верхней Пышме,68
21726,Полевской,Свердловская область,Урал,52,11162,Полевском,62
29397,Берёзовский,Свердловская область,Урал,52,11162,Берёзовском,56
55,Тюмень,Тюменская область,Урал,52,11176,Тюмени,697
11173,Ишим,Тюменская область,Урал,52,11176,Ишиме,66
11175,Тобольск,Тюменская область,Урал,52,11176,Тобольске,98
11178,Ялуторовск,Тюменская область,Урал,52,11176,Ялуторовске,40
57,Ханты-Мансийск,Ханты-Мансийский автономный округ,Урал,52,11193,Ханты-Мансийске,97
973,Сургут,Ханты-Мансийский автономный округ,Урал,52,11193,Сургуте,341
1091,Нижневартовск,Ханты-Мансийский автономный округ,Урал,52,11193,Нижневартовске,270
11177,Югорск,Ханты-Мансийский автономный округ,Урал,52,11193,Югорске,37
11180,Когалым,Ханты-Мансийский автономный округ,Урал,52,11193,Когалыме,63
11181,Лангепас,Ханты-Мансийский автономный округ,Урал,52,11193,Лангепасе,43
11182,Мегион,Ханты-Мансийский автономный округ,Урал,52,11193,Мегионе,48
11184,Нефтеюганск,Ханты-Мансийский автономный округ,Урал,52,11193,Нефтеюганске,125
11186,Нягань,Ханты-Мансийский автономный округ,Урал,52,11193,Нягани,57
11188,Пыть-Ях,Ханты-Мансийский автономный округ,Урал,52,11193,Пыть-Яхе,40
11189,Радужный,Ханты-Мансийский автономный округ,Урал,52,11193,Радужном,43
11192,Урай,Ханты-Мансийский автономный округ,Урал,52,11193,Урае,40
56,Челябинск,Челябинская область,Урал,52,11225,Челябинске,1183
20674,Троицк,Челябинская область,Урал,52,11225,Троицке,75
235,Магнитогорск,Челябинская область,Урал,52,11225,Магнитогорске,417
11200,Верхний Уфалей,Челябинская область,Урал,52,11225,Верхнем Уфалее,28
11202,Златоуст,Челябинская область,Урал,52,11225,Златоусте,170
11207,Копейск,Челябинская область,Урал,52,11225,Копейске,145
11212,Миасс,Челябинская область,Урал,52,11225,Миассе,151
11214,Озёрск,Челябинская область,Урал,52,11225,Озёрске,79
11218,Снежинск,Челябинская область,Урал,52,11225,Снежинске,50
11223,Усть-Катав,Челябинская область,Урал,52,11225,Усть-Катаве,22
11217,Сатка,Челябинская область,Урал,52,11225,Сатке,42
58,Салехард,Ямало-Ненецкий автономный округ,Урал,52,11232,Салехарде,48
11228,Губкинский,Ямало-Ненецкий автономный округ,Урал,52,11232,Губкинском,27
11230,Новый Уренгой,Ямало-Ненецкий автономный округ,Урал,52,11232,Новом Уренгое,115
11231,Ноябрьск,Ямало-Ненецкий автономный округ,Урал,52,11232,Ноябрьске,107
11229,Надым,Ямало-Ненецкий автономный округ,Урал,52,11232,Надыме,44
11319,Горно-Алтайск,Республика Алтай,Сибирь,59,10231,Горно-Алтайске,62
10233,Кызыл,Республика Тыва,Сибирь,59,10233,Кызыле,114
197,Барнаул,Алтайский край,Сибирь,59,11235,Барнауле,636
975,Бийск,Алтайский край,Сибирь,59,11235,Бийске,204
11240,Заринск,Алтайский край,Сибирь,59,11235,Заринске,47
11251,Рубцовск,Алтайский край,Сибирь,59,11235,Рубцовске,147
63,Иркутск,Иркутская область,Сибирь,59,11266,Иркутске,620
976,Братск,Иркутская область,Сибирь,59,11266,Братске,236
11256,Ангарск,Иркутская область,Сибирь,59,11266,Ангарске,228
11271,Тулун,Иркутская область,Сибирь,59,11266,Тулуне,41
11272,Усолье-Сибирское,Иркутская область,Сибирь,59,11266,Усолье-Сибирском,78
11273,Усть-Илимск,Иркутская область,Сибирь,59,11266,Усть-Илимске,82
11274,Черемхово,Иркутская область,Сибирь,59,11266,Черемхово,51
11268,Нижнеудинск,Иркутская область,Сибирь,59,11266,Нижнекамске,235
11270,Тайшет,Иркутская область,Сибирь,59,11266,Тайшете,33
20097,Усть-Кут,Иркутская область,Сибирь,59,11266,Усть-Куте,42
64,Кемерово,Кемеровская область,Сибирь,59,11282,Кемерово,549
237,Новокузнецк,Кемеровская область,Сибирь,59,11282,Новокузнецке,550
11276,Анжеро-Судженск,Кемеровская область,Сибирь,59,11282,Анжеро-Судженске,73
11277,Белово,Кемеровская область,Сибирь,59,11282,Белово,73
11283,Киселёвск,Кемеровская область,Сибирь,59,11282,Киселёвске,92
11285,Ленинск-Кузнецкий,Кемеровская область,Сибирь,59,11282,Ленинск-Кузнецком,97
11287,Междуреченск,Кемеровская область,Сибирь,59,11282,Междуреченске,98
11288,Мыски,Кемеровская область,Сибирь,59,11282,Мысках,41
11291,Прокопьевск,Кемеровская область,Сибирь,59,11282,Прокопьевске,201
11292,Полысаево,Кемеровская область,Сибирь,59,11282,Полысаево,26
11299,Юрга,Кемеровская область,Сибирь,59,11282,Юрге,82
62,Красноярск,Красноярский край,Сибирь,59,11309,Красноярске,1052
11302,Ачинск,Красноярский край,Сибирь,59,11309,Ачинске,106
11310,Минусинск,Красноярский край,Сибирь,59,11309,Минусинск,69
11311,Норильск,Красноярский край,Сибирь,59,11309,Норильске,176
20088,Зеленогорск,Красноярский край,Сибирь,59,11309,Зеленогорске,62
65,Новосибирск,Новосибирская область,Сибирь,59,11316,Новосибирске,1567
20100,Искитим,Новосибирская область,Сибирь,59,11316,Искитиме,57
66,Омск,Омская область,Сибирь,59,11318,Омске,1174
198,Улан-Удэ,Республика Бурятия,Сибирь,59,11330,Улан-Удэ,427
11327,Северобайкальск,Республика Бурятия,Сибирь,59,11330,Северобайкальске,23
1095,Абакан,Республика Хакасия,Сибирь,59,11340,Абакане,176
67,Томск,Томская область,Сибирь,59,11353,Томске,565
11351,Северск,Томская область,Сибирь,59,11353,Северске,108
11352,Стрежевой,Томская область,Сибирь,59,11353,Стрежевом,42
68,Чита,Забайкальский край,Сибирь,59,21949,Чите,339
10243,Биробиджан,Еврейская автономная область,Дальний Восток,73,10243,Биробиджане,74
10251,Анадырь,Чукотский автономный округ,Дальний Восток,73,10251,Анадыре,15
77,Благовещенск,Амурская область,Дальний Восток,73,11375,Благовещенске,224
11374,Белогорск,Амурская область,Дальний Восток,73,11375,Белогорске,66
11387,Свободный,Амурская область,Дальний Восток,73,11375,Свободном,54
11391,Тында,Амурская область,Дальний Восток,73,11375,Тынде,33
78,Петропавловск-Камчатский,Камчатский край,Дальний Восток,73,11398,Петропавловске-Камчатском,181
79,Магадан,Магаданская область,Дальний Восток,73,11403,Магадане,92
75,Владивосток,Приморский край,Дальний Восток,73,11409,Владивостоке,605
974,Находка,Приморский край,Дальний Восток,73,11409,Находке,156
11405,Арсеньев,Приморский край,Дальний Восток,73,11409,Арсеньеве,53
11406,Артём,Приморский край,Дальний Восток,73,11409,Артёме,104
11411,Дальнегорск,Приморский край,Дальний Восток,73,11409,Дальнегорске,35
11426,Уссурийск,Приморский край,Дальний Восток,73,11409,Уссурийске,168
74,Якутск,Республика Саха (Якутия),Дальний Восток,73,11443,Якутске,299
11437,Нерюнгри,Республика Саха (Якутия),Дальний Восток,73,11443,Нерюнграх,57
80,Южно-Сахалинск,Сахалинская область,Дальний Восток,73,11450,Южно-Сахалинске,193
76,Хабаровск,Хабаровский край,Дальний Восток,73,11457,Хабаровске,607
11453,Комсомольск-на-Амуре,Хабаровский край,Дальний Восток,73,11457,Комсомольске-на-Амуре,253
11451,Амурск,Хабаровский край,Дальний Восток,73,11457,Амурске,40
28,Махачкала,Республика Дагестан,Северный Кавказ,102444,11010,Махачкале,583
11006,Буйнакск,Республика Дагестан,Северный Кавказ,102444,11010,Буйнакске,64
11007,Дербент,Республика Дагестан,Северный Кавказ,102444,11010,Дербенте,121
11008,Каспийск,Республика Дагестан,Северный Кавказ,102444,11010,Каспийске,107
11009,Кизляр,Республика Дагестан,Северный Кавказ,102444,11010,Кизляре,48
11011,Хасавюрт,Республика Дагестан,Северный Кавказ,102444,11010,Хасавюрте,137
21521,Избербаш,Республика Дагестан,Северный Кавказ,102444,11010,Избербаше,58
1092,Назрань,Республика Ингушетия,Северный Кавказ,102444,11012,Назрани,109
30,Нальчик,Кабардино-Балкарская Республика,Северный Кавказ,102444,11013,Нальчике,239
1104,Черкесск,Карачаево-Черкесская Республика,Северный Кавказ,102444,11020,Черкесске,124
33,Владикавказ,Республика Северная Осетия-Алания,Северный Кавказ,102444,11021,Владикавказе,308
1106,Грозный,Чеченская Республика,Северный Кавказ,102444,11024,Грозном,284
36,Ставрополь,Ставропольский край,Северный Кавказ,102444,11069,Ставрополе,426
11056,Георгиевск,Ставропольский край,Северный Кавказ,102444,11069,Георгиевске,69
11057,Ессентуки,Ставропольский край,Северный Кавказ,102444,11069,Ессентуках,104
11062,Кисловодск,Ставропольский край,Северный Кавказ,102444,11069,Кисловодске,130
11063,Минеральные Воды,Ставропольский край,Северный Кавказ,102444,11069,Минеральных Водах,75
11064,Невинномысск,Ставропольский край,Северный Кавказ,102444,11069,Невинномысске,118
11067,Пятигорск,Ставропольский край,Северный Кавказ,102444,11069,Пятигорске,146
11055,Буденновск,Ставропольский край,Северный Кавказ,102444,11069,Буденновске,62';
    return $csv;
  }

}
