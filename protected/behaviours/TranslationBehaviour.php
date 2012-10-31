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
		
		// найти любой доступный перевод, если нет перевода на текущем языке
		if( empty( $translation ) ) {
			$translation = $model->getTranslation();
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
	 * @param integer $languageID (option) идентификатор языка, если не указан -- определяется первый доступный перевод
	 * 
	 * @return object
	 */
	public function getTranslation( $languageID = null ) {
		$model = $this->getOwner();
		$translationTable = $model->translationTableName();
		
		$criteria = new CDbCriteria( array(
			'condition' => $model->tableSchema->primaryKey . ' = :tablePk',
			'params' => array(
				':tablePk' => $this->getOwner()->getPrimaryKey(),
			)
		) );
		
		if( $languageID ) {
			if( !empty( $criteria->condition ) ) {
				$criteria->condition .= ' AND ';
			}
			
			$criteria->condition .= ' LanguageID = :languageID ';
			$criteria->params[ 'languageID' ] = $languageID;
		}
		
		$translation = $translationTable::model()->find( $criteria );
		
		
		return $translation;
	}
}
?>
