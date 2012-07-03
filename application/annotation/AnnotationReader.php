<?php
namespace wswds\annotation;
/**
 *
 * @author jerep6
 */
class AnnotationReader {
	/**
	 * Retourne la valeur de l'annotation passée dans le dernier paramètre. La valeur signifie le contenu entre crochets
	 * @param string $comment commentaire à analyser
	 * @param string $annotationName nom complet de l'annotation (pas besoin d'échapper les \)
	 */
	public static function getPropertyAnnotation($comment, $annotationName) {
		$annotationName = addslashes($annotationName);

		//Split selon le saut de ligne
 		$comments = preg_split('#\n#', $comment);

 		$contenu = "";
 		//Détermine la ligne ayant l'annotation souhaitée
		foreach($comments as $comment_line) {
			if(preg_match("#".$annotationName."\((.*)\)#", $comment_line, $matches)) {
				$contenu = $matches[1];
			}
		}
		return $contenu;
	}

	/**
	 * Retourne la valeur du champ de l'annotation de la propriété passé en paramètre
	 * @param \ReflectionProperty $property attribut de classe
	 * @param string $annotationName nom complet de l'annotation dans laquelle chercher le paramètre
	 * @param string $nameOfParam nom du paramètre dont on souhaite la valeur
	 */
	public static function getParamValueAnnotation($reflectionElement, $annotationName, $nameOfParam) {
		$contenu = AnnotationReader::getPropertyAnnotation($reflectionElement->getDocComment(), $annotationName);
		return AnnotationReader::extract($contenu, $nameOfParam);
	}

	private static function extract($contenu, $nameOfParam) {
		$retour = NULL;

		if(preg_match_all("#(\w*)=(\w*)#", $contenu, $matches, PREG_SET_ORDER)) {
			foreach($matches as $unMatch) {
				if($unMatch[1] == $nameOfParam) {
					$retour =  $unMatch[2];
				}
			}
		}

		return $retour;
	}



	/**
	 * Retourne le nom de l'attribut ayant la valeur du paramètre spécifié
	 * @param string $nameOfClass nom de la classe dans laquelle chercher
	 * @param string $annotationName nom de l'annotation dans laquelle chercher
	 * @param string $nameOfParam nom du paramètre contenant la valeur
	 * @param string $valueOfParam valeur du paramètre cherché
	 */
	public static function getAttributeName($nameOfClass, $annotationName, $nameOfParam, $valueOfParam) {
		$reflection = new \ReflectionClass($nameOfClass);
		foreach($reflection->getProperties() as $property) {
			//Extraction du contenu de l'annotation
			$contenu = AnnotationReader::getPropertyAnnotation($property->getDocComment(), $annotationName);
			//Retourne la valeur du paramètre
			$valeurParam = AnnotationReader::extract($contenu, $nameOfParam);
			if($valeurParam == $valueOfParam) {
				return $property->getName();
			}
		}
	}


}

?>