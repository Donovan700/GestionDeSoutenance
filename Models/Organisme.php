<?php
    class Organisme
    {
        private $id_org;
        private $design;
        private $lieu;

        public function __construct($id_org,$design,$lieu)
        {
            $this->id_org = $id_org;
            $this->design = $design;
            $this->lieu = $lieu;
        }
        public function getId()
        {
            return $this->id_org;
        }
        public function getDesign()
        {
            return $this->design;
        }
        public function getLieu()
        {
            return $this->lieu;
        }
    }
?>