/ REQUETE 3 A (Maison)
// L objectif de cette requête SQL est d analyser les ventes d appartements et de maison en les regroupant par nombre de pièces principales et par région pour la période entre le 1er janvier et le 30 juin 2020.

SELECT 
        Type_Local AS 'Type de bien',
        Nbre_Piece_prin AS 'Nb de pièces',
        CONCAT(
            FORMAT(
                COUNT(Type_Local) * 100 / 
                (SELECT COUNT(Type_Local) FROM bien WHERE LOWER(Type_Local) = 'maison'),
                4
            ),
            '%'
        ) AS '% du total des ventes',
        region.Nom_region AS 'Région' -- Ajout de la colonne région
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    JOIN commune ON bien.Code_Commune = commune.Code_Commune -- Jointure avec la table commune
    JOIN departement ON commune.depart_ID = departement.depart_ID -- Jointure avec la table departement
    JOIN region ON departement.region_ID = region.region_ID -- Jointure avec la table région
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'maison'
    GROUP BY Type_Local, Nbre_Piece_prin, region.Nom_region
    ORDER BY Nbre_Piece_prin ASC
	

// REQUETE 3 B (appartement)

SELECT 
        Type_Local AS 'Type de bien',
        Nbre_Piece_prin AS 'Nb de pièces',
        CONCAT(
            FORMAT(
                COUNT(Type_Local) * 100 / 
                (SELECT COUNT(Type_Local) FROM bien WHERE LOWER(Type_Local) = 'appartement'),
                4
            ),
            '%'
        ) AS '% du total des ventes',
        region.Nom_region AS 'Région' -- Ajout de la colonne région
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    JOIN commune ON bien.Code_Commune = commune.Code_Commune -- Jointure avec la table commune
    JOIN departement ON commune.depart_ID = departement.depart_ID -- Jointure avec la table departement
    JOIN region ON departement.region_ID = region.region_ID -- Jointure avec la table région
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'appartement'
    GROUP BY Type_Local, Nbre_Piece_prin, region.Nom_region
    ORDER BY Nbre_Piece_prin ASC
	