<?php
use wswds\annotation\AnnotationReader;
require_once APPPATH."annotation/AnnotationReader.php";

/**
 * @author jerep6
 */
class MyORM {

	/**
	 * Retourne une instance de la classe contenant les données du tableau
	 * @param string $className nom de la classe
	 * @param array $array données à mapper dans l'objet
	 */
	public static function asObject($className, $array) {
		$object = new $className();

		foreach ($array as $key => $value) {
			$attributeName = AnnotationReader::getAttributeName($className, "@ORM\Column", "name", $key);
			if(!empty($attributeName)) {
				$object->{"set".ucfirst($attributeName)}($value);
			}
		}

		return $object;
	}

	/**
	 * Retourne un tableau contenant la chaine de caractère représentant la requête d'insertion et les paramètres
	 * de la reqûete.
	 * Le premier élément du tableau contient la requête et le deuxième contient le tableau des paramètres
	 * @param object $object
	 */
	public static function generateParameterInsert($object) {
		$reflec = new ReflectionObject($object);
		$className = AnnotationReader::getParamValueAnnotation($reflec, "@ORM\Entity", "table");

		$requeteFinale = "";
		$insert = "INSERT INTO $className (";
		$values = " VALUES (";
		$parameters = array();


		//Pour chaque attribut récupère le nom de la colonne en BD
		foreach($reflec->getProperties() as $property) {
			$property->setAccessible(true);
			$columnName = AnnotationReader::getParamValueFieldAnnotation($property, "@ORM\Column", "name");
			// Si pas de nom de colonne trouvé cela signifie que l'attribut n'a pas de correspondance en BD
			if(!empty($columnName)) {
				$insert = "$insert$columnName,";
				$values = "$values?,";
				array_push($parameters, $property->getValue($object));
			}

		}
		//Supprime la dernière virgule et rajoute la parenthèse fermante
		$requeteFinale = substr("$insert", 0, -1).")".substr("$values", 0, -1).");";
		return array($requeteFinale, $parameters);
	}

	/**
	 * Retourne un tableau contenant la chaine de caractère représentant la requête de mise à jour et les paramètres
	 * de la reqûete.
	 * Le premier élément du tableau contient la requête et le deuxième contient le tableau des paramètres
	 * @param object $object
	 * @param string $where restriction de l'update
	 */
	public static function generateParameterUpdate($object, $where) {
		$reflec = new ReflectionObject($object);
		$className = AnnotationReader::getParamValueAnnotation($reflec, "@ORM\Entity", "table");

		$requete = "UPDATE $className SET";
		$parameters = array();

		//Pour chaque attribut récupère le nom de la colonne en BD
		foreach($reflec->getProperties() as $property) {
			$property->setAccessible(true);
			$columnName = AnnotationReader::getParamValueAnnotation($property, "@ORM\Column", "name");
			// Si pas de nom de colonne trouvé cela signifie que l'attribut n'a pas de correspondance en BD
			if(!empty($columnName)) {
				$requete = "$requete $columnName=?,";
				array_push($parameters, $property->getValue($object));
			}

		}
		//Supprime la dernière virgule
		$requete = substr("$requete", 0, -1);
		return array("$requete $where;", $parameters);
	}
}

?>