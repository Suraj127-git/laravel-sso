<?php
namespace App\Repository;

interface SsoAuthRepository {
    public function getSsoAuthenticate($provider);
    public function setSsoAuthenticate($provider);
}

?>