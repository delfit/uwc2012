<?php
class TranslationBehaviour extends CActiveRecordBehavior {
	
	/**
	 * Загрузить перевод для атрибутов
	 */
	public function afterFind( $event ) {
		parent::afterFind( $event );
		
		$model = $this->getOwner();
		
		// найти перевод на текущем языке
		$language = Language::model()->getCurrentLanguage();
		if( !empty( $language ) ) {
			$translation = $model->getTranslation( $language->LanguageID );
		}
		
		// найти перевод на языке по умолчанию, если нету перевода на текущем языке
		if( empty( $translation ) ) {
			$defaultLanguage = Language::model()->getDefaultLanguage();
			if( !empty( $defaultLanguage ) ) {
				$translation = $model->getTranslation( $defaultLanguage->LanguageID );
			}
		}

		// заполнить интернационализированные свойства
		if( !empty( $translation ) ) {
			foreach( $translation->attributes as $attributeName => $attributeValue ) {
				if( property_exists( $model, $attributeName ) ) {
					$model->{$attributeName} = $attributeValue;
				}
			}
		}

	}
	
	
	/**
	 * Получить перевод на указанном языке
	 * 
	 * @param integer $languageID  идентификатор языка
	 * 
	 * @return object
	 */
	public function getTranslation( $languageID ) {
		$model = $this->getOwner();
		$translationTable = $model->translationTableName();
		$translation = $translationTable::model()->find(
			$model->tableSchema->primaryKey . ' = :tablePk AND LanguageID = :languageID',
			array(
				':tablePk' => $this->getOwner()->getPrimaryKey(),
				':languageID' => $languageID
			)
		);
		
		
		return $translation;
	}
}
?>
