# MGLSI News - Plateforme de Gestion de Contenu

MGLSI News est une plateforme de gestion de contenu (CMS) moderne permettant la publication et la gestion d'articles de presse en ligne.

## 🚀 Fonctionnalités

- **Interface Publique**
  - Page d'accueil avec articles en vedette
  - Articles classés par catégories
  - Navigation intuitive
  - Design responsive
  - Système de pagination

- **Espace Journaliste**
  - Tableau de bord personnalisé
  - Gestion des articles (CRUD)
  - Interface d'édition intuitive
  - Gestion des catégories
  - Upload d'images

- **Sécurité**
  - Authentification sécurisée
  - Protection contre les injections SQL
  - Validation des données
  - Gestion des sessions

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache recommandé)
- XAMPP (recommandé pour le développement)

## 🛠️ Installation

1. **Cloner le repository**
   ```bash
   git clone [URL_DU_REPO]
   cd mglsi_news
   ```

2. **Configurer la base de données**
   - Créer une base de données MySQL nommée `mglsi_news`
   - Importer le fichier `config/database.sql`

3. **Configurer la connexion**
   - Ouvrir `config/db_connect.php`
   - Modifier les paramètres de connexion selon votre configuration :
     ```php
     $host = 'localhost';
     $dbname = 'mglsi_news';
     $username = 'root';  // Votre nom d'utilisateur MySQL
     $password = '';      // Votre mot de passe MySQL
     ```

4. **Déplacer les fichiers**
   - Copier tous les fichiers dans le répertoire `htdocs` de XAMPP
   - Le chemin final devrait être : `C:\xampp\htdocs\mglsi_news`

5. **Démarrer les services**
   - Lancer XAMPP Control Panel
   - Démarrer Apache et MySQL

6. **Accéder au site**
   - Ouvrir votre navigateur
   - Accéder à : `http://localhost/mglsi_news`

## 📁 Structure du Projet

```
mglsi_news/
├── admin/              # Interface d'administration
│   ├── dashboard.php   # Tableau de bord
│   ├── add_article.php # Ajout d'articles
│   └── edit_article.php# Modification d'articles
├── config/             # Configuration
│   ├── db_connect.php  # Connexion à la base de données
│   └── database.sql    # Structure de la base de données
├── css/               # Styles CSS
├── images/            # Images et médias
├── includes/          # Composants réutilisables
├── utils/             # Fonctions utilitaires
├── index.php          # Page d'accueil
├── article.php        # Affichage d'un article
├── login.php          # Page de connexion
└── README.md          # Documentation
```

## 👥 Rôles Utilisateurs

- **Journaliste**
  - Création et modification d'articles
  - Gestion de son contenu
  - Accès au tableau de bord

- **Administrateur**
  - Toutes les fonctionnalités du journaliste
  - Gestion des utilisateurs
  - Gestion des catégories
  - Accès aux statistiques

## 🔒 Sécurité

- Protection contre les injections SQL via PDO
- Validation des entrées utilisateur
- Échappement des données HTML
- Gestion sécurisée des sessions
- Protection des routes sensibles

## 🎨 Personnalisation

Le site peut être personnalisé en modifiant :
- Les fichiers CSS dans le dossier `css/`
- Les templates dans le dossier `includes/`
- Les paramètres de configuration dans `config/`

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Auteur

- **MGLSI Team**
  - Email: [VOTRE_EMAIL]
  - Site Web: [VOTRE_SITE]

## 🙏 Remerciements

- XAMPP pour l'environnement de développement
- Font Awesome pour les icônes
- Tous les contributeurs du projet 