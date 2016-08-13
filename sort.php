<?php


/**
 *  Вспомогательная функция нужна только для сортировок с присутсвием кирилицы
 */
function custom_str_sort_utf8($el1, $el2) {
  // Порядок сортировок зависит от ниже строк
  $cyr = 'абвгґдеёєжзиіїйклмнопрстуфхцчшщъыьэюя';
  $eng = 'abcdefghijklmnopqrstuvwxyz';
  $upper_cyr = mb_strtoupper($cyr);
  $upper_eng = mb_strtoupper($eng);
  $digit = '0123456789';
  $symbol = '_';
  $result_str = $digit . $upper_cyr . $upper_eng . $cyr . $eng . $symbol;

  $el1_len = mb_strlen($el1);
  $el2_len = mb_strlen($el2);
  $cur_pos = 0;

  // Пустая строка меньше полной
  if (empty($el1_len)) {
    if (empty($el2_len)) {
      return 0;
    }
    else {
      return 1;
    }
  }
  else {
    if (empty($el2_len)) {
      return -1;
    }
  }

  // Пробежимся по одинаковым вхождениям
  do {
    if ($cur_pos === $el1_len) {
      if ($cur_pos === $el2_len) {
        return 0;
      }
      else {
        return -1;
      }
    }
    else {
      if ($cur_pos === $el2_len) {
        return 1;
      }
    }
    $chr1 = mb_substr($el1, $cur_pos, 1);
    $chr2 = mb_substr($el2, $cur_pos, 1);
    $cur_pos++;
  } while ($chr1 === $chr2);

  // Символы на этой позиции уже не одинаковые
  $chr_pos1 = mb_strpos($result_str, $chr1);
  $chr_pos2 = mb_strpos($result_str, $chr2);

  if ($chr_pos1 === false) {
    if ($chr_pos2 === false) {
      if ($el1_len < $el2_len) {
        return -1;
      }
      elseif ($el1_len > $el2_len) {
        return 1;
      }
      else {
        return 0;
      }
    }
    else {
      return 1;
    }
  }
  else {
    if ($chr_pos2 === false) {
      return -1;
    }
    else {
      return ($chr_pos1 < $chr_pos2) ? -1 : 1;
    }
  }
// Сюда оброботчик никогда не доберётся
}
