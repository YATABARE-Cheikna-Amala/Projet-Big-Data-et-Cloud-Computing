// Requete 7

// Comparaison prix moyen appartements 3 pièces et 2 pièces

WITH Moy2pieces AS (
    SELECT AVG(prix / Surface_Bati) AS Apparts2Pieces
    FROM vente
    JOIN bien USING (ID_bien)
    WHERE (date_vente >= '2020-01-01') 
      AND (date_vente <= '2020-06-30') 
      AND LOWER(Type_Local) = 'appartement'  
      AND Nbre_Piece_prin = '2'
),
Moy3pieces AS (
    SELECT AVG(prix / Surface_Bati) AS Apparts3Pieces
    FROM vente
    JOIN bien USING (ID_bien)
    WHERE (date_vente >= '2020-01-01') 
      AND (date_vente <= '2020-06-30') 
      AND LOWER(Type_Local) = 'appartement'  
      AND Nbre_Piece_prin = '3'
)
SELECT 
    CONCAT(FORMAT(Apparts2Pieces, 2), ' EUR/m2') AS 'Prix moyen appartements 2 pièces', 
    CONCAT(FORMAT(Apparts3Pieces, 2), ' EUR/m2') AS 'Prix moyen appartements 3 pièces', 
    CONCAT(FORMAT((Apparts3Pieces - Apparts2Pieces) * 100 / Apparts2Pieces, 2), '%') AS 'Ecart' 
FROM 
    Moy2pieces
JOIN 
    Moy3pieces;
	
