# FAQ Client — Réponses aux questions sur le devis

**Usage** : Préparer les réponses aux questions que Brice pourrait poser sur le devis et les choix techniques.

---

## 1. "Pourquoi l'OTP est par email et pas par SMS ?"

L'OTP par email est **gratuit, fiable et fonctionne partout** dans le monde (important pour ta clientèle internationale). Le SMS nécessite un prestataire payant (Twilio, ~0.05 €/SMS), un compte à vérifier, un numéro expéditeur à enregistrer auprès des autorités locales, et la livraison des SMS n'est pas toujours fiable selon les opérateurs.

L'email est déjà en place pour les notifications (bienvenue, confirmation RDV, relance). L'OTP passe par le même canal — aucun coût supplémentaire.

**Si tu veux le SMS plus tard**, c'est prévu en option (+500 €). Le code est conçu pour supporter les deux canaux.

---

## 2. "C'est quoi le SSR ? Pourquoi c'est important ?"

SSR = Server-Side Rendering (rendu côté serveur). Sans SSR, Google voit une page blanche quand il visite le site (le contenu est chargé en JavaScript après). Avec SSR, le serveur envoie la page déjà remplie — Google peut l'indexer correctement.

**Résultat concret** : tes biens apparaissent dans les résultats Google, les partages Facebook/WhatsApp affichent la bonne image et le bon titre, et le site charge plus vite pour les visiteurs.

---

## 3. "Pourquoi il faut Vimeo ? YouTube est gratuit"

YouTube est gratuit mais :
- Pas de contrôle sur la confidentialité — les vidéos sont indexées et suggérées par YouTube
- Publicités possibles sur les vidéos
- Pas de protection par domaine
- L'utilisateur est redirigé vers YouTube où il peut se perdre

Vimeo permet de garder le contrôle total : vidéo non indexée, pas de pub, player personnalisable aux couleurs du site. En version gratuite (unlisted), c'est déjà suffisant pour la V1. Si tu veux ajouter la protection par domaine plus tard, il suffit de passer en Vimeo Pro (~180 €/an) sans toucher au code.

---

## 4. "Les vidéos sont vraiment protégées ?"

Oui, à deux niveaux :
1. **Côté site** : l'URL de la vidéo complète n'existe pas dans le code de la page. Elle est servie uniquement par le serveur, et seulement aux utilisateurs connectés. Un visiteur non connecté ne voit que le teaser.
2. **Côté Vimeo** : la vidéo est en mode "unlisted" — elle n'apparaît nulle part sur Vimeo, pas de référencement, pas de suggestion.

Le seul scénario théorique : un utilisateur connecté ouvre l'inspecteur de son navigateur, trouve l'URL embed, et la partage. En pratique, personne ne fait ça pour une vidéo de visite immobilière. Et si ça devenait un problème, on peut activer la protection par domaine (Vimeo Pro) sans modifier le site.

---

## 5. "C'est quoi Calendly ? Ça coûte quelque chose ?"

Calendly est un outil de prise de rendez-vous en ligne — comme Doctolib mais gratuit. L'acheteur choisit un créneau disponible dans ton agenda, et les deux parties reçoivent une confirmation par email automatiquement.

**Coût : gratuit** (plan free). Il se synchronise avec ton agenda Google ou Outlook pour ne proposer que tes créneaux libres. Aucun développement spécifique — on l'intègre directement dans le site.

---

## 6. "Le tracking c'est quoi exactement ? C'est dans le devis ?"

Le tracking (nombre de vues par bien, durée de visionnage vidéo, clics sur les boutons) est géré par **Google Tag Manager + Google Analytics** — des outils gratuits de Google. Ce n'est pas du développement, c'est de la configuration. Ça peut être fait par toi ou un prestataire spécialisé.

**Ce qui est dans le devis** : tout ce qui touche aux données métier — qui a demandé une visite, qui a refusé et pourquoi, les notifications par email, la relance automatique après 48h. Ces données sont stockées dans la base de données du site et alimentent les rapports.

---

## 7. "Pourquoi le bilingue prend autant de temps ?"

Le bilingue touche **chaque page et chaque texte du site** : menus, boutons, messages d'erreur, formulaires, emails, back-office. Il faut :
- Configurer le système de traduction (middleware Laravel + vue-i18n côté frontend)
- Créer toutes les clés de traduction en français ET en anglais
- Gérer les contenus des biens en deux langues (table de traductions séparée en base de données)
- Tester chaque page dans les deux langues

Ce n'est pas compliqué techniquement, c'est **volumineux**.

