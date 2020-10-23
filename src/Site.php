<?php

    class Site{
        public static function slider()
        {
            $con = COnnection::conectar();
            $st = $con->prepare("SELECT * FROM `banners` WHERE active = 1");
            $st->execute();

            return $st->fetchAll();
        }
        public static function resumes()
        {
            $con = Connection::conectar();
            $st = $con->prepare("SELECT * FROM resume");
            $st->execute();

            return $st->fetchAll();
        }
    }