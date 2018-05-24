<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author Дрей
 */
class Company {
    //Inner fields.
    public $description;
    public $id;
    //External fields.
    public $emails;
    
    public function AddEmail($email){
        $this->emails[] = $email;
        $email->company = $this;
    }
}
