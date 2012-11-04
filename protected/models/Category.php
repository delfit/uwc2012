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
	const CACHE_DURATION = 3600;
	
	// поддерживаются категории трех уровней
	const CATEGORY_FIRST_LEVEL = 1;
	const CATEGORY_SECOND_LEVEL = 2;
	const CATEGORY_THIRD_LEVEL = 3;
	
	const CATEGORY_MAX_LEVEL = 3;
	
	// Интернационализированные свойства
	public $SingularName = '';
	public $PluralName = '';
	public $LanguageID = null;

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
			array( 'SingularName, LanguageID, PluralName', 'required' ),
			array( 'SingularName, PluralName', 'length', 'max'=>100 ),
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
		if( $this->hasErrors() ) {
			return false;
		}
		
		// очищаем кеш при сохранении категории
		$this->clearCache();
		
		return parent::beforeSave();
	}
	
	
	public function beforeDelete() {
		// очищаем кеш при удалении катерогии
		$this->clearCache();
		
		return parent::beforeDelete();
	}
	
	
	/**
	 * Очищает кеш категорий
	 */
	public function clearCache() {
		// добавить динамические ключи
		$languages = Language::model()->getAll();
		$categoryLanguageCacheKey = 'application.category.getList.LanguageCode.';
		foreach( $languages as $language ) {
			$cacheKeys[] = $categoryLanguageCacheKey . $language->Code;
		}
		
		foreach( $cacheKeys as $cacheKey ) {
			Yii::app()->cache->delete( $cacheKey );
		}
	}
	
	
	/**
	 * Проверить используется ли категория
	 * 
	 * @return boolean
	 */
	public function isUsed() {
		return Product::model()->exists( 
			'CategoryID = :categoryID', 
			array( 
				':categoryID' => $this->CategoryID
			)
		);
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
	public function getList() {
		$cacheKey = 'application.category.getList.LanguageCode.' . Yii::app()->language;
		$categoriesAttr = Yii::app()->cache->get( $cacheKey );
		
		if( $categoriesAttr === false ) {
			$categoriesAttr = array();
		
			$categories = $this->findAll( 
				array(
					'condition' => '
						t.ParentCategoryID IS NULL
					'
				)
			);

			foreach( $categories as $category ) {
				$items = array();
				foreach( $category->subCategories as $subCategory ) {
					$items[] = array(
						'id' => $subCategory->CategoryID,
						'label' => $subCategory->PluralName,
					);

					foreach( $subCategory->subCategories as $lastLevelCategory ) {
						$items[] = array(
							'id' => $lastLevelCategory->CategoryID,
							'label' => $lastLevelCategory->PluralName,
							'url' => Yii::app()->createUrl( 'product/list', array( 'cid' => $lastLevelCategory->getPrimaryKey(), 'lc' => Yii::app()->language ) )
						);
					}

					$items[] = '---';
				}


				// убрать последний разделитель
				unset( $items[ count( $items ) - 1 ] );

				$categoriesAttr[] = array(
					'id' => $category->CategoryID,
					'label' => $category->PluralName,
					'items' => $items
				);
			}
			
			
			Yii::app()->cache->set( $cacheKey, $categoriesAttr, self::CACHE_DURATION );
		}
		
		
		return $categoriesAttr;
	}
	
	
	/**
	 * Сформировать одноуровневый список категорий
	 * 
	 * @param integer $levelCount  количество получаемых уровней в глубь
	 * @param array $skipLevels  номера уровней которые необходимо пропустить
	 * 
	 * @param array $categories  список категорий определенного уровня, применяется для рекурсивной обработки категорий
	 * @param integer $currentLevel  номер текущего уровня, применяется для рекурсивной обработки категорий
	 * @param string $parentCategoryName  полное название родительской категории, применяется для рекурсивной обработки категорий
	 * 
	 * @return array
	 */
	private function generateSingularList( $levelCount = self::CATEGORY_MAX_LEVEL, $skipLevels = array(), $categories = null, $currentLevel = 1, $parentCategoryName = '' ) {
		$categoriesSingularList = array();
		
		if( $currentLevel > $levelCount ) {
			return $categoriesSingularList;
		}
		
		if( is_null( $categories ) ) {
			$categories = $this->findAll(
				'ParentCategoryID IS NULL'
			);
		}
		
		foreach( $categories as $category ) {
			$fullPluralName = $parentCategoryName . ' ' . $category->PluralName;
			
			if( empty( $skipLevels ) || !in_array( $currentLevel, $skipLevels ) ) {
				$categoriesSingularList[ $category->CategoryID ] = $fullPluralName;
			}
			
			if( isset( $category->subCategories ) && !empty( $category->subCategories ) ) {
				$subCategoriesSingularList = $this->generateSingularList( $levelCount, $skipLevels, $category->subCategories, $currentLevel + 1, $fullPluralName );
				
				// объеденяем массивы с сохранением значений ключей
				foreach( $subCategoriesSingularList as $key => $value ) {
					$categoriesSingularList[ $key ] = $value;
				}
			}
		}
		
		
		return $categoriesSingularList;
	}
	
	
	/**
	 * Получить одноуровневый список категорий
	 * 
	 * @param integer $levelCount  количество получаемых уровней в глубь
	 * @param array $skipLevels  номера уровней которые необходимо пропустить
	 * 
	 * @return array
	 */
	public function getSingularList( $levelCount = self::CATEGORY_MAX_LEVEL, $skipLevels = array() ) {
		return $this->generateSingularList( $levelCount, $skipLevels );
	}
	
	
	/**
	 * Список ошибок одной строкой
	 * 
	 * @return string
	 */
	public function getErrorsAsString() {
		$strErrors = '';
		$errors = $this->getErrors();
		if( !empty( $errors ) ) {
			foreach( $errors as $attributeErrors ) {
				$strErrors .= implode( ' <br/> ', $attributeErrors );
			}
		}
		
		
		return $strErrors;
	}
	
	
	/**
	 * Получить полное название категории
	 * 
	 * @return string
	 */
	public function getFullName() {
		return $this->SingularName;
	}
}