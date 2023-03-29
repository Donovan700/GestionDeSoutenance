<?php
    class Etudiant
    {
        private $matricule;
        private $nom_etudiant;
        private $prenom_etudiant;
        private $niveau;
        private $parcours;
        private $adr_email;

        public function __construct($matricule , $nom_etudiant , $prenom_etudiant , $niveau , $parcours , $adr_email)
        {
            $this->matricule = $matricule;
            $this->nom_etudiant = $nom_etudiant;
            $this->prenom_etudiant = $prenom_etudiant;
            $this->niveau = $niveau;
            $this->parcours = $parcours;
            $this->adr_email = $adr_email;
        }

        public function getMatricule()
        {
            return $this->matricule;
        }
        public function getNom()
        {
            return $this->nom_etudiant;
        }
        public function getPrenom()
        {
            return $this->prenom_etudiant;
        }
        public function getNiveau()
        {
            return $this->niveau;
        }
        public function getParcours()
        {
            return $this->parcours;
        }
        public function getMail()
        {
            return $this->adr_email;
        }
    }
?>