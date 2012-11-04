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
 * @property string $LastModified
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
	public $Image = null;

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
				array( 'Image', 'file', 'allowEmpty'=>true,'types'=>'jpg, gif, png' ),
				array( 'Image, LastModified', 'safe' ),				
                array( 'Name', 'length', 'max' => 100 ),
				array( 'Name', 'match', 'pattern' => '([a-zA-Z0-9_() ])', 'allowEmpty' => false ),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array( 'ProductID, CategoryID, BrandID, Name, IsDraft, LastModified', 'safe', 'on' => 'search' ),
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
			'productHasImages' => array( self::HAS_MANY, 'ProductHasImages', 'ProductID', 'order' => 'productHasImages.Index ASC' ),
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
				'LastModified' => 'LastModified',
				'Image' => 'Image'
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
		$criteria->compare( 'LastModified', $this->LastModified );

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
		$this->LastModified = date( 'Y-m-d H:i:s' ); 		
		return parent::beforeSave();
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
	
	
	/**
	 * Обновить характеристики товара
	 * 
	 * @param array $fraturesIDs  идентификаторы характеристик
	 * @param array $featuresValues  значения характеристик
	 * 
	 * @return boolean
	 */
	public function updateFeatures( $fraturesIDs, $featuresValues ) {
		$transactionProductHasFeatures = ProductHasFeatures::model()->dbConnection->beginTransaction();
		try {
			foreach( $fraturesIDs as $featureIndex => $fratureID ) {
				$currentProductFeature = ProductHasFeatures::model()->find(
					'FeatureID = :featureID AND ProductID = :productID',
					array(
						':featureID' => $fratureID,
						':productID' => $this->ProductID,
					)
				);
				
				if( empty( $currentProductFeature ) ) {
					$currentProductFeature = new ProductHasFeatures();
					$currentProductFeature->FeatureID = $fratureID;
					$currentProductFeature->ProductID = $this->ProductID;
				}
				
				if( isset( $featuresValues[ $featureIndex ] ) ) {
					$currentProductFeature->Index = ProductHasFeatures::model()->getNextIndex( $this->ProductID );
					$currentProductFeature->Value = $featuresValues[ $featureIndex ];
				}
				
				
				if( !$currentProductFeature->save( true ) ) {
					$this->addErrors(  $currentProductFeature->getErrors() );
					break;
				}
			}
			
			$transactionProductHasFeatures->commit();
			
			return true;
		}
		catch( Exception $exception ) {
			$transactionProductHasFeatures->rollback();
			
			return false;
		}
	}
	
	
	/**
	 * Добавить изображение товара
	 * 
	 * @return boolean
	 */
	public function saveImage() {
		if( !empty( $this->Image ) ) {
			$this->Image = CUploadedFile::getInstance( $this,'Image' );
			
			$maxIndexProductImage = ProductHasImages::model()->find( 
				array(
					'condition' => 't.ProductID = :productID',
					'params' => array(
						':productID' => $this->ProductID
					),
					'order' => 't.Index DESC'
				)
			);
			
			$maxIdProductImage = ProductHasImages::model()->find(
				array(
					'condition' => 't.ProductID = :productID',
					'params' => array(
						':productID' => $this->ProductID
					),
					'order' => 't.ProductHasImagesID DESC'
				)
			);
			
			$maxIndex = 1;
			if( !empty( $maxIndexProductImage ) ) {
				$maxIndex = $maxIndexProductImage->Index + 1;
			}
			
			$nextID = 1;
			if( !empty( $maxIdProductImage ) ) {
				$nextID = $maxIdProductImage->ProductHasImagesID;
			}
			
			$productImageAlias = '';
			if( true ) {
				$productImageAlias .= $this->Name;
				$productImageAlias = str_replace( array( '+', '-', '*', '@', '#', '%', '=', '?', '!', ';', '.', '/', ' ', '(', ')' ), '_', $productImageAlias );
			}
			
			$productImageFileName = $productImageAlias . '_' . $this->ProductID . '_' . $nextID . '.' . $this->Image->extensionName;
			
			
			
			$newProductImage = new ProductHasImages();
			$newProductImage->Index = $maxIndex;
			$newProductImage->ProductID = $this->ProductID;
			$newProductImage->FileName = $productImageFileName;

			if( $newProductImage->save( true ) ) {
				$productImageFileName = Yii::app()->params[ 'imagesFolder' ] . '/' . $productImageFileName;
				$this->Image->saveAs( $productImageFileName );
				
				return true;
			}
			else {
				$this->addError( 'Image', $newProductImage->getError( 'FileName' ) );
				return false;
			}
		}		

		
		return false;
	}
	
	
	/**
	 * Обновить список изображений ( удалить, пересортировать )
	 * 
	 * @param array $productImagesIDs  идентификаторы изображений товара
	 */
	public function updateImages( $productImagesIDs ) {
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$indexes = array_flip( $productImagesIDs );			
			foreach( $this->productHasImages as $currentProductImage ) {
				if( in_array( $currentProductImage->ProductHasImagesID, $productImagesIDs ) ) {
					$currentProductImage->Index = $indexes[ $currentProductImage->ProductHasImagesID ];
					if( !$currentProductImage->save( true ) ) {		
						$error = Yii::t( 'product', 'Can not update images' );
						$this->addError( 'Image', $error );
						throw new Exception( $error );
					}
				}
				else {
					$currentImageFileName = Yii::app()->params[ 'imagesFolder' ] . '/' . $currentProductImage->FileName;
					if( file_exists( $currentImageFileName ) ) {
						unlink( $currentImageFileName );
					}
					
					$currentProductImage->delete();
				}
			}
			
			$transaction->commit();
			
			return true;
		}
		catch( Exception $exception ) {
			$transaction->rollback();
			return false;
		}
	}
	
	
	/**
	 * Удаление товара вместе с файлами изображений и характеристиками
	 * 
	 * @return boolean
	 * 
	 * @throws Exception
	 */
	public function delete() {
		$transaction = Yii::app()->db->beginTransaction();
		try {

			// удалить все характеристики
			ProductHasFeatures::model()->deleteAll( 'ProductID = :productID',  array( ':productID' => $this->ProductID ) );


			// удалить прикрепленные изображения вместе с файлами
			foreach( $this->productHasImages as $productHasImage ) {
				$currentImageFileName = Yii::app()->params[ 'imagesFolder' ] . '/' . $productHasImage->FileName;
				if( file_exists( $currentImageFileName ) ) {
					unlink( $currentImageFileName );
				}
			}			
			ProductHasImages::model()->deleteAll( 'ProductID = :productID',  array( ':productID' => $this->ProductID ) );
			
			// удалить товар
			$success = parent::delete();
			
			$transaction->commit();
	
			return $success;
		}
		catch( Exception $exception ) {
			$transaction->rollback();
			
			return false;
		}
	}
	
	
	/**
	 * Определить адрес основного изображения товара
	 * 
	 * @return string
	 */
	public function getMainImageURL() {
		// TODO уточнить размеры картинок
		$mainImageUrl = 'http://placehold.it/300x200&text=Image+is+Not+Avaliable';
		if( isset( $this->productHasImages[ 0 ] ) ) {
			$mainImageUrl = Yii::app()->request->baseUrl . '/' . Yii::app()->params[ 'imagesFolder' ] . '/' . $this->productHasImages[ 0 ]->FileName;
		}
		
		return $mainImageUrl;
	}
	
	
	/**
	 * Получить полное название товара
	 * 
	 * @return string
	 */
	public function getFullName() {
		return $this->category->SingularName . ' ' . $this->brand->Name . ' ' . $this->Name;
	}
	
	
	/**
	 * Получить список характеристик товара
	 * 
	 * @return string характеристики товара строкой
	 */
	public function getFeatures() {
		$features = '';
		foreach( $this->productHasFeatures as $productHasFeature ) {
			if( !empty( $productHasFeature->Value ) ) {
				$features .= '<b>' . $productHasFeature->feature->Name . '</b>' . ': ' . $productHasFeature->Value . '; ';
			}			
		}
		
		
		return $features;
	}
	
	
	/**
	 * Список последних товаров из изображениями
	 * 
	 * @return array
	 */
	public function getCarouselProducts() {
		return  Product::model()->findAll( 
			array(
				'condition' => '
					(
						SELECT 
							count( * ) > 0
						FROM
							ProductHasImages
						WHERE
							ProductHasImages.ProductID = t.ProductID
					)
				',
				'order' => 'ProductID DESC', 
				'limit' => Yii::app()->params[ 'default' ][ 'countImagesPerCarousel' ]
			)			
		);
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
}
