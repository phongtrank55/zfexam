<?php
    namespace Training;

    class Module
    {
        // public function onBootstrap()
        // {

        // }

        public function getConfig()
        {
            // $configArray = array();
            // return $configArray;
            return include __DIR__.'/../config/module.config.php';
        }

        // public function getAutoloadConfig()
        // {

        // }
    }

?>