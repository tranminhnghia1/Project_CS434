<?php
  function data_tree($data, $parent_cat = 0, $level = 0)
  {
      $result = array();
      foreach ($data as $item) {
          if ($item['parent_cat'] == $parent_cat) {
              $item['level'] = $level;
              $result[] = $item;
             // unset($data[$item['id']]);
              
                  $result_child = data_tree($data, $item['id'], $level + 1);
                  $result = array_merge($result, $result_child);
              
             
           }
      }
      return $result;
  } 

  //dd($result)
  ?>
