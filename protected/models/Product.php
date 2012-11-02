<?php

/**
 * This is the model class for table "Product".
 *
 * The followings are the available columns in table 'Product':
 * @property integer $ProductID
 * @property integer $CategoryID
 * @property integer $BrandID
 * @property string $Name
 * @property integer $IsDraft
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property Brand $brand
 * @property ProductHasFeatures[] $productHasFeatures
 * @property ProductHasImages[] $productHasImages
 * @property ProductTranslation[] $productTranslations
 */
class Product extends CActiveRecord
{

	public $Description = '';
	public $LanguageID = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model( $className = __CLASS__ ) {
            return parent::model( $className );
	}
	

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
            return 'Product';
	}
	

	/**
	 * @return таблица базы данных с переводами атрибутов
	 */
	public function translationTableName() {
		return 'ProductTranslation';
	}
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array( 'CategoryID, BrandID, Name', 'required' ),
                array( 'CategoryID, BrandID, IsDraft', 'numerical', 'integerOnly' => true ),
                array( 'LanguageID, Description', 'safe' ),
				
                array( 'Name', 'length', 'max' => 100 ),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array( 'ProductID, CategoryID, BrandID, Name, IsDraft', 'safe', 'on' => 'search' ),
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
			'brand' => array( self::BELONGS_TO, 'Brand', 'BrandID' ),
			//'features' => array( self::MANY_MANY, 'Feature', 'ProductHasFeatures(ProductID,FeatureID)' ),
			'productHasFeatures' => array( self::HAS_MANY, 'ProductHasFeatures', 'ProductID' ),
			'productHasImages' => array( self::HAS_MANY, 'ProductHasImages', 'ProductID', 'order' => 'productHasImages.Index DESC', 'limit' => Yii::app()->params[ 'default' ][ 'countImagesPerProduct' ] ),
			'productTranslations' => array( self::HAS_MANY, 'ProductTranslation', 'ProductID' ),
		);
	}
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
            return array(
                'ProductID' => 'Product',
                'CategoryID' => 'Category',
                'BrandID' => 'Brand',
                'Name' => 'Name',
                'IsDraft' => 'Is Draft',
            );
	}
	

	/**
	 * Retrieves a list of models based on the current search/filter coFeaturenditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria = new CDbCriteria;

            $criteria->compare( 'ProductID', $this->ProductID );
            $criteria->compare( 'CategoryID', $this->CategoryID );
            $criteria->compare( 'BrandID', $this->BrandID );
            $criteria->compare( 'Name', $this->Name, true );
            $criteria->compare( 'IsDraft', $this->IsDraft );

		return new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
		));
	}
	

	public function behaviors() {
		return array_merge( parent::behaviors(), array(
			'application.behaviours.TranslationBehaviour'
		));
	}
        
        
        /**
         * Получить список товаро соответствующих критерию
         * 
         * @param string $query
         * @param integer $categoryID
         * 
         * @return CActiveDataProvider
         */
        public function searchList( $query, $categoryID = null ) {
            // убрать лишние символы
            // TODO убрать пробелы встречающиеся больше одного раза
            $query = str_replace( ' ', '%', $query );
            
            
            // формирование условия получения данных по которым производится поиск
            $criteria = new CDbCriteria( array(
                'condition' => '
                    CONCAT_WS( \' \',
                        (
                            SELECT 
                                CategoryTranslation.PluralName
                            FROM 
                                CategoryTranslation
                            WHERE
                                CategoryTranslation.CategoryID = t.CategoryID AND
                                CategoryTranslation.LanguageID = :currentLanguageID
                            LIMIT 1
                        ),  
                        brand.Name,
                        t.Name,
                        (
                            SELECT 
                                ProductTranslation.Description
                            FROM 
                                ProductTranslation
                            WHERE
                                ProductTranslation.ProductID = t.ProductID AND
                                ProductTranslation.LanguageID = :currentLanguageID
                            LIMIT 1
                        ),
                        (
                            SELECT 
                                    GROUP_CONCAT( Value separator \' \' )
                            FROM 
                                    ProductHasFeatures 
                            WHERE 
                                    ProductHasFeatures.ProductID = t.ProductID
                        )
                    ) like :query
                ',
                'params' => array(
                    ':query' => '%'. $query . '%',
                    ':currentLanguageID' => 2
                ),

                'with' => array(
                    'brand',
                    'category',
                )
            ) );
            
            if( !empty( $categoryID ) ) {
                if( !empty( $criteria->condition ) ) {
                    $criteria->condition .= ' AND ';
                }
                
                $criteria->condition .= ' t.CategoryID = :categoryID ';
                $criteria->params[ ':categoryID' ] = $categoryID;
            }
            
            $products = new CActiveDataProvider( $this, array( 
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params[ 'default' ][ 'pageSize' ],
                ),
            ));

            return $products;
        }
	

	/**
	 * Получить список товаров из категории
	 * 
	 * @param integer $CategoryID  идентификатор категории
	 * 
	 * @return CActiveDataProvider
	 */
	public function getList( $CategoryID ) {
		$criteria = new CDbCriteria( array(
			'condition' => 'CategoryID = :categoryID',
			'params' => array(
				':categoryID' => $CategoryID
			),
			'with' => array(
				'productHasFeatures'
			),
		));

		$products = new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->params[ 'default' ][ 'pageSize' ],
			),
		));
		

		return $products;
	}
	

	public function getView( $ProductID ) {
		
	}

}
