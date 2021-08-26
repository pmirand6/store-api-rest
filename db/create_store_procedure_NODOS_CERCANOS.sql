DELIMITER $$
CREATE PROCEDURE `SP_NODOS_CERCANOS`(IN `idAddress` int, IN `km` int, IN `scope` INT)
BEGIN

  SET @latitudeClient = (SELECT
      a.latitude
    FROM addresses a
    WHERE id = idAddress);
  SET @longitudeClient = (SELECT
      a.longitude
    FROM addresses a
    WHERE id = idAddress);

  SELECT
	p.id,
	p.name,
	p.business_name,
	p.street_name,
	p.floor,
	p.department_number,
	prov.province,
    loc.locality,
	CONCAT((SELECT
		ROUND(FU_CALCULAR_DISTANCIA(@latitudeClient, p.latitude, @longitudeClient, p.longitude), 2))) AS distance_km
  FROM providers p
  INNER JOIN provider_types pt on pt.id = p.provider_types_id
  INNER JOIN localities loc on loc.id=p.localities_id
  INNER JOIN provinces prov on prov.id=loc.provinces_id
  WHERE pt.description="Nodo"
  HAVING distance_km <= km
  ORDER BY distance_km ASC
  LIMIT 0, scope;

END$$
DELIMITER ;
