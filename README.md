# MGLSI News - Plateforme de Gestion de Contenu

Ce projet a été développé dans le cadre du cours d'Architecture Logicielle de la formation MGLSI. Il s'agit d'une plateforme de gestion de contenu (CMS) moderne permettant la publication et la gestion d'articles de presse en ligne.

## 🎓 Contexte du Projet

Ce projet a été réalisé dans le but de mettre en pratique les concepts d'architecture logicielle appris en cours, notamment :
- Les principes SOLID
- Les patterns de conception
- L'architecture MVC
- La séparation des responsabilités
- La gestion des dépendances

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
   git clone [[URL_DU_REPO]](https://github.com/pycrafted/mglsi_news/)
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

## 👨‍💻 Auteur

- **MGLSI Team**
  - Email: abdoulayelah@esp.sn
  - Étudiant en Génie logicielle et système d'information à l'ESP
  - Formation MGLSI

