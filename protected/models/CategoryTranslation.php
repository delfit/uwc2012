<?php

/**
 * This is the model class for table "CategoryTranslation".
 *
 * The followings are the available columns in table 'CategoryTranslation':
 * @property integer $CategoryID
 * @property integer $LanguageID
 * @property string $SingularName
 * @property string $PluralName
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Language $language
 */
class CategoryTranslation extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoryTranslation the static model class
	 */
	public static function model( $className = __CLASS__ ) {
		return parent::model( $className );
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'CategoryTranslation';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'CategoryID, LanguageID, SingularName, PluralName', 'required' ),
			array( 'CategoryID, LanguageID', 'numerical', 'integerOnly' => true ),
			array( 'SingularName, PluralName', 'length', 'max' => 100 ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array( 'CategoryID, LanguageID, SingularName, PluralName', 'safe', 'on' => 'search' ),
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'category' => array( self::BELONGS_TO, 'Category', 'CategoryID' ),
			'language' => array( self::BELONGS_TO, 'Language', 'LanguageID' ),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'CategoryID' => 'Category',
			'LanguageID' => 'Language',
			'SingularName' => 'Singular Name',
			'PluralName' => 'Plural Name',
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

		$criteria->compare( 'CategoryID', $this->CategoryID );
		$criteria->compare( 'LanguageID', $this->LanguageID );
		$criteria->compare( 'SingularName', $this->SingularName, true );
		$criteria->compare( 'PluralName', $this->PluralName, true );

		return new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
		));
	}


	public function primaryKey() {
		return array(
			'CategoryID',
			'LanguageID'
		);
	}

}