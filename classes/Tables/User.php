<?php
class User {

    public $login,
            $id_czytelnik,
            $email,
            $imie,
            $nazwisko,
            $plec,
            $rok_urodzenia,
            $opis_czytelnika,
            $zdjecie;


    public function getName() { // zwraca imie, nazwisko lub login
        $output = '';
        if($this->imie != '' || $this->nazwisko != '')
            $output =  $this->imie . " " . $this->nazwisko;
        else
            $output =  $this->login;

        return $output;
    }

}