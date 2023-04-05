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
        if (isset($_GET['success'])
        && ($_GET['success'] === "registred")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Enregistré!!</strong> Votre compte utilisateur a été créé,
                il sera actif après la validation d'un administrateur.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        if (isset($_GET['success'])
        && ($_GET['success'] === "firstRegistred")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Enregistré!!</strong> Votre compte utilisateur a été créé!
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <strong>Oncle Ben:</strong> Un grand pouvoir implique de grande responsabilités,
                en tant que premier utilisateur vous êtes l'administrateur de ce portail!
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        if (isset($_GET['success'])
        && ($_GET['success'] === "logedIn")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Vous revoilà!!</strong> Vous êtes connecté, au travail! &#x1F609;.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        if (isset($_GET['success'])
        && ($_GET['success'] === "passwordChanged")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Mot de passe modifié !!</strong> Merci de contribuer à la sécurité de la plateforme &#x1F609;.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        if (isset($_GET['success'])
        && ($_GET['success'] === "done")) {?>
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>OK !! </strong> Action réalisée &#x1F609;.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
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
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
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
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le mail saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "mailAlreadyUsed")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> L'adresse e-mail <?php echo $_GET['mail'];?> est déjà utilisée.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le mail saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "courseAlreadyUsed")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Le nom de cours <?php echo $_GET['course'];?> est déjà utilisée.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        //erreur de connexion à la bdd
        if (isset($_GET['error'])
        && ($_GET['error'] === "dbConnect")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Connexion à la base de donnée impossible, veuillez contacter un administrateur.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        //erreur lors de la préparaion d'une requête
        if (isset($_GET['error'])
        && ($_GET['error'] === "dbPrepare")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> erreur dans une requête préparée, veuillez contacter votre administrateur.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: le matricule saisi lors de l'enregistrement est déjà présent dans la base de données
        if (isset($_GET['error'])
        && ($_GET['error'] === "matriculeAlreadyUsed")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Le matricule <?php echo $_GET['matricule'];?> est déjà utilisée.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
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
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur: Authetification rejetée
        if (isset($_GET['error'])
        && ($_GET['error'] === "RejectedAuth")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> L'association adresse e-mail et mot de passe saisie n'est pas valide.
               <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
             </div>
        <?php
        }

        // erreur: Utilisateur en attente de validation
        if (isset($_GET['error'])
        && ($_GET['error'] === "unvalidatedUser")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Votre compte utilisateur est en attente de validation,
                veuillez contacter un administrateur ou rééssayer plus tard.
               <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
             </div>
        <?php
        }

        // erreur dans le format de l'adresse mail dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "nok")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Oups!</strong> L'action n'a pas été éfectuée...
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur dans le format de l'adresse mail dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "DBNOK")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Oups!</strong> L'action n'a pas été éfectuée...
                erreur lors de l'insertion dans la base de donnée.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "noCourse")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Veuillez selectionner un cours à piloter.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "noGroupement")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Veuillez selectionner votre groupement d'instruction.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "noPromotion")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Veuillez selectionner votre promotion.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur dans le formulaire d'enregistrement
        if (isset($_GET['error'])
        && ($_GET['error'] === "uploadError")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> <?php echo  $_SESSION['ERROR']; ?>
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }

        // erreur lors de la suppression de fichier
        if (isset($_GET['error'])
        && ($_GET['error'] === "busyFile")) {?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Erreur!</strong> Le fichier que vous essayez de supprimer est attaché à un ou plusieurs
                cours / matières en tant que document et ne peut être supprimé.
                <button type="submit"  class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php
        }
    
    }

    
}