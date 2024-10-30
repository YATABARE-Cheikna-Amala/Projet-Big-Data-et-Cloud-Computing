
DROP TABLE IF EXISTS `bien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `bien` (
  `Id_bien` int NOT NULL,
  `Type_Local` varchar(15) NOT NULL,
  `Surface_Bati` float NOT NULL,
  `Nombre_Piece_Princ` int NOT NULL,
  `Code_Commune` int DEFAULT NULL,
  PRIMARY KEY (`Id_bien`),
  KEY `Code_Commune_idx` (`Code_Commune`),
  CONSTRAINT `Code_Commune` FOREIGN KEY (`Code_Commune`) REFERENCES `commune` (`Code_Commune`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `commune`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `commune` (
  `Code_Commune` int NOT NULL,
  `Nom_Com` varchar(50) NOT NULL,
  `depart_ID` int DEFAULT NULL,
  PRIMARY KEY (`Code_Commune`),
  KEY `depart_ID_idx` (`depart_ID`),
  CONSTRAINT `depart_ID` FOREIGN KEY (`depart_ID`) REFERENCES `departement` (`depart_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `departement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `departement` (
  `depart_ID` int NOT NULL,
  `Nom_Depart` varchar(50) NOT NULL,
  `region_ID` int DEFAULT NULL,
  PRIMARY KEY (`depart_ID`),
  KEY `region_ID_idx` (`region_ID`),
  CONSTRAINT `region_ID` FOREIGN KEY (`region_ID`) REFERENCES `region` (`region_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `region` (
  `region_ID` int NOT NULL,
  `nom_region` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`region_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `vente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `vente` (
  `ID_vente` int NOT NULL AUTO_INCREMENT,
  `ID_bien` int DEFAULT NULL,
  `date_vente` date NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ID_vente`),
  KEY `ID_bien_idx` (`ID_bien`),
  CONSTRAINT `ID_bien` FOREIGN KEY (`ID_bien`) REFERENCES `bien` (`Id_bien`)
) ENGINE=InnoDB AUTO_INCREMENT=34956 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;