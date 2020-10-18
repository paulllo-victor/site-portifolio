<?php

    class Site{
        public static function slider()
        {
            $con = COnnection::conectar();
            $st = $con->prepare("SELECT * FROM `banners` WHERE active = 1");
            $st->execute();

            return $st->fetchAll();
        }
    }