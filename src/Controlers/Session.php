<?php
namespace Csupcyber\Pemead\Controlers;

class Session
{
    public function __construct()
    {
        $this->domain = 'pemead.gouv.fr'; //variable a mettre dans un fichier ini
        $this->dateFormat = 'D, j M Y G:i:s';
    }

    public function set()
    {
        //activation strict mode
        ini_set('session.use_strict_mode', 1);
        //paramétrage de la durée de vie du cookie par defaut à 10 min
        ini_set('session.cookie_lifetime', 600);
        //durée de vie de la session forcer à 1h max
        ini_set('session.gc_maxlifetime', 3600);
        // probabilité de suppression des sessions expirées
        //(10% de chance de detruire les session expirées lors d'une requête utilisateur)
        ini_set('session.gc_probability', 10);
        // probabilité de suppression des sessions expirées
        //(10% de chance de detruire les session expirées lors d'une requête utilisateur)
        ini_set('session.gc_divisor', 100);
    }

    public function setSecurityHeaders()
    {
        //mise en place des en-tete de securité HTTP
        
        header_remove("X-Content-Type-Options");
        header_remove("Strict-Transport-Security");
        header_remove("X-Frame-Options");
        header_remove("Content-Security-Policy");
        header_remove("Referrer-Policy");
        header_remove("Cross-Origin-Opener-Policy");


        header("X-Content-Type-Options: nosniff");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
        header("X-Frame-Options: deny");
        $csp = "default-src 'self'; script-src 'self'; style-src 'self'; connect-src 'self'; frame-ancestor 'none'";
        header("Content-Security-Policy: ".$csp);
        header("Referrer-Policy: same-origin");
        header("Cross-Origin-Opener-Policy: same-origin");
    }

    public function destroyPHPDefaultCookie()
    {
        if (isset($_COOKIE['PHPSESSID'])) {
            //si existant suppression du cookie phpsessid
            setcookie("PHPSESSID", 'OLD', time()-600);
            unset($_COOKIE['PHPSESSID']);
        }
    }

    public function init()
    {
        //init variable session
        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
    }

    public function destroyOldSession()
    {
        //N'autorise pas l'utilisation des anciens ID de session : plus de 10 min sans activité
        if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 600) {
            foreach ($_SESSION as $key => $value) {
                //destruction des variable de session
                unset($_SESSION["$key"]);
            }
            //destruction de la session
            session_destroy();
            unset($_COOKIE['pemead']);
            //préparation du cookie
            $date = date($this->dateFormat, time()-600);
            $cookieDate = $date.' GMT';
            //invalidation de la session conté client
            setcookie("pemead", null, ['expires' => $cookieDate,
            'path' => '/',
            'domain' => $this->domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict']
            );
        }
    }
    
    public function setProjectCookie()
    {
        if (!isset($_COOKIE['pemead'])) {
            //verification et activation du système de session
            if (session_id() !== null){ // présence d'un identifiant de session
                foreach ($_SESSION as $key => $value) {
                //destruction des variable de session
                    unset($_SESSION["$key"]);
                }
                if (session_status() === 'PHP_SESSION_ACTIVE') {
                    //destruction de la session
                    session_destroy();
                }
            session_name('pemead');
            session_start();
            session_regenerate_id();
            $_SESSION['deleted_time'] = time(); //définit l'horodatage de suppression de la session
            unset($_COOKIE['pemead']);

            //préparation du cookie
            $date = date($this->dateFormat, time()+600);
            $cookieDate = $date.' GMT';

            //expiration du cookie de session (token)
            setcookie("pemead", session_id(), ['expires' => $cookieDate,
            'path' => '/',
            'domain' => $this->domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict']
            );
            }else {
            session_name('pemead');
            session_start();
            session_regenerate_id();
            //définit l'horodatage de suppression de la session
            $_SESSION['deleted_time'] = time();
            unset($_COOKIE['pemead']);
            //préparation du cookie
            $date = date($this->dateFormat, time()+600);
            $cookieDate = $date.' GMT';
            //expiration du cookie de session (token)
            setcookie("pemead", session_id(), ['expires' => $cookieDate,
            'path' => '/',
            'domain' => $this->domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict']
            );
            }
            
        } else {
            session_name('pemead');
            session_start();
            session_regenerate_id();
            //définit l'horodatage de suppression de la session
            $_SESSION['deleted_time'] = time();
            unset($_COOKIE['pemead']);
            //préparation du cookie
            $date = date($this->dateFormat, time()+600);
            $cookieDate = $date.' GMT';
            //prologation du token suite activité utilisateur
            setcookie("pemead", session_id(), ['expires' => $cookieDate,
            'path' => '/',
            'domain' => $this->domain,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict']
            );
        }
    }
    
    public function open()
    {
        $this->set();
        $this->destroyPHPDefaultCookie();
        $this->init();
        $this->destroyOldSession();
        $this->setProjectCookie();
        $this->setSecurityHeaders();
    }
}
