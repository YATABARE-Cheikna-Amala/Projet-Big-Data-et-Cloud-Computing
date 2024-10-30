// Requete 8


// Afficher les informations sur les communes ayant un nombre de ventes supérieur à 50

SELECT 
    commune.Code_Commune AS 'Commune',
    commune.Nom_Com AS 'Nom commune',
    COUNT(vente.ID_vente) AS 'Nb de ventes',
    CONCAT(' Du ', MIN(date_vente), ' au ', MAX(date_vente)) AS 'Période'
FROM
    vente
        LEFT JOIN bien USING (ID_bien)
        LEFT JOIN commune USING (Code_Commune)
        LEFT JOIN departement USING (depart_ID)
        LEFT JOIN region USING (region_ID)
WHERE
    date_vente >= '2020-01-01'
    AND date_vente <= '2020-03-31'
GROUP BY commune.Code_Commune
HAVING COUNT(vente.ID_vente) >= 50
ORDER BY commune.Code_Commune DESC;