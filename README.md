**Generateur d'image**

- Description : 

    Développer un programme permettant de concaténer toutes les images en une seule image, ensuite nous devons faire en sorte que cette image soit visible par css, en lançant le programme dans un terminal.

- Fonctionnalité :

    - Pour exécuter le programme correctement vous devez écrire dans le terminal :
        - php css_generator.php [-r]* ([-i] [string])* ([-s] [string])* ([-p] [int])* [./nom_du_dossier/]

        (*option facultative pour éxecuter le programme)
        - [-r] ou [--recursive] : récupère les images dans chaque sous-dossier
        - [-i] ou [--output-image]: donne un nom à votre image (sans préciser le format).
        - [-s] ou [--output-style]: donne un nom à votre fichier css (sans préciser également le format).
        - [-p] ou [--padding]: donne une marge en pixels entre chaque image dans le sens de la longueur.

- Etape du projet :

    - Création d'une fonction qui crée une image au format ".png" qui contient la fusion de deux image donner en paramètre et l'affiche sur un serveur local pour la vérification.
    
    - Création d'une fonction qui crée un fichier au format ".css" qui contient le lien de l'image fusionner dans la première étape.

    - Création d'une fonction récursive qui récupère chaque image dans tout les sous dossier du dossier passer en paramètre.

    - Création d'une fonction principale qui associe chaque options du terminal avec les autres fonction.

    - Modifier les fonctions pour qu'elle permettent de fusionner chaque image donner dans le paramètre grâce à un tableau.

    - Permettre de donner les images à fusionner depuis un terminal.

- Les restrictions :

    - La fonction scandir de PHP ne doit pas être utiliser.
    
    - Les classes itératrices de PHP telle que RecursiveDirectoryIterator ne doivent pas être utiliser également.

- Nécessité pour la réalisation du projet :

    - Utiliser la librairie GD
    - Utiliser le terminal

- Liste des technologies utiliser :

    - Visual studio code

- Droit d'auteurs et information de licence :

    Epitech {E} Web@cademie
