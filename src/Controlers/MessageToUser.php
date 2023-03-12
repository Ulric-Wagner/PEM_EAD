<?php
namespace Csupcyber\Pemead\Controlers;

class MessageToUser
{
    public function __construct()
    {
        //wait
    }

    public function success()
    {
        if(isset($_GET['success'])
        && ($_GET['success'] === "registred")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Enregistré!!</strong> Votre compte utilisateur a été créé,
                il sera actif après la validation d'un administrateur.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        if(isset($_GET['success'])
        && ($_GET['success'] === "logedIn")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Vous revoilà!!</strong> Vous êtes connecté, au travail! &#x1F609;.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }
    }

    public function warning()
    {
        if(isset($_GET['warning'])
        && ($_GET['warning'] === "disconnected")) {?>
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <strong>À bientôt!!</strong> Vous êtes déconnecté, bon repos! &#x1F44D;.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }
    }

    public function error()
    {
        // erreur dans le format de l'adresse mail dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "mailFormat")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Veuillez verifier le format de votre adresse e-mail.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le mail saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "mailAlreadyUsed")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> L'adresse e-mail <?php echo $_GET['mail'];?> est déjà utilisée.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        //erreur de connexion à la bdd
        if (isset($_GET['error'])
        && ($_GET['error'] === "dbConnect")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Connexion à la base de donnée impossible, veuillez contacter un administrateur.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        //erreur lors de la préparaion d'une requête
        if (isset($_GET['error'])
        && ($_GET['error'] === "dbPrepare")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> erreur dans une requête préparée, veuillez contacter votre administrateur.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le matricule saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "matriculeAlreadyUsed")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Le matricule <?php echo $_GET['matricule'];?> est déjà utilisée.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le matricule saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "passwordComplexity")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Le mot de passe ne respecte pas les critères de complexité suivants: <br/>
                - Au moins une lettre minuscule. <br/>
                - Au moins une lettre majuscule. <br/>
                - Au moins un chiffre. <br/>
                - Au moins un caractère spécial. <br/>
                - Au moins 8 caractères.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: Authetification rejetée
        if (isset($_GET['error'])
        && ($_GET['error'] === "RejectedAuth")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> L'association adresse e-mail et mot de passe saisie n'est pas valide.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
             </div>
        <?php
        }

        // erreur: Utilisateur en attente de validation
        if (isset($_GET['error'])
        && ($_GET['error'] === "unvalidatedUser")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Votre compte utilisateur est en attente de validation,
                veuillez contacter un administrateur ou rééssayer plus tard.
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
             </div>
        <?php
        }
    
    }

    
}