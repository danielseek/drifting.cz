<?php
namespace Natty\Security;
/**
 * Description of Authentificator
 *
 * @author Daniel Sykora (jsem@dsykora.cz)
 */
use Nette;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;

class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{
    /** @var Nette\Database\Connection */
    private $database;

    /**
     * @param Nette\Database\Connection
     */
    public function __construct(Nette\Database\Connection $database)
    {
        $this->database = $database;
    }


    /**
     * Performe authentication
     * @param array
     * @return Nette\Security\Identity
     */
    public function authenticate(array $credentials)
    {
        list($login, $password) = $credentials;
	    
            $row = $this->database->table('users')->where('login', $login)->fetch();

        if (!$row) {
            throw new AuthenticationException('The login is incorrect.', self::IDENTITY_NOT_FOUND);
        }

        if ($row->password !== sha1($password)) {
            throw new AuthenticationException('Wrong password', self::INVALID_CREDENTIAL);
        }

        unset($row->password);
        return new Identity($row->id, $row->role, $row->toArray());
    }

}

?>
