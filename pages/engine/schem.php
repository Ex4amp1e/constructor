<?php
class Schem {
    function __construct( $params = [] )
    {
        if (isset($params['bd_link'])) {
            $this->bd = $params['bd_link'];
        }
    } 
    function SaveBlocks ( $params = [] ) {
        $query = "INSERT INTO blocks (id, name, eq_id, border, prod, parent_id, schem_id, return_level)";
        $values_arr = [];
        foreach ($params['blocks'] as $block) {
            if ($block['eq_id']==0) {
                $block['eq_id']='NULL';
            } 
        $values_arr[] = "({$block['id']},'{$block['name']}',{$block['eq_id']},'{$block['border']}','{$block['prod']}',{$block['parent']},{$params['schema_id']},{$block['return_level']})";
        }
        $query.=" VALUES ".implode(',', $values_arr);
        file_put_contents( 'data_3.txt', $query);
        $sql = mysqli_query($this->bd, $query);
    }

    function GetBlocks ( $params = [] ) {
        $id = $params['schema_id'];
        $sql = mysqli_query($this->bd, "SELECT b.id, b.name, b.eq_id, b.border, b.prod, b.parent_id as parent, b.schem_id, b.return_level, e.type_id as eq_type, e.name as eq_name from blocks b LEFT JOIN equipment e ON b.eq_id=e.id WHERE schem_id = {$id} ORDER BY b.id");
        $data = [];
        if (mysqli_num_rows($sql) > 0) {
            while( $row = mysqli_fetch_assoc($sql) )
            {
                $data[] = $row;
            }
        } 
        file_put_contents( 'data_test5.txt', print_r($data, true));
        return $data;
    }

}
