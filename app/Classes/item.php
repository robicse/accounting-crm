<?php
namespace App\Classes;

class item {
    private $name;
    private $qty;
    private $price;
    private $dollarSign;

    public function __construct($name = '',$qty = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> qty = $qty;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $middleCols = 6;
        $leftCols = 30;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;
        $middle = str_pad($this -> qty, $middleCols) ;

        $sign = ($this -> dollarSign ? 'Tk. ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$middle$right\n";
    }
}
