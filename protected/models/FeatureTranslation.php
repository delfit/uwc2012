<?php

/**
 * This is the model class for table "FeatureTranslation".
 *
 * The followings are the available columns in table 'FeatureTranslation':
 * @property integer $FeatureID
 * @property integer $LanguageID
 * @property string $Name
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property Feature $feature
 * @property Language $language
 */
class FeatureTranslation extends CActiveRecord
{


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FeatureTranslation the static model class
	 */
	public static function model( $className = __CLASS__ ) {
		return parent::model( $className );
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'FeatureTranslation';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'FeatureID, LanguageID, Name', 'required' ),
			array( 'FeatureID, LanguageID', 'numerical', 'integerOnly' => true ),
			array( 'Name', 'length', 'max' => 100 ),
			array( 'Description', 'safe' ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array( 'FeatureID, LanguageID, Name, Description', 'safe', 'on' => 'search' ),
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'feature' => array( self::BELONGS_TO, 'Feature', 'FeatureID' ),
			'language' => array( self::BELONGS_TO, 'Language', 'LanguageID' ),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'FeatureID' => 'Feature',
			'LanguageID' => 'Language',
			'Name' => 'Name',
			'Description' => 'Description',
		);
	}


	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare( 'FeatureID', $this->FeatureID );
		$criteria->compare( 'LanguageID', $this->LanguageID );
		$criteria->compare( 'Name', $this->Name, true );
		$criteria->compare( 'Description', $this->Description, true );

		return new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
		));
	}


	public function primaryKey() {
		return array(
			'FeatureID',
			'LanguageID'
		);
	}

}