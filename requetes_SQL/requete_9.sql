// Requete 9
/*L'objectif de cette requête SQL est d'extraire les 3 communes les plus chères par département pour plusieurs départements français sélectionnés, 
en se basant sur la valeur foncière moyenne des biens immobiliers vendus. Cette analyse permet de comparer la valeur foncière moyenne dans différentes 
communes au sein de chaque département, en mettant en évidence les communes ayant les prix moyens les plus élevés.*/

WITH OrdreCommunesParDept AS(
SELECT departement.depart_ID AS 'Département', commune.Code_Commune AS Commune,  CONCAT(FORMAT(AVG(prix),2), ' EUR') AS 'Valeur foncière moyenne',
RANK() OVER(PARTITION BY departement.depart_ID ORDER BY AVG(prix) DESC) AS 'Classement'
FROM bien
LEFT JOIN vente USING (ID_bien)
LEFT JOIN commune USING (Code_Commune)
LEFT JOIN departement USING (depart_ID)
GROUP BY Code_Commune
)
SELECT * FROM OrdreCommunesParDept
WHERE ((Classement <=3) AND (Département = '06')) OR ((Classement <=3) AND (Département = '13')) OR ((Classement <=3) AND (Département = '33')) OR ((Classement <=3) AND (Département = '59')) OR ((Classement <=3) AND (Département = '69'))
;