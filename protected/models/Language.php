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
	
	public function getCurrentLanguage() {
		return $this->findByCode( Yii::app()->language );
	}
	
	
	/**
	 * Получить модель языка по его коду
	 * 
	 * @param string $languageCode  код языка ( en, uk, ru )
	 * 
	 * @return object
	 */
	public function findByCode( $languageCode ) {
		$languageModel = $this->find( 
			'Code = :languageCode', 
			array( 
				':languageCode' => $languageCode 
			)
		);
		
		return $languageModel;
	}
}