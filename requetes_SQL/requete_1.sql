//REQUETE 1-A (appartement)
//L objectif de cette requête SQL est de fournir un aperçu des ventes d appartements entre le 1er janvier et le 30 juin 2020, en regroupant les résultats par région.

SELECT 
        Type_Local AS 'Type de bien',
        COUNT(Type_Local) AS 'Nombre de biens vendus',
        departement.region_ID AS 'Région',
        Nom_region AS 'Nom Région'
    FROM
        vente
        LEFT JOIN bien USING (ID_bien)
        LEFT JOIN commune USING (Code_Commune)
        LEFT JOIN departement USING (depart_ID)
        LEFT JOIN region USING (region_ID)
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'appartement'
    GROUP BY departement.region_ID, Type_Local
    ORDER BY COUNT(Type_Local) DESC
	
//REQUETE 1-B (maison)
//L objectif de cette requête SQL est de fournir un aperçu des ventes de maison entre le 1er janvier et le 30 juin 2020, en regroupant les résultats par région.

SELECT 
        Type_Local AS 'Type de bien',
        COUNT(Type_Local) AS 'Nombre de biens vendus',
        departement.region_ID AS 'Région',
        Nom_region AS 'Nom Région'
    FROM
        vente
        LEFT JOIN bien USING (ID_bien)
        LEFT JOIN commune USING (Code_Commune)
        LEFT JOIN departement USING (depart_ID)
        LEFT JOIN region USING (region_ID)
    WHERE
        (date_vente >= '2020-01-01')
        AND (date_vente <= '2020-06-30')
        AND LOWER(Type_Local) = 'maison'
    GROUP BY departement.region_ID, Type_Local
    ORDER BY COUNT(Type_Local) DESC