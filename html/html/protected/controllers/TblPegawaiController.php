<?php

class TblPegawaiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*','yuli'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin','yuli'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TblPegawai;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblPegawai']))
		{
			$model->attributes=$_POST['TblPegawai'];
			
			$nip  = $_POST['TblPegawai']['nip'];
			$nama = $_POST['TblPegawai']['nama'];
			$alamat = $_POST['TblPegawai']['alamat'];
			$tanggal_lahir = $_POST['TblPegawai']['tanggal_lahir'];
			$agama = $_POST['TblPegawai']['agama'];
			$cmd = Yii::app()->db->createCommand();
			$cmd->insert('tbl_pegawai',array('nip'=>$nip,
						'nama'=>$nama, 'alamat'=>$alamat, 
						'tanggal_lahir'=>$tanggal_lahir,'agama'=>$agama));
			$this->redirect(array('admin'));
			if($model->save())
				$this->redirect(array('view','nip'=>$model->nip));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TblPegawai']))
		{
			$model->attributes=$_POST['TblPegawai'];
			$nip  = $_POST['TblPegawai']['nip'];
			$nama = $_POST['TblPegawai']['nama'];
			$alamat = $_POST['TblPegawai']['alamat'];
			$tanggal_lahir = $_POST['TblPegawai']['tanggal_lahir'];
			$agama = $_POST['TblPegawai']['agama'];
			$cmd = Yii::app()->db->createCommand();
			$cmd->update('tbl_pegawai',array('nama'=>$nama, 'alamat'=>$alamat, 
						'tanggal_lahir'=>$tanggal_lahir,'agama'=>$agama), 'nip=:nip', array(':nip'=>$nip));
			$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$cmd = Yii::app()->db->createCommand();
			$cmd->delete('tbl_pegawai','nip=:nip', array(':nip'=>$id));

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TblPegawai');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TblPegawai('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TblPegawai']))
			$model->attributes=$_GET['TblPegawai'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TblPegawai the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TblPegawai::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TblPegawai $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tbl-pegawai-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
