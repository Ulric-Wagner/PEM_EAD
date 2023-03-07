<?php
namespace Csupcyber\Pemead\Controlers;

class IOCleaner
{
    public function __construct()
    {
        $this->esper = "&amp;";
        $this->dquote = "&quot;";
        $this->quote = "&#039;";
        $this->lt = "&lt;";
        $this->gt = "&lt;";
    }

    public function arrayFilterSQL($input) {
        //fonction utilisé par la fonction SQLFilter()
        $dangerous = array(";--", ";#", "'--", "/*", "*/", "/*!", ";", "1=1", "'true'", "'false'", "CHAR(", "0x",
        "ASCII(", "Hex", "' or", "') or", "' HAVING", "' GROUP BY", "ORDER BY", "ad_ext_etr", "dasa_users",
        "journal", "osd_cssi", "osd_events", "osd_shem");
        
        if (!is_array($input) && is_string($input)) {
            //si pas d'array et string value
            $input = str_replace($dangerous, "", $input);
        }elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                //pour les sous array reboucle la fonction jusqu'a la valeur finale
                $input["$key"] = $this->arrayFilterSQL($value);
            }
        }
        return $input; //renvoie la nouvelle valeur de l'input
    }

    public function sqliFilter()
    {
        //protection SQLi
        //suppression des caractères dangereux dans les variable post, get, session et cookie.
        $_POST = $this->arrayFilterSQL($_POST);
        $_GET = $this->arrayFilterSQL($_GET);
        $_SESSION = $this->arrayFilterSQL($_SESSION);
        $_COOKIE = $this->arrayFilterSQL($_COOKIE);
        $_FILES = $this->arrayFilterSQL($_FILES);
        $_SERVER = $this->arrayFilterSQL($_SERVER);
    }

    public function arrayFilterXSS($input)
    {
        //fontion utilisée par XSSFilter()
        if (!is_array($input) && is_string($input))
        {
            // si pas d'array et string value
            $input = str_replace($this->esper, "&", $input);
            $input = str_replace($this->dquote, '"', $input);
            $input = str_replace($this->quote, "'", $input);
            $input = str_replace($this->lt, "<", $input);
            $input = str_replace($this->gt, ">", $input);
            $input = htmlspecialchars($input, ENT_QUOTES);
        }elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                //pour les sous array reboucle la fonction jusqu'a la valeur finale
                $input["$key"] = $this->arrayFilterXSS($value);
            }
        }
        
        return $input; //renvoie la nouvelle valeur de l'input
    }

    public function xssFilter()
    {
        //protection XSS
        //suppression des caractères dangereux dans les variable post, get, session et cookie.
        //en raison du filtrage effectué sur les variable en entrée de la base de donnée il est
        //nécésaire d'effectuer une vérification de la présence d'entité HTML avant d'effectuer un htmlspecialchars
        //car la double application du htmlspecialchars ne permet pas un affichage correct au client
        
        
        $_POST = $this->arrayFilterXSS($_POST);
        $_GET = $this->arrayFilterXSS($_GET);
        $_SESSION = $this->arrayFilterXSS($_SESSION);
        $_COOKIE = $this->arrayFilterXSS($_COOKIE);
        $_FILES = $this->arrayFilterXSS($_FILES);
        $_SERVER = $this->arrayFilterXSS($_SERVER);
    }

    public function arrayFilterInput($input)
    {
        $dangerous = array(";--", ";#", "'--", "/*", "*/", "/*!", ";", "1=1", "'true'", "'false'",
        "CHAR(", "0x", "ASCII(", "Hex", "' or", "') or", "' HAVING", "' GROUP BY", "ORDER BY", "ad_ext_etr",
        "dasa_users", "journal", "osd_cssi", "osd_events", "osd_shem");
        
        if (!is_array($input) && is_string($input))
        {
            //si pas d'array et string value
            //filtrage SQLi
            $input = str_replace($dangerous, "", $input);
            //filtrage XSS
            //en raison du filtrage effectué sur les variable en entrée de la base de donnée il est nécésaire
            //d'effectuer une vérification de la présence d'entité HTML avant d'effectuer un htmlspecialchars
            //car la double application du htmlspecialchars ne permet pas un affichage correct au client
            $input = str_replace($this->esper, "&", $input);
            $input = str_replace($this->dquote, '"', $input);
            $input = str_replace($this->quote, "'", $input);
            $input = str_replace($this->lt, "<", $input);
            $input = str_replace($this->gt, ">", $input);
            $input = htmlspecialchars($input, ENT_QUOTES);
        }elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                //pour les sous array reboucle la fonction jusqu'a la valeur finale
                $input["$key"] = $this->arrayFilterInput($value);
            }
        }
            
        return $input; //renvoie la nouvelle valeur de l'input
    }

    public function inputFilter($input)
    {
        //filtrage des données avant insertion en BDD
        return $this->arrayFilterInput($input);
    }
    
    public function arrayFilterOutput($input)
    {
        //fonction utilisée par OutputFilter()
        if (!is_array($input) && is_string($input)){
            //si pas d'array et string value
            //filtrage XSS
            //en raison du filtrage effectué sur les variable en entrée
            //de la base de donnée
            //il est nécésaire d'effectuer une vérification de la présence
            //d'entité HTML avant d'effectuer un htmlspecialchars
            //car la double application du htmlspecialchars ne permet pas
            //un affichage correct au client
            $input = str_replace($this->esper, "&", $input);
            $input = str_replace($this->dquote, '"', $input);
            $input = str_replace($this->quote, "'", $input);
            $input = str_replace($this->lt, "<", $input);
            $input = str_replace($this->gt, ">", $input);
            $input = htmlspecialchars($input, ENT_QUOTES);
        }elseif (is_array($input)) {
            foreach ($input as $key => $value) {
                //pour les sous array reboucle la fonction jusqu'a la valeur finale
                $input["$key"] = $this->arrayFilterOutput($value);
            }
        }
            
            return $input; //renvoie la nouvelle valeur de l'input
    
    }

    public function outputFilter($output)
    {
        //filtrage des strings avant affichage utilisateur (echo ect.)
        return $this->arrayFilterOutput($output);
    }
    
}
















