<?php
Class Datatables{

    var $CI = NULL;

    function __construct(){
        $this->CI =& get_instance();
    }

    function getOffset() {
        $start = 0;
        if (isset($_GET['start'])) {
            $start = intval($_GET['start']);

            if ($start < 0)
                $start = 0;
        }

        return $start;
    }

    function getLimit() {
        $rows = 10;
        if (isset($_GET['length'])) {
            $rows = intval($_GET['length']);
            if ($rows < 5 || $rows > 500) {
                $rows = 10;
            }
        }

        return $rows;
    }

    function getSortDir() {
        $sort_dir = "ASC";
        $sdir = strip_tags($_GET['order'][0]['dir']);
        if (isset($sdir)) {
            if ($sdir != "asc" ) {
                $sort_dir = "DESC";
            }
        }

        return $sort_dir;
    }

    function getSortCol($cols) {
        $sCol = $_GET['order'][0]['column'];
        $col = 0;

        if (isset($sCol)) {
            $col = intval($sCol);
            if ($col < 0 || $col > (count($cols) - 1))
                $col = 0;
        }
        $colName = $cols[$col];

        return $colName;
    }
}