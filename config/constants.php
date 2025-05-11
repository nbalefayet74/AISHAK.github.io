<?php
/**
 *  config/constants.php
 *  -------------------------------------------------------------
 *  Constantes métiers et valeurs "enum-like".
 *  Utilisables partout après un simple require_once.
 *  -------------------------------------------------------------
 */

declare(strict_types=1);

/*---------------------- Rôles d’utilisateur ----------------------*/
const ROLE_USER   = 10;
const ROLE_EDITOR = 20;
const ROLE_ADMIN  = 30;

/*---------------------- Statuts d’une course --------------------*/
const RIDE_PENDING   = 'pending';
const RIDE_ACCEPTED  = 'accepted';
const RIDE_STARTED   = 'started';
const RIDE_COMPLETED = 'completed';
const RIDE_CANCELED  = 'canceled';

/*---------------------- Divers ----------------------*/
const MAX_UPLOAD_SIZE_MB = 10;      // Limite d’upload côté appli
