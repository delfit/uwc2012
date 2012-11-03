<?php

/**
 * This is the model class for table "Feature".
 *
 * The followings are the available columns in table 'Feature':
 * @property integer $FeatureID
 * @property integer $CategoryID
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property FeatureTranslation[] $featureTranslations
 * @property ProductHasFeatures[] $productHasFeatures
 */
class Feature extends CActiveRecord
{
	public $Name = '';
	public $Description = '';
	public $LanguageID = null;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feature the static model class
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
		return 'Feature';
	}
	
	/**
	 * @return таблица базы данных с переводами атрибутов
	 */
	public function translationTableName() {
		return 'FeatureTranslation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('CategoryID', 'required'),
			array('CategoryID', 'numerical', 'integerOnly'=>true, 'allowEmpty' => false ),
			array('Name, Description, LanguageID', 'safe' ),
			array( 'Name', 'length', 'max' => 100 ),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('FeatureID, CategoryID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'Category', 'CategoryID'),
			'featureTranslations' => array(self::HAS_MANY, 'FeatureTranslation', 'FeatureID'),
			'productHasFeatures' => array(self::HAS_MANY, 'ProductHasFeatures', 'FeatureID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'FeatureID' => 'Feature',
			'CategoryID' => 'Category',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('FeatureID',$this->FeatureID);
		$criteria->compare('CategoryID',$this->CategoryID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors() {
		return array_merge( parent::behaviors(), array(
			'application.behaviours.TranslationBehaviour'
		) );
	}
	
	/**
	 * Проверяет включает ли AR указанный атрибут с учетом атрибутов определенных в модели
	 * 
	 * @param string $name  название атрибута
	 * @return boolean
	 */
	public function hasAttribute( $name ) {
		if( property_exists( $this, $name ) ) {
			return true;
		}
		
		return parent::hasAttribute( $name );
	}
	
	
	/**
	 * Проверить используется ли характеристика
	 * 
	 * @return boolean
	 */
	public function IsUsed() {
		return ProductHasFeatures::model()->exists( 
			'FeatureID = :featureID', 
			array( 
				':featureID' => $this->FeatureID
			)
		);
	}
	
}