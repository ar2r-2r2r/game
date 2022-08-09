<?php
    class User {
        private $login;
        private $password;
        private $level;

        function __construct($login, $password, $level) 
        {
            $this->login = $login;
            $this->password = $password;
            $this->login=$login;
        }

        function getLogin() {
            return $this->login;
        }

        function getPassword() {
            return $this->password;
        }
        
        function getLevel() {
            return $this->level;
        }
    }