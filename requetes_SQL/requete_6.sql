/ Requete 6

// Afficher le prix moyens pour les appartements de plus de 4 pièces par région

WITH moyenne AS (
    SELECT region.region_ID AS 'Région', 
           region.Nom_region AS 'NomRégion', 
           AVG(vente.prix / bien.Surface_Bati) AS 'AvgPpxM2Apparts4p'
    FROM vente
    LEFT JOIN bien ON vente.ID_bien = bien.ID_bien
    LEFT JOIN commune ON bien.Code_Commune = commune.Code_Commune
    LEFT JOIN departement ON commune.depart_ID = departement.depart_ID
    LEFT JOIN region ON departement.region_ID = region.region_ID
    WHERE (vente.date_vente >= '2020-01-01') 
          AND (vente.date_vente <= '2020-06-30') 
          AND lower(bien.Type_Local) = 'appartement'  
          AND bien.Nbre_Piece_prin > 4
    GROUP BY region.region_ID, region.Nom_region
)
SELECT Région, 
       NomRégion AS 'Nom Région', 
       CONCAT(FORMAT(AvgPpxM2Apparts4p, 2), ' EUR/m2') AS 'Prix moyen appartements > 4 pièces'
FROM moyenne
ORDER BY AvgPpxM2Apparts4p DESC;



