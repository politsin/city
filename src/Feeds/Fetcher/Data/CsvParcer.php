<?php

namespace Drupal\city\Feeds\Fetcher\Data;

use Drupal\Component\Transliteration\PhpTransliteration;

/**
 * Provides RussiaYandex.
 */
class CsvParcer {

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
        $header = explode(",", trim($value));
      }
      else {
        $line = explode(",", $value);
        $row = [];
        foreach ($line as $k => $v) {
          $kk = $header[$k];
          $row[$kk] = trim($v);
        }
        if ($row['count'] >= $count) {
          $name = mb_strtolower($row['name']);
          $name = str_replace(' ', '-', $name);
          $ru = preg_replace('/\-+/', '-', $name);
          $trans = new PhpTransliteration();
          $en = $trans->transliterate($name, '');
          $row['ru'] = $name;
          $row['en'] = $en;
          if (!$row['in']) {
            $row['in'] = $row['name'];
          }
          $result[] = $row;
        }
      }
    }

    $data = [
      'header' => $header,
      'data' => $result,
    ];
    dsm($result);
    $d = json_encode($data, JSON_UNESCAPED_UNICODE);
    return $d;
  }

  /**
   * {@inheritdoc}
   */
  public static function csv() {
    $path = __DIR__ . "/RuYa-406.csv";
    $path = __DIR__ . "/USA-304.csv";
    $path = __DIR__ . "/UK-174.csv";
    $csv = file_get_contents($path);
    return $csv;
  }

}
