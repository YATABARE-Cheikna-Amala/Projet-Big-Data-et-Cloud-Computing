// REQUETE 4
//L objectif de cette requête SQL est d analyser la valeur foncière moyenne par mètre carré pour un certain type de bien immobilier dans une région spécifique, pour une période donnée. 
//Elle regroupe et structure les informations sur les biens vendus afin de donner une vue d ensemble sur les prix moyens des biens en fonction des régions et des types de biens

        SELECT 
            Type_Local AS 'Type de bien', /* Sélectionner le type de bien */
            CONCAT(FORMAT(AVG(prix / Surface_Bati), 2), ' EUR/m2') AS 'Valeur foncière moyenne', /* Calculer la valeur foncière moyenne par m² */
            region.region_ID AS 'Région', /* Récupérer l'ID de la région */
            Nom_region AS 'Nom Région' /* Récupérer le nom de la région */
        FROM
            vente /* Table des ventes */
        LEFT JOIN bien ON bien.ID_bien = vente.ID_bien /* Jointure avec la table des biens */
        LEFT JOIN commune ON bien.Code_Commune = commune.Code_Commune /* Jointure avec la table des communes */
        LEFT JOIN departement ON commune.depart_ID = departement.depart_ID /* Jointure avec la table des départements */
        LEFT JOIN region ON departement.region_ID = region.region_ID /* Jointure avec la table des régions */
        WHERE
            (date_vente >= '2020-01-01') /* Filtrer les ventes à partir du 1er janvier 2020 */
            AND (date_vente <= '2020-06-30') /* Filtrer les ventes jusqu'au 30 juin 2020 */
            AND LOWER(Type_Local) = '$type_bien' /* Filtrer par type de bien (insensible à la casse) */
            AND region.region_ID = '$region_id' /* Filtrer par ID de région */
        GROUP BY region.region_ID, Type_Local /* Regrouper par ID de région et type de bien */
