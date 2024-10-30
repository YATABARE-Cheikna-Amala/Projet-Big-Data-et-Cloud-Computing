// Requete 5

// Pour savoir le nombre de vente du premier trimestre et du deuxième trimestre de 2020(CTE)
WITH Trim1 AS (
    SELECT COUNT(ID_bien) AS Ventes20Q1 
    FROM vente 
    WHERE date_vente >= '2020-01-01' AND date_vente <= '2020-03-31'
),
Trim2 AS (
    SELECT COUNT(ID_bien) AS Ventes20Q2 
    FROM vente 
    WHERE date_vente >= '2020-04-01' AND date_vente <= '2020-06-30'
)
SELECT Trim1.Ventes20Q1, Trim2.Ventes20Q2
FROM Trim1, Trim2;
