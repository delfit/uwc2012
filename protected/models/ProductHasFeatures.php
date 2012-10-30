<?php

/**
 * This is the model class for table "ProductHasFeatures".
 *
 * The followings are the available columns in table 'ProductHasFeatures':
 * @property integer $ProductID
 * @property integer $FeatureID
 * @property integer $Index
 * @property string $Value
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Feature $feature
 */
class ProductHasFeatures extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductHasFeatures the static model class
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
		return 'ProductHasFeatures';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ProductID, FeatureID, Index, Value', 'required'),
			array('ProductID, FeatureID, Index', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ProductID, FeatureID, Index, Value', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'ProductID'),
			'feature' => array(self::BELONGS_TO, 'Feature', 'FeatureID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ProductID' => 'Product',
			'FeatureID' => 'Feature',
			'Index' => 'Index',
			'Value' => 'Value',
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

		$criteria->compare('ProductID',$this->ProductID);
		$criteria->compare('FeatureID',$this->FeatureID);
		$criteria->compare('Index',$this->Index);
		$criteria->compare('Value',$this->Value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}