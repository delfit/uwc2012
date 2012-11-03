<?php

/**
 * This is the model class for table "Language".
 *
 * The followings are the available columns in table 'Language':
 * @property integer $LanguageID
 * @property string $Code
 * @property string $Name
 *
 * The followings are the available model relations:
 * @property CategoryTranslation[] $categoryTranslations
 * @property FeatureTranslation[] $featureTranslations
 * @property ProductTranslation[] $productTranslations
 */
class Language extends CActiveRecord
{
	const CACHE_DURATION = 3600;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Language the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Language';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Code, Name', 'required'),
			array('Code', 'length', 'max'=>3),
			array('Name', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('LanguageID, Code, Name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'categoryTranslations' => array(self::HAS_MANY, 'CategoryTranslation', 'LanguageID'),
			'featureTranslations' => array(self::HAS_MANY, 'FeatureTranslation', 'LanguageID'),
			'productTranslations' => array(self::HAS_MANY, 'ProductTranslation', 'LanguageID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'LanguageID' => 'Language',
			'Code' => 'Code',
			'Name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LanguageID',$this->LanguageID);
		$criteria->compare('Code',$this->Code,true);
		$criteria->compare('Name',$this->Name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		// очищаем кеш при сохранении языка
		$this->clearCache();
		
		return parent::beforeSave();
	}
	
	
	public function beforeDelete() {
		// очищаем кеш при удалении языка
		$this->clearCache();
		
		return parent::beforeDelete();
	}
	
	
	// TODO вынести в поведение в модели оставить только название ключей
	/**
	 * Очищает кеш языков
	 */
	public function clearCache() {
		$cacheKeys = array(
			'application.language.getAll',
			'application.language.getSingularList',
		);
		
		// добавить динамические ключи
		$languages = $this->findAll();
		$currentLanguageCacheKey = 'application.language.getCurrentLanguage.LanguageCode.';
		foreach( $languages as $language ) {
			$cacheKeys[] = $currentLanguageCacheKey . $language->Code;
		}
		
		foreach( $cacheKeys as $cacheKey ) {
			Yii::app()->cache->delete( $cacheKey );
		}
	}
		
	
	/**
	 * Получить список языков
	 * 
	 * @return array
	 */
	public function getList() {
		return $this->findAll( array(
			'order' => '"t"."Name"'
		) );
	}
	
	
	/**
	 * Определить текщий язык
	 * 
	 * @return object Language
	 */
	public function getCurrentLanguage() {		
		return $this->findByCode( Yii::app()->language );
	}
	
	
	/**
	 * Определить идентификатор текущего языка
	 * 
	 * @return integer
	 */
	public function getCurrentLanguageID() {
		$currentLanguage =  $this->getCurrentLanguage();
		if( isset( $currentLanguage->LanguageID ) ) {
			return $currentLanguage->LanguageID;
		}
		
		return null;
	}
	
	
	/**
	 * Получить модель языка по его коду
	 * 
	 * @param string $languageCode  код языка ( en, uk, ru )
	 * 
	 * @return object
	 */
	public function findByCode( $languageCode ) {
		$cacheKey = 'application.language.getCurrentLanguage.LanguageCode.' . $languageCode;
		$language = Yii::app()->cache->get( $cacheKey );
		
		if( $language === false ) {
			$language = $this->find( 
				'Code = :languageCode', 
				array( 
					':languageCode' => $languageCode 
				)
			);
		
			
			Yii::app()->cache->set( $cacheKey, $language, self::CACHE_DURATION );
		}
		
		
		return $language;
	}
	
	
	/**
	 * Получить список языков в виде простого списка
	 * 
	 * @return string
	 */
	public function getSingularList() {
		$cacheKey = 'application.language.getSingularList';
		$singularList = Yii::app()->cache->get( $cacheKey );
		
		if( $singularList === false ) {
			$singularList = array();
			$languages = $this->findAll();
			foreach( $languages as $language ) {
				$singularList[ $language->LanguageID ] = $language->Code . ' ' . $language->Name;
			}
			
			
			Yii::app()->cache->set( $cacheKey, $singularList, self::CACHE_DURATION );
		}

		
		return $singularList;
	}
	
	
	/**
	 * Список всех языков из кеша
	 * 
	 * @return type
	 */
	public function getAll() {
		$cacheKey = 'application.language.getAll';
		$languages = Yii::app()->cache->get( $cacheKey );
		
		if( $languages === false ) {
			$languages = $this->findAll();
			
			
			Yii::app()->cache->set( $cacheKey, $languages, self::CACHE_DURATION );
		}
		
		
		return $languages;
	}
}