<?PHP
namespace config;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\DBAL\Connection;

class UserProvider implements UserProviderInterface
{
    public function __construct()
    {
    }

    public function loadUserByUsername($username)
    {
        return new User('sebastien', 'V9jRIa30r+tEcRJ/uKekHD3pGgNqtXRwLp6SHm/Ss14xyRTIqUN+wvy/26OctE3XpQq754DcIzmOKFu4HVaASA==', explode(',', 'ROLE_USER'), true, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }
}