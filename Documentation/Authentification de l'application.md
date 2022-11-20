# Authentification de l'application
La sécurité concernant l'authentification est configuré dans le fichier `config/packages/security.yaml`
Vous trouverez plus d'informations concernant ce fichier et ses différentes parties dans la [documentation officielle de Symfony](https://symfony.com/doc/4.2/security.html).

## L'entité User
Avant toute de chose, il est nécessaire d'avoir défini une entité qui représentera l'utilisateur connecté. 
Cette classe doit implémenter l'interface `UserInterface` et donc implémenter les différentes méthodes définis dans celle-ci.
Dans notre cas, cette classe a déjà été implémentée et se situe dans la fichier `src/Entity/User.php`.

## Les Providers
Un provider va nous permettre d'indiquer où se situe les informations que l'on souhaite utiliser pour authentifier l'utilisateur, dans ce cas-ci, on indique qu'on récupérera les utilisateurs via Doctrine grâce à l'entité User dont la propriété username sera utilisé pour s'authentifier sur le site.
Attention, on peut indiquer ici la classe User car celle-ci implémente l'interface `UserInterface` !
```yaml
# config/packages/security.yaml
security:
# ...
	providers:
		app_user_provider:
			entity:
				class: App\Entity\User
				property: username
```

## Le SecurityBundle
Nombreuses sont les application nécessitant un mot-de-passe pour identifier l'utilisateur. Le ``SecurityBundle`` fournit les fonctionnalités de hachage et vérification du mot-de-passe. La section ``password_hashers`` va simplement nous permettre de déterminer quel est l'algorithme que l'on souhaite utiliser lors du hachage du mot-de-passe. Dans le cas ici, on laissera Symfony décider de manière native de l'algorithme à utiliser. Par défaut, l'algorithme utilisé par Symfony est `bcrypt`.
```yaml
# config/packages/security.yaml
security:
# ...
	password_hashers:
		Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
```
Pour la vérification du mot-de-passe l'entité ``User`` a besoin d'implémenter ``PasswordAuthenticatedUserInterface``.
```php
// src/Entity/User.php
// ...
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // ...
}
```

## Les Firewalls
La section ``firewalls`` de ``config/packages/security.yaml`` est la section la plus importante. Un « pare-feu » est votre système d'authentification : le pare-feu définit quelles parties de votre application sont sécurisées et comment vos utilisateurs pourront s'authentifier
Le firewall `dev` ne concerne que le développement: c'est un faux pare-feu. Il s'assure que vous ne bloquez pas accidentellement les outils de développement de Symfony comme le ``Web Debug Toolbar`` et le ``Profiler``
Le firewall `main` englobe l'entièreté du site à partir de la racine défini via `pattern: ^/`, l'accès y est autorisé en anonyme c'est-à-dire sans être authentifié.
Afin de s'authentifier, on définit un formulaire de connexion via `form_login:` où sont indiqués le nom des routes correspondant à ce formulaire, la route de vérification du login ainsi que la route vers laquelle l'utilisateur devra être redirigé par défaut après son authentification.
```yaml
# config/packages/security.yaml
security:
# ...
	firewalls:
		dev:
			pattern: ^/(_(profiler|wdt)|css|images|js)/
			security: false
		main:
			lazy: true
			provider: app_user_provider
			pattern: ^/
			form_login:
				login_path: login
				check_path: login_check
				always_use_default_target_path:  true
				default_target_path:  /
			logout: ~
```

## Le Access Control
La section ``access_control`` va définir les limitations d'accès à certaines parties du site.
Dans ce cas-ci, on indique que :
- L'url ``/tasks`` et les urls enfants n'est accessible qu'en étant authentifié avec un utilisateur ayant le rôle "ROLE_USER".
- L'url ``/users`` et les urls enfants n'est accessible qu'en étant authentifié avec un utilisateur ayant le rôle "ROLE_ADMIN".
- Tout le reste du site est accessible sans authentification.
```yaml
# config/packages/security.yaml
security:
# ...
	access_control:
		- { path: ^/tasks, roles: ROLE_USER }
		- { path: ^/users, roles: ROLE_ADMIN }
```

## L'hiérarchie des rôles
La section ``role_hierarchy`` permet de s'assurer qu'un utilisateur ayant un certain rôle aura automatiquement d'autres rôles.
Dans ce cas-ci, un utilisateur possédant le rôle "ROLE_ADMIN" aura automatiquement le rôle "ROLE_USER".
```yaml
# config/packages/security.yaml
security:
# ...
	role_hierarchy:
	    ROLE_ADMIN: ROLE_USER
```