---

## 8. "Pourquoi 2 vidéos par bien (teaser + complète) ?"

Le teaser (10-15 secondes) est **public** — visible par tous, même sans compte. C'est ce qui donne envie à l'acheteur de s'inscrire pour voir la suite.

La vidéo complète est **privée** — accessible uniquement après inscription. Son URL n'apparaît jamais dans le code source de la page tant que l'utilisateur n'est pas connecté.

Si on utilisait une seule vidéo en la coupant à 15 secondes côté code, l'URL complète serait quand même dans la page — un utilisateur technique pourrait contourner la limite.

**Pour toi** : ça veut dire uploader 2 vidéos sur Vimeo par bien et renseigner les 2 IDs dans le back-office. C'est un petit effort supplémentaire qui garantit la sécurité du système.

---

## 9. "Le reporting vendeur hebdomadaire, ça contient quoi exactement ?"

Un email envoyé automatiquement chaque lundi avec les données de la semaine :
- Nombre de contacts reçus (demandes d'info, demandes de rappel)
- Nombre de visites demandées (RDV Calendly)
- Intérêts confirmés
- Motifs de refus détaillés (Prix, Localisation, Surface, Agencement, Environnement, État général)

Les statistiques de fréquentation (nombre de vues, durée de visionnage) sont consultables directement dans Google Analytics — elles ne sont pas dans l'email pour éviter de dupliquer les outils.

*Note : le reporting vendeur a été retiré du devis vibecoding. Il peut être ajouté ultérieurement (+0.5j).*

---

## 10. "C'est quoi le back-office exactement ?"

C'est la partie "admin" du site, accessible uniquement par toi. Tu pourras :
- **Ajouter/modifier/supprimer des biens** : formulaire avec onglets FR/EN, upload photos, upload documents (plans, diagnostics), champs Vimeo pour les vidéos
- **Voir les utilisateurs** : qui s'est inscrit, leur activité
- **Gérer les leads** : voir les demandes de contact, demandes de visite, changer le statut (nouveau → contacté → qualifié → converti)
- **Consulter les statistiques** : nombre de biens, d'utilisateurs, de leads, activité récente

---

## 11. "Pourquoi o2switch et pas un autre hébergeur ?"

o2switch est un hébergeur français, mutualisé, à ~72 €/an tout compris (PHP, MySQL, SSL, emails, cPanel). C'est fiable, pas cher, et largement suffisant pour un site immobilier avec quelques dizaines de biens.

Si le site grossit beaucoup (trafic élevé, beaucoup de biens), on pourra migrer vers un VPS (Hetzner ~4 €/mois) pour avoir plus de contrôle. Mais pour la V1, o2switch est le bon choix rapport qualité/prix.

---

## 12. "Le site sera bien référencé sur Google ?"

Oui, le SEO est intégré dans le développement :
- **SSR** : les pages sont pré-rendues côté serveur pour que Google les indexe correctement
- **Meta tags dynamiques** : chaque page a son propre titre et sa description pour Google
- **Open Graph** : les partages Facebook/WhatsApp/LinkedIn affichent la bonne image et le bon titre
- **JSON-LD** : les biens sont structurés selon le format schema.org (RealEstateListing) pour les rich snippets Google
- **Sitemap XML** : Google connaît automatiquement toutes les pages du site
- **URLs propres** : `/acheter/villa-contemporaine-grand-baie-CAR-2026-001` au lieu de `/property?id=123`
- **Bilingue** : balises hreflang pour que Google serve la bonne langue selon le pays du visiteur

---

## 13. "Je peux modifier le contenu moi-même ?"

Oui, via le back-office :
- Les biens (textes FR/EN, photos, documents, vidéos, statut de publication)
- Les leads (statut, notes)

Les pages statiques (accueil, vendre, qui sommes-nous, contact) sont codées en dur — pour les modifier il faut intervenir dans le code. Si tu veux un CMS pour ces pages, c'est une évolution possible en V2.

---

## 14. "Comment garantissez-vous que l'URL de la vidéo complète ne peut pas être récupérée et partagée ?"

La protection repose sur deux niveaux :

**Niveau 1 — Côté serveur** : l'URL de la vidéo complète n'existe tout simplement pas dans le code source de la page. Elle n'est jamais chargée dans le HTML. Quand un utilisateur connecté accède à la vidéo, le navigateur fait une requête sécurisée au serveur qui vérifie que l'utilisateur est bien authentifié, puis retourne l'URL Vimeo de manière dynamique. Un visiteur non connecté ne voit que le teaser — il n'y a aucune trace de la vidéo complète dans la page.

**Niveau 2 — Côté Vimeo** : les vidéos complètes sont hébergées en mode "non listé" sur Vimeo. Elles n'apparaissent dans aucun moteur de recherche, aucune suggestion Vimeo, et ne sont pas indexées. Seul le site peut les afficher.

**En option** : si tu passes sur un plan Vimeo Pro (~180 €/an), on peut activer la **restriction par domaine** — la vidéo ne pourra être lue que depuis ton site (carrero.immo). Même si quelqu'un copie l'URL, elle ne fonctionnera pas ailleurs. Cette option est activable à tout moment sans modifier le code.

En pratique, le risque qu'un utilisateur inscrit aille extraire une URL depuis l'inspecteur du navigateur pour partager une visite immobilière est quasi nul. Mais les protections sont là si nécessaire.

---

## 15. "Comment gérez-vous le bilingue pour le SEO ? Les balises hreflang, les URLs ?"

Le bilingue est intégré dès la conception pour le référencement :

- **Balises hreflang** sur chaque page : elles indiquent à Google que la version FR et la version EN d'une même page existent. Google sert la bonne version selon la langue du visiteur.
- **Une seule URL par page** avec switch de langue par session (pas de préfixe /fr/ ou /en/ dans l'URL). C'est plus simple à maintenir et évite les problèmes de contenu dupliqué.
- **Contenu des biens traduit en base de données** : chaque bien a son titre, sa description et ses caractéristiques en FR et en EN, stockés séparément. Ce n'est pas de la traduction automatique — c'est toi qui renseignes les deux versions dans le back-office.
- **Meta tags dynamiques par langue** : le title, la description et les données Open Graph changent automatiquement selon la langue active.
- **Sitemap XML** : toutes les pages sont référencées avec leurs variantes linguistiques.

Google indexe correctement les deux versions et propose la bonne langue dans les résultats selon le pays du visiteur.

---

## 16. "Comment le code est-il documenté et testé ? Notamment les fonctions critiques comme la relance automatique ?"

Le code suit les conventions du framework Laravel, qui impose une structure claire et prévisible. Concrètement :

- **Architecture MVC** : chaque fonctionnalité a ses fichiers dédiés (contrôleurs, modèles, services). Un développeur Laravel peut reprendre le projet sans formation spécifique.
- **Nommage explicite** : les classes, méthodes et variables sont nommées de manière descriptive (ex: `SendVideoReminderNotifications`, `PostVideoActionController`). Le code se documente en grande partie par lui-même.
- **Tests fonctionnels** sur les parcours critiques : inscription → vérification email → accès vidéo → choix post-vidéo → notification admin. Ces tests vérifient que la chaîne complète fonctionne.
- **La relance 48h** est une commande planifiée qui tourne automatiquement chaque jour. Elle identifie les utilisateurs qui ont regardé une vidéo sans donner suite, et leur envoie un email de rappel. La commande est testée avec des cas limites : utilisateur qui a déjà répondu (pas de relance), utilisateur déjà relancé (pas de doublon), bien retiré de la vente (pas de relance).
- **Documentation technique** livrée avec le projet : schéma de base de données, architecture des fichiers, guide de déploiement.

---

## 17. "Le choix de l'utilisateur après la vidéo est-il enregistré dans le back-office ? Je peux analyser pourquoi un bien ne plaît pas ?"

Oui, c'est une des fonctionnalités clés du site. Chaque réponse post-vidéo est enregistrée en base de données avec le détail complet :

**Option "Je souhaite visiter"** → tu vois dans le back-office : qui a demandé la visite, pour quel bien, la date du RDV Calendly.

**Option "J'ai besoin d'infos"** → tu vois : qui a demandé, son message ou sa demande de rappel, son mode de contact préféré (téléphone, email ou WhatsApp).

**Option "Je ne donne pas suite"** → tu vois : qui a refusé, les **motifs détaillés** cochés (Prix, Localisation, Surface, Agencement, Environnement, État général), et le commentaire libre optionnel.

C'est cette dernière option qui est la plus précieuse pour toi. Si 8 personnes sur 10 refusent un bien pour le prix, tu as une donnée concrète à présenter au vendeur. Si c'est la localisation qui revient, c'est un autre type de discussion.

Dans le back-office, tu peux filtrer par bien et par période pour voir l'ensemble des interactions. Ces données alimentent aussi les notifications que tu reçois en temps réel par email à chaque interaction.
