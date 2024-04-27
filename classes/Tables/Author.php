<?php
class Author {

    public $id_autor,
            $imie,
            $nazwisko,
            $data_urodzenia,
            $opi_autora,
            $zdjecie;


    public function getName() {
        $output = 'autor';
        if($this->imie != '' || $this->nazwisko != '')
            $output =  $this->imie . " " . $this->nazwisko;

        return $output;
    }

}