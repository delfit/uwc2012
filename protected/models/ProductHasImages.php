<?php

/**
 * This is the model class for table "ProductHasImages".
 *
 * The followings are the available columns in table 'ProductHasImages':
 * @property integer $ProductHasImagesID
 * @property integer $ProductID
 * @property integer $Index
 * @property string $FileName
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class ProductHasImages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductHasImages the static model class
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
		return 'ProductHasImages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ProductID, Index, FileName', 'required'),
			array('ProductID, Index', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ProductHasImagesID, ProductID, Index, FileName', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ProductHasImagesID' => 'Product Has Images',
			'ProductID' => 'Product',
			'Index' => 'Index',
			'FileName' => 'File Name',
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

		$criteria->compare('ProductHasImagesID',$this->ProductHasImagesID);
		$criteria->compare('ProductID',$this->ProductID);
		$criteria->compare('Index',$this->Index);
		$criteria->compare('FileName',$this->FileName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}