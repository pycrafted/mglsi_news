# MGLSI News - Plateforme de Gestion de Contenu

Ce projet est une plateforme de gestion de contenu (CMS) moderne développée en PHP suivant l'architecture MVC. Il permet la publication et la gestion d'articles de presse en ligne.

## 🚀 Fonctionnalités

### Interface Publique
- Page d'accueil avec articles en vedette
- Articles classés par catégories
- Navigation intuitive
- Design responsive
- Système de pagination
- Barre latérale avec publicités

### Espace Administration
- Tableau de bord personnalisé
- Gestion complète des articles (CRUD)
- Interface d'édition intuitive
- Gestion des catégories
- Upload d'images
- Authentification sécurisée

## 🛠️ Technologies Utilisées

- PHP 7.4+
- MySQL
- HTML5/CSS3
- JavaScript
- Architecture MVC
- Composer pour la gestion des dépendances

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache recommandé)
- Composer
- XAMPP (recommandé pour le développement)

## 🚀 Installation

1. **Cloner le repository**
   ```bash
   git clone https://github.com/pycrafted/mglsi_news.git
   cd mglsi_news
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   - Créer une base de données MySQL nommée `mglsi_news`
   - Importer le fichier `config/database.sql`
   - Copier `config/db_connect.example.php` vers `config/db_connect.php`
   - Modifier les paramètres de connexion dans `config/db_connect.php`

4. **Configurer le serveur web**
   - Placer le projet dans le répertoire `htdocs` de XAMPP
   - Configurer le VirtualHost si nécessaire

5. **Créer un utilisateur test**
   - Accéder à `admin/create_test_user.php` pour créer un compte administrateur

## 📁 Structure du Projet

```
mglsi_news/
├── app/
│   ├── Controllers/    # Contrôleurs de l'application
│   ├── Models/         # Modèles de données
│   ├── Views/          # Vues et templates
│   ├── Core/           # Classes de base
│   ├── Helpers/        # Classes utilitaires
│   ├── Middleware/     # Middleware d'authentification
│   └── Services/       # Services métier
├── config/             # Fichiers de configuration
├── css/               # Styles CSS
├── images/            # Images et médias
├── vendor/            # Dépendances Composer
└── public/            # Point d'entrée public
```

## 🔒 Sécurité

- Protection contre les injections SQL
- Validation des données
- Gestion sécurisée des sessions
- Protection CSRF
- Validation des fichiers uploadés

## 👥 Contribution

1. Fork le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Auteur

* **MGLSI Team**
  * Email: abdoulayelah@esp.sn
  * Étudiant en Génie logicielle et système d'information à l'ESP
  * Formation MGLSI

## 🙏 Remerciements

- ESP (École Supérieure Polytechnique)
- Formation MGLSI
- Tous les contributeurs du projet

