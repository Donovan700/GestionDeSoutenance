<?php
    class Soutenir
    {
        private $matricule;
        private $id_org;
        private $annee_univ;
        private $id_president;
        private $id_examinateur;
        private $id_rapporteur_int;
        private $id_rapporteur_ext;
        private $note;

        public function __construct($matricule,$id_org,$annee_univ,$id_president,$id_examinateur,$id_rapporteur_int,$id_rapporteur_ext,$note)
        {
            $this->matricule = $matricule;
            $this->id_org = $id_org;
            $this->annee_univ = $annee_univ;
            $this->id_president = $id_president;
            $this->id_examinateur = $id_examinateur;
            $this->id_rapporteur_int = $id_rapporteur_int;
            $this->id_rapporteur_ext = $id_rapporteur_ext;
            $this->note = $note;
        }
        public function getMatricule()
        {
            return $this->matricule;
        }
        public function getOrg()
        {
            return $this->id_org;
        }
        public function getAnnee()
        {
            return $this->annee_univ;
        }
        public function getPresident()
        {
            return $this->id_president;
        }
        public function getExaminateur()
        {
            return $this->id_examinateur;
        }
        public function getRapporteurInt()
        {
            return $this->id_rapporteur_int;
        }
        public function getRapporteurExt()
        {
            return $this->id_rapporteur_ext;
        }
        public function getNote()
        {
            return $this->note;
        }
    }
?>