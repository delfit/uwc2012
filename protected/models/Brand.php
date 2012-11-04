<?php

/**
 * This is the model class for table "Brand".
 *
 * The followings are the available columns in table 'Brand':
 * @property integer $BrandID
 * @property string $Name
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class Brand extends CActiveRecord
{
	const CACHE_DURATION = 3600;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Brand the static model class
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
		return 'Brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'Name', 'unique' ),
			array( 'Name', 'required' ),
			array( 'Name', 'length', 'max'=>100 ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array( 'BrandID, Name', 'safe', 'on'=>'search' ),
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
			'products' => array(self::HAS_MANY, 'Product', 'BrandID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'BrandID' => 'Brand',
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

		$criteria->compare('BrandID',$this->BrandID);
		$criteria->compare('Name',$this->Name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	/**
	 * Получить локализированное название атрибута
	 * 
	 * @param type $attribute
	 * 
	 * @return локализированное название атрибута
	 */
	public function getAttributeLabel( $attribute ) {
		$label = parent::getAttributeLabel( $attribute );
		
		return Yii::t( strtolower( $this->tableSchema->name ), $label );
	}
	
	
	public function beforeSave() {
		// очищаем кеш при сохранении производителя
		$this->clearCache();
		
		return parent::beforeSave();
	}
	
	
	public function beforeDelete() {
		// очищаем кеш при удалении производителя
		$this->clearCache();
		
		return parent::beforeDelete();
	}
	
	
	// TODO вынести в поведение в модели оставить только название ключей
	/**
	 * Очищает кеш производителей
	 */
	public function clearCache() {
		$cacheKeys = array(
			'application.brand.getSingularList'
		);
		
		foreach( $cacheKeys as $cacheKey ) {
			Yii::app()->cache->delete( $cacheKey );
		}
	}
	
	
	/**
	 * Проверить используется ли бренд
	 * 
	 * @return boolean
	 */
	public function IsUsed() {
		return Product::model()->exists( 
			'BrandID = :brandID', 
			array( 
				':brandID' => $this->BrandID
			)
		);
	}
	
	
	/**
	 * Получить список брендов в виде простого списка
	 * 
	 * @return string
	 */
	public function getSingularList() {
		$cacheKey = 'application.brand.getSingularList';
		$singularList = Yii::app()->cache->get( $cacheKey );
		
		if( $singularList === false ) {
			$singularList = array();
			$brands = $this->findAll();
			foreach( $brands as $brand ) {
				$singularList[ $brand->BrandID ] = $brand->Name;
			}
			
			
			Yii::app()->cache->set( $cacheKey, $singularList, self::CACHE_DURATION );
		}

		
		return $singularList;
	}
}