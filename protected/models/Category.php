<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property integer $CategoryID
 * @property integer $ParentCategoryID
 *
 * The followings are the available model relations:
 * @property Category $parentCategory
 * @property Category[] $categories
 * @property CategoryTranslation[] $categoryTranslations
 * @property Feature[] $features
 * @property Product[] $products
 */
class Category extends CActiveRecord
{
	// поддерживаются категории трех уровней

	const CATEGORY_MAX_LEVEL = 3;
	
	// Интернационализированные свойства
	public $SingularName = '';
	public $PluralName = '';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model( $className = __CLASS__ ) {
		return parent::model( $className );
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'Category';
	}
	
	
	/**
	 * @return таблица базы данных с переводами атрибутов
	 */
	public function translationTableName() {
		return 'CategoryTranslation';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'ParentCategoryID', 'numerical', 'integerOnly' => true ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array( 'CategoryID, ParentCategoryID', 'safe', 'on' => 'search' ),
		);
	}


	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parentCategory' => array( self::BELONGS_TO, 'Category', 'ParentCategoryID' ),
			'subCategories' => array( self::HAS_MANY, 'Category', 'ParentCategoryID' ),
			'categoryTranslations' => array( self::HAS_MANY, 'CategoryTranslation', 'CategoryID' ),
			'features' => array( self::HAS_MANY, 'Feature', 'CategoryID' ),
			'products' => array( self::HAS_MANY, 'Product', 'CategoryID' ),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'CategoryID' => 'Category',
			'ParentCategoryID' => 'Parent Category',
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
		$criteria->compare( 'ParentCategoryID', $this->ParentCategoryID );

		return new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
		) );
	}
	
	
	public function behaviors() {
		return array_merge( parent::behaviors(), array(
			'application.behaviours.TranslationBehaviour'
		) );
	}
	
	
	/**
	 * Список категорий
	 * 
	 * @param integer $languageID  идентификатор языка
	 * @param array $categories  список начальных категорий ( используется для получения вложенных категорий )
	 * @param int $level  уровень вложености категорий ( используется для получения вложенных категорий )
	 * 
	 * @return array
	 */
	public function getList( $languageID, $categories = null, $level = 1 ) {
		// не получать категории находящиеся глубже максимальной вложености
		if( $level > self::CATEGORY_MAX_LEVEL ) {
			return;
		}
		
		$categoriesAttr = array();
		if( is_null( $categories ) ) {
			$categories = $this->findAll( 
				array(
					'condition' => '
						t.ParentCategoryID IS NULL
					',
//					'order' => array(
//						''
//					)
				)
			);
		}
	
		foreach( $categories as $category ) {
			$categoriesAttr[] = array(
				'label' => $category->PluralName,
				'url' => ( $level == self::CATEGORY_MAX_LEVEL ) ? 'products?cid/' . $this->getPrimaryKey() : '#'
			);
			$level += 1;
			$categoriesAttr[ 'items' ] = $this->getList( $languageID, $category->subCategories, $level );
		}
		
		
		return $categoriesAttr;
	}

}