// REQUETE 2 A (maison)
// L objectif de cette requête SQL est d analyser les ventes de maisons vendues et d appartement entre le 1er janvier et le 30 juin 2020, en mettant en évidence la distribution des ventes par nombre de pièces principales.

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
        ) AS '% du total des ventes'
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'maison'
    GROUP BY Type_Local, Nbre_Piece_prin
    ORDER BY Nbre_Piece_prin ASC
	
// REQUETE 2 B (appartement)

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
        ) AS '% du total des ventes'
    FROM
        bien
    JOIN vente ON bien.ID_bien = vente.ID_bien
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'maison'
    GROUP BY Type_Local, Nbre_Piece_prin
    ORDER BY Nbre_Piece_prin ASC
	