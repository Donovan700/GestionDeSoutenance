<?php
    class Professeur
    {
        private $id_prof;
        private $nom_prof;
        private $prenom_prof;
        private $civilite;
        private $grade;

        public function __construct($id_prof,$nom_prof,$prenom_prof,$civilite,$grade)
        {
            $this->id_prof = $id_prof;
            $this->nom_prof = $nom_prof;
            $this->prenom_prof = $prenom_prof;
            $this->civilite = $civilite;
            $this->grade = $grade;
        }
        public function getId()
        {
            return $this->id_prof;
        }
        public function getNom()
        {
            return $this->nom_prof;
        }
        public function getPrenom()
        {
            return $this->prenom_prof;
        }
        public function getCivilite()
        {
            return $this->civilite;
        }
        public function getGrade()
        {
            return $this->grade;
        }
    }
?>