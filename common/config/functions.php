<?php

function p($arr)
{
    header("Content-type:text/html;charset=utf-8");
	echo '<pre>';
	print_r($arr);
	echo '<pre>';
}

function recursion($arr, $pid=0, $type=1,$fid=0, $level=0) {
    switch($type) {
        case 1 : //组合多维数组
            $array = array();
            foreach ($arr as $v) {
                if ($v['pid'] == $pid) {
                    $array[$v['id']] = $v;
                    $array[$v['id']]['child'] = recursion($arr, $v['id']);
                }
            }
            return $array;

        case 2 : //组合一维数组
            static $array = array();
            static $i = -1;
            $i++;
            foreach ($arr as $v) {
                if ($v['pid'] == $pid) {
                    $array[$i] = $v;
                    $array[$i]['lv'] = $level;
                    $array[$i]['html'] = str_repeat('－', $level);
                    recursion($arr, $v['id'], $type, $fid, $level + 1);
                }
            }
            return $array;

        case 3 : //传递分类ID返回所有父级
            static $array = array();
            foreach ($arr as $v) {
                if ($v['id'] == $fid) {
                    $array[$v['id']] = $v;
                    recursion($arr, $pid, $type, $v['pid']);
                }
            }
            return array_reverse($array);
    }

}
