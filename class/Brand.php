<?php
class Brand {
    public $id_hangsx;
    public $name_hangsx;
    public $ma_cha;

    // Constructor
    public function __construct($id_hangsx, $name_hangsx, $ma_cha) {
        $this->id_hangsx = $id_hangsx;
        $this->name_hangsx = $name_hangsx;
        $this->ma_cha = $ma_cha;
    }
}

?>